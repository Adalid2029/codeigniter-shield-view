<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Ssp;
use App\Models\AuthIdentitiesModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class SeguridadController extends BaseController
{
    private $seguridadModel = null;
    private $authIdentitiesModel = null;
    private $users;
    public function __construct()
    {
        $this->seguridadModel = new UserModel();
        $this->authIdentitiesModel = new AuthIdentitiesModel();
        $this->users = auth()->getProvider();
    }
    use ResponseTrait;
    public function seguridadUsuariosListar()
    {
        if ($this->request->isAJAX()) {
            return DataTable::of($this->seguridadModel->usuariosListar())
                ->add('action', function ($data) {
                    return '
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item edit-user" href="' . site_url(route_to('seguridad/usuarios/editar', $data->id)) . '">Editar</a></li>
                                    <li><a class="dropdown-item delete-user" href="' . site_url(route_to('seguridad/usuarios/eliminar', $data->id)) . '">Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                ';
                }, 'first')
                ->edit('active', function ($row) {
                    $isMathUser = $row->id == user_id() ? 'disabled' : '';
                    $checked = $row->active == 1 ? 'checked' : '';
                    return '
                        <div class="media-body text-end icon-state switch-outline">
                            <label class="switch">
                                <input class="active-user" type="checkbox" value="' . $row->active . '" data-url="' . site_url(route_to('seguridad/usuarios/activar', $row->id)) . '" data-kt-switch ' . $checked . ' ' . $isMathUser . '><span class="switch-state bg-primary"></span>
                            </label>
                        </div>
                    ';
                })
                ->edit('force_reset', function ($row) {
                    $isMathUser = $row->id == user_id() ? 'disabled' : '';
                    $checked = $row->force_reset == 1 ? 'checked' : '';
                    return '
                        <div class="media-body text-end icon-state switch-outline">
                            <label class="switch">
                                <input class="force-reset-password-user" type="checkbox" value="' . $row->force_reset . '" data-url="' . site_url(route_to('seguridad/usuarios/forzar-cambio-password', $row->id)) . '" data-kt-switch ' . $checked . ' ' . $isMathUser . '><span class="switch-state bg-primary"></span>
                            </label>
                        </div>
                    ';
                })
                ->hide('status')
                ->hide('status_message')
                // ->hide('created_at')
                ->toJson();
        }
        $data['urlAjax'] = site_url(route_to('seguridad/usuarios/listar'));
        $data['urlAdd'] = site_url(route_to('seguridad/usuarios/agregar'));
        return view('seguridad/usuarios/seguridad_usuarios_listar', $data);
    }
    public function seguridadUsuariosEditar($id): \CodeIgniter\HTTP\Response
    {
        $authGroupsConfig = config('AuthGroups');
        $data['urlSubmit'] = site_url(route_to('seguridad/usuarios/actualizar', $id));
        $data['group'] = array_keys($authGroupsConfig->groups);
        $data['permissions'] = array_keys($authGroupsConfig->permissions);
        $instanceUser = $this->users->findById($id);
        $user = $this->seguridadModel->usuariosListar()->find($id);
        $user['permissions'] = $instanceUser->getPermissions();
        $user['groups'] = $instanceUser->getGroups();

        return $this->respond(['data' => ['view' => view('seguridad/usuarios/seguridad_usuarios_editar', $data), 'user' => $user]]);
    }
    public function seguridadUsuarioPasswordActualizar(): \CodeIgniter\HTTP\Response
    {
        $data = $this->request->getJSON();
        $user = $this->users->findById(user_id());
        $validation = \Config\Services::validation();
        if (property_exists($data, 'old_password')) {
            $validation->setRules([
                'old_password' => [
                    'label' => lang('SeguridadLang.formUserSetupPlaceholderOldPassword'),
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => lang('SeguridadLang.formUserSetupValidationOldPasswordRequired'),
                    ]
                ],
                'password' => [
                    'label' => lang('SeguridadLang.formUserSetupPlaceholderPassword'),
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => lang('SeguridadLang.formUserSetupValidationPasswordRequired'),
                        'min_length' => lang('SeguridadLang.formUserSetupValidationPasswordMinLength'),
                        'max_length' => lang('SeguridadLang.formUserSetupValidationPasswordMinLength'),
                    ]
                ],
                'confirm_password' => [
                    'label' => lang('SeguridadLang.formUserSetupPlaceholderRepeatPassword'),
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => lang('SeguridadLang.formUserSetupValidationPasswordConfirmationRequired'),
                        'matches' => lang('SeguridadLang.formUserSetupValidationPasswordConfirmationMatch'),
                    ]
                ],
            ]);
            if (!$validation->withRequest($this->request)->run())
                return $this->respond(['type' => 'error', 'message' => $validation->listErrors()]);

            $result = auth()->check([
                'email'    => auth()->user()->email,
                'password' => $data->old_password,
            ]);
            if (!$result->isOK())
                return $this->respond(['type' => 'error', 'message' => lang('SeguridadLang.responseUserSetupNewPasswordErrorOldPassword')]);
            if ($data->old_password == $data->password)
                return $this->respond(['type' => 'error', 'message' => lang('SeguridadLang.responseUserSetupNewPasswordErrorSamePassword')]);

            $user->password = $data->password;
            $this->users->save($user);
            return $this->respond(['type' => 'success', 'message' => 'Contraseña actualizada correctamente']);
        } else {
            $validation->setRules([
                'password' => [
                    'label' => lang('SeguridadLang.formUserSetupPlaceholderPassword'),
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => lang('SeguridadLang.formUserSetupValidationPasswordRequired'),
                        'min_length' => lang('SeguridadLang.formUserSetupValidationPasswordMinLength'),
                        'max_length' => lang('SeguridadLang.formUserSetupValidationPasswordMinLength'),
                    ]
                ],
                'confirm_password' => [
                    'label' => lang('SeguridadLang.formUserSetupPlaceholderRepeatPassword'),
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => lang('SeguridadLang.formUserSetupValidationPasswordConfirmationRequired'),
                        'matches' => lang('SeguridadLang.formUserSetupValidationPasswordConfirmationMatch'),
                    ]
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                // return $this->respond(['type' => 'error', 'message' => $validation->getErrors()]);
                return $this->respond(['type' => 'error', 'message' => $validation->listErrors()]);
            }
            $result = auth()->check([
                'email'    => auth()->user()->email,
                'password' => $data->password,
            ]);
            if ($result->isOK())
                return $this->respond(['type' => 'error', 'message' => lang('SeguridadLang.responseUserSetupNewPasswordErrorSamePassword')]);

            $user->password = $data->password;
            $this->users->save($user);
            $user->undoForcePasswordReset();
            return $this->respond(['type' => 'success', 'message' => 'Contraseña actualizada correctamente']);
        }
    }
    public function seguridadUsuariosActualizar($id): \CodeIgniter\HTTP\Response
    {
        $data = $this->request->getJSON();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => ['label' => lang('SeguridadLang.formModalAddUserEmail'), 'rules' => 'required|valid_email'],
            'password' => ['label' => lang('SeguridadLang.formModalAddUserPassword'), 'rules' => 'permit_empty|min_length[8]|max_length[255]'],
            // 'groups' => ['label' => lang('SeguridadLang.formModalAddUserSelectGroups'), 'rules' => 'required'],
        ]);

        if (!$validation->withRequest($this->request)->run())
            return $this->respond(['type' => 'error', 'message' => $validation->listErrors()]);
        if (!empty($this->authIdentitiesModel->where(['secret' => $data->email, 'user_id <>' => $id])->find()))
            return $this->respond(['type' => 'error', 'message' => lang('SeguridadLang.formUserSetupValidationDuplicateEmail')]);
        $data->email = strtolower($data->email);
        $userName = explode('@', $data->email);

        $user = $this->users->findById($id);
        if (!empty($data->password))
            $user->password = $data->password;
        $user->email = $data->email;
        $user->username = $userName[0];
        $this->users->save($user);


        foreach ($user->getGroups() as $key => $value) {
            $user->removeGroup($value);
        }
        foreach ($user->getPermissions() as $key => $value) {
            $user->removePermission($value);
        }
        foreach ($data->groups as $key => $value) {
            $user->addGroup($value);
        }
        foreach ($data->permissions as $key => $value) {
            $user->addPermission($value);
        }

        return $this->respond(['type' => 'success', 'message' => 'Usuario agregado correctamente']);
    }
    public function seguridadUsuariosActivar($id): \Codeigniter\HTTP\Response
    {
        $user = $this->users->findById($id);
        if ($user->active == 1) {
            $user->deactivate($user);
            return $this->respond(['type' => 'success', 'message' => lang('SeguridadLang.responseUserDeactivateSuccess')]);
        } else {
            $user->activate($user);
            return $this->respond(['type' => 'success', 'message' => lang('SeguridadLang.responseUserActivateSuccess')]);
        }
    }
    public function seguridadUsuariosCambioPasswordForzar($id)
    {
        $user = $this->users->findById($id);
        $data = $this->request->getJson();
        if ($data->forceChangePassword == 1) {
            $user->forcePasswordReset();
            return $this->respond(['type' => 'success', 'message' => lang('SeguridadLang.responseUserForceResetSuccess')]);
        } else {
            $user->undoForcePasswordReset();
            return $this->respond(['type' => 'success', 'message' => lang('SeguridadLang.responseUserUndoForceResetSuccess')]);
        }
    }
    public function seguridadUsuariosAgregar(): \CodeIgniter\HTTP\Response
    {
        $authGroupsConfig = config('AuthGroups');
        $data['urlSubmit'] = base_url(route_to('seguridad/usuarios/insertar'));
        $data['urlSearch'] = base_url(route_to('seguridad/usuarios/buscar-persona'));
        $data['group'] = array_keys($authGroupsConfig->groups);
        $data['permissions'] = array_keys($authGroupsConfig->permissions);
        return $this->respond(['type' => 'success', 'data' => ['view' => view('seguridad/usuarios/seguridad_usuarios_agregar', $data)]]);
    }
    public function seguridadUsuariosInsertar(): \CodeIgniter\HTTP\Response
    {
        $data = $this->request->getJSON();
        $validation = \Config\Services::validation();
        $validation->setRules([
            // 'id' => ['label' => lang('SeguridadLang.formModalAddUserPerson'), 'rules' => 'required|is_natural_no_zero'],
            'email' => ['label' => lang('SeguridadLang.formModalAddUserEmail'), 'rules' => 'required|valid_email'],
            'password' => ['label' => lang('SeguridadLang.formModalAddUserPassword'), 'rules' => 'required|min_length[8]|max_length[255]'],
            'forceReset' => ['label' => lang('SeguridadLang.formModalAddUserForceResetPassword'), 'rules' => 'is_natural|in_list[0,1]'],
            'groups' => ['label' => lang('SeguridadLang.formModalAddUserSelectGroups'), 'rules' => 'required'],
        ]);

        if (!$validation->withRequest($this->request)->run())
            return $this->respond(['type' => 'error', 'message' => $validation->listErrors()]);
        // if (!empty($this->seguridadModel->find($data->id)))
        //     return $this->respond(['type' => 'error', 'message' => lang('SeguridadLang.formUserSetupValidationUserDuplicate')]);
        if (!empty($this->authIdentitiesModel->where(['secret' => $data->email])->find()))
            return $this->respond(['type' => 'error', 'message' => lang('SeguridadLang.formUserSetupValidationDuplicateEmail')]);
        $data->email = strtolower($data->email);
        $userName = explode('@', $data->email);
        $id = $this->seguridadModel->insert([
            // 'id' => $data->id,
            'username' => $userName[0],
            'active' => 1,
        ]);
        $user = $this->users->findById($id);
        $user->password = $data->password;
        $user->email = $data->email;
        $this->users->save($user);
        $user = $this->users->findById($id);

        $data->forceReset ? $user->forcePasswordReset() : $user->undoForcePasswordReset();
        foreach ($data->groups as $key => $value) {
            $user->addGroup($value);
        }
        foreach ($data->permissions as $key => $value) {
            $user->addPermission($value);
        }
        return $this->respond(['type' => 'success', 'message' => 'Usuario agregado correctamente']);
    }
    public function seguridadUsuariosEliminar(int $id): \CodeIgniter\HTTP\Response
    {
        $user = $this->users->findById($id);
        if ($user) {
            $this->users->delete($id);
            return $this->respond(['message' => 'Usuario eliminado correctamente']);
        } else {
            return $this->respond(['message' => 'Usuario no encontrado'], 404);
        }
    }
}
