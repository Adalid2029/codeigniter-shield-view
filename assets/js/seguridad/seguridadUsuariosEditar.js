import { generatePassword } from "./seguridadUsuariosAgregar.js";
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
const eventsEditUser = (modal, datatable, response) => {
    var form;
    var validator;
    var buttonSubmit;
    var email;
    var password;
    var reloadPassword;
    var passwordMeter;

    const KTEventsEditUser = (function () {
        const eventForm = () => {
            email.value = response.data.user.secret;
            response.data.user.permissions.forEach(permission => {
                const checkbox = document.querySelector(`input[name="permission[]"][value="${permission}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });

            response.data.user.groups.forEach(group => {
                const checkbox = document.querySelector(`input[name="group[]"][value="${group}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            // validator = FormValidation.formValidation(form, {
            //     fields: {
            //         email: {
            //             validators: {
            //                 notEmpty: {
            //                     message: "El correo electrónico es requerido",
            //                 },
            //                 emailAddress: {
            //                     message: "El correo electrónico no es válido",
            //                 },
            //             },

            //         },
            //         password: {
            //             validators: {
            //                 stringLength: {
            //                     min: 8,
            //                     message: "La contraseña debe tener al menos 8 caracteres"
            //                 },
            //                 callback: {
            //                     message: "Por favor ingrese una contraseña válida",
            //                     callback: function (input) {
            //                         if (input.value.length > 0) {
            //                             return validatePassword();
            //                         }
            //                     }
            //                 }
            //             }
            //         },
            //         'group[]': {
            //             validators: {
            //                 notEmpty: {
            //                     message: "El grupo es requerido"
            //                 },
            //             }
            //         }
            //     },
            //     plugins: {
            //         trigger: new FormValidation.plugins.Trigger({
            //             event: {
            //                 password: false,
            //             },
            //         }),
            //         bootstrap: new FormValidation.plugins.Bootstrap5({
            //             rowSelector: ".fv-row",
            //             eleInvalidClass: "",
            //             eleValidClass: "",
            //         }),
            //     },
            // });
            buttonSubmit = document.querySelector('#kt_modal_new_target_submit');
            buttonSubmit.addEventListener('click', (e) => {
                e.preventDefault();
                eventSubmit();
            });
            // reloadPassword.addEventListener('click', () => {
            //     password.value = generatePassword()
            //     validator.revalidateField("password");
            // })
        }
        // var validatePassword = function () {
        //     return passwordMeter.getScore() === 100;
        // };
        const eventSubmit = () => {
            // validator.revalidateField("password");
            // validator.validate().then(async function (status) {
            //     if (status == "Valid") {
            const formData = new FormData(form);
            const data = {
                email: formData.get('email'),
                password: formData.get('password'),
                groups: formData.getAll('group[]'),
                permissions: formData.getAll('permission[]'),
            }
            const response = axios.post(form.getAttribute('action'), data).then((response) => {
                if (response.data.type === 'success') {
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    modal.hide();
                    datatable.ajax.reload();

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        html: response.data.message,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-light",
                        },
                        buttonsStyling: false,
                    });
                }
            })
            //     } else {
            //         Swal.fire({
            //             text: "Hay errores en tu formulario, por favor corrígelos",
            //             icon: "error",
            //             buttonsStyling: false,
            //             confirmButtonText: "Continuar",
            //             customClass: {
            //                 confirmButton: "btn btn-primary",
            //             },
            //         });
            //     }
            // })

        }

        return {
            init: () => {
                form = document.querySelector('#kt_modal_new_target_form');
                // passwordMeter = KTPasswordMeter.getInstance(
                //     form.querySelector('[data-kt-password-meter="true"]')
                // );
                email = form.querySelector('[name="email"]');
                password = form.querySelector('[name="password"]');
                reloadPassword = form.querySelector('#reload_password');
                eventForm();
            }
        }
    })();
    KTEventsEditUser.init();
}
export { eventsEditUser }