<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('seguridad', static function ($routes) {
    $routes->group('usuarios', static function ($routes) {
        $routes->get('listar', 'SeguridadController::seguridadUsuariosListar', ['as' => 'seguridad/usuarios/listar']);
        $routes->get('activar/(:num)', 'SeguridadController::seguridadUsuariosActivar/$1', ['as' => 'seguridad/usuarios/activar']);
        $routes->post('forzar-cambio-password/(:num)', 'SeguridadController::seguridadUsuariosCambioPasswordForzar/$1', ['as' => 'seguridad/usuarios/forzar-cambio-password']);
        $routes->get('agregar', 'SeguridadController::seguridadUsuariosAgregar', ['as' => 'seguridad/usuarios/agregar']);
        $routes->post('insertar', 'SeguridadController::seguridadUsuariosInsertar', ['as' => 'seguridad/usuarios/insertar']);
        $routes->get('buscar-persona', 'SeguridadController::seguridadUsuariosBuscarPersona', ['as' => 'seguridad/usuarios/buscar-persona']);
        $routes->get('editar/(:num)', 'SeguridadController::seguridadUsuariosEditar/$1', ['as' => 'seguridad/usuarios/editar']);
        $routes->post('actualizar/(:num)', 'SeguridadController::seguridadUsuariosActualizar/$1', ['as' => 'seguridad/usuarios/actualizar']);
        $routes->get('eliminar/(:num)', 'SeguridadController::seguridadUsuariosEliminar/$1', ['as' => 'seguridad/usuarios/eliminar']);
    });
    $routes->group('usuario', static function ($routes) {
        $routes->get('modificar-contrasena', 'SeguridadController::seguridadUsuarioPasswordModificar');
        $routes->get('modificar-contrasena-forzado', 'SeguridadController::seguridadUsuarioPasswordModificarForzado');
        $routes->post('actualizar-contrasena', 'SeguridadController::seguridadUsuarioPasswordActualizar');
    });
});
