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
const eventsAddUser = (modal, datatable) => {
    var id;
    var form;
    var validator;
    var buttonSubmit;
    var email;
    var password;
    var reloadPassword;
    var passwordMeter;
    var autocomplete;

    const KTEventsAddUser = (function () {
        const eventForm = () => {
            // eventIdSelect();
            // validatePassword();
            // validator = FormValidation.formValidation(form, {
            //     fields: {
            //         id: {
            //             validators: {
            //                 notEmpty: {
            //                     message: "El usuario es requerido",
            //                 },
            //             },
            //         },
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
            //                 notEmpty: {
            //                     message: "La contraseña es requerida"
            //                 },
            //                 stringLength: {
            //                     min: 8,
            //                     message: "La contraseña debe tener al menos 8 caracteres"
            //                 },
            //                 callback: {
            //                     message: "Por favor ingrese una contraseña válida",
            //                     callback: function (input) {
            //                         if (input.value.length > 0) {
            //                             // return validatePassword();
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
        var validatePassword = function () {
            passwordMeter = $('#password').password({
                enterPass: 'Escribe tu contraseña',
                shortPass: 'La contraseña es muy corta',
                containsField: 'La contraseña contiene tu usuario',
                steps: {
                    13: 'Muy insegura',
                    33: 'Débil; intenta combinar letras y números',
                    67: 'Media; intenta usar caracteres especiales',
                    94: 'Contraseña fuerte',
                },
                showPercent: false,
                showText: true,
                animate: true,
                animateSpeed: 50,
            });
        };
        const eventSubmit = () => {
            // validator.revalidateField("password");
            // validator.validate().then(async function (status) {
            //     if (status != "Valid")
            //         return Swal.fire({
            //             text: "Lo sentimos, parece que se han detectado algunos errores. Inténtalo de nuevo.",
            //             icon: "error",
            //             buttonsStyling: false,
            //             confirmButtonText: "Continuar",
            //             customClass: {
            //                 confirmButton: "btn btn-primary",
            //             },
            //         });

            const formData = new FormData(form);
            const data = {
                id: formData.get('id'),
                email: formData.get('email'),
                password: formData.get('password'),
                forceReset: formData.get('force_reset') === 'on' ? 1 : 0,
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

            // })

        }
        const eventIdSelect = () => {
            $(autocomplete).devbridgeAutocomplete({
                serviceUrl: autocomplete.getAttribute("data-ajax-url"),
                noCache: true,
                onSelect: function (suggestion) {
                    email.value = suggestion.data.numero_cedula_identidad + "@examensimulacro.net";
                    password.value = generatePassword()
                    validator.revalidateField("id");
                    validator.revalidateField("email");
                    validator.revalidateField("password");
                    id.value = suggestion.data.id_inscripcion;
                },
                onInvalidateSelection: function () {
                    email.value = "";
                    password.value = "";
                    validator.revalidateField("id");
                    validator.revalidateField("email");
                    validator.revalidateField("password");
                    id.value = "";
                },
            });
        }
        return {
            init: () => {
                form = document.querySelector('#kt_modal_new_target_form');
                id = form.querySelector('[name="id"]');
                email = form.querySelector('[name="email"]');
                password = form.querySelector('[name="password"]');
                reloadPassword = form.querySelector('#generate_password_btn');
                autocomplete = form.querySelector('[name="autocomplete"]');
                eventForm();
            }
        }
    })();
    KTEventsAddUser.init();
}
function generatePassword() {
    const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
    const numericChars = '0123456789';
    const symbolChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';

    let password = '';

    // Agregar al menos una mayúscula, una minúscula, un número y un símbolo
    password += uppercaseChars.charAt(Math.floor(Math.random() * uppercaseChars.length));
    password += lowercaseChars.charAt(Math.floor(Math.random() * lowercaseChars.length));
    password += numericChars.charAt(Math.floor(Math.random() * numericChars.length));
    password += symbolChars.charAt(Math.floor(Math.random() * symbolChars.length));

    // Generar los caracteres restantes
    const allChars = uppercaseChars + lowercaseChars + numericChars + symbolChars;
    for (let i = 4; i < 8; i++) {
        password += allChars.charAt(Math.floor(Math.random() * allChars.length));
    }

    // Mezclar los caracteres para obtener una contraseña aleatoria
    password = password.split('').sort(function () {
        return 0.5 - Math.random();
    }).join('');

    return password;
}
export { eventsAddUser, generatePassword }