let idModal;
function parametrosModal(modal, size, onEscape, backdrop, data, isDraggable = true) {
    idModal = `#${modal._element.id}`;
    var modalBody = document.querySelector(`${idModal}-body`);
    modal._dialog.classList.add(size);

    if (typeof data.view !== "undefined") {
        modalBody.innerHTML = data.view;
    }
    modal._config.backdrop = backdrop;
    modal._config.keyboard = onEscape;
    const buttonsCloseModal = document.querySelectorAll(
        '[data-bs-dismiss="modal"]'
    );

    buttonsCloseModal.forEach((button) => {
        button.addEventListener("click", () => {
            modal.hide();
        });
    });
    if (isDraggable) {
        const modalDialogs = document.querySelectorAll(".modal-dialog");
        for (const modalDialog of modalDialogs) {
            modalDialog.style.cursor = "move";
            let isDragged = false;
            let currentX;
            let currentY;
            let initialX;
            let initialY;
            let xOffset = 0;
            let yOffset = 0;

            modalDialog.addEventListener("mousedown", (e) => {
                // Excluir elementos de tipo input, textarea, select, select2 y span con clase select2
                if (
                    ["INPUT", "TEXTAREA", "SELECT", "SPAN"].includes(e.target.tagName) ||
                    e.target.classList.contains("select2")
                ) {
                    return;
                }
                initialX = e.clientX - xOffset;
                initialY = e.clientY - yOffset;
                isDragged = true;
            });

            modalDialog.addEventListener("mouseup", () => {
                isDragged = false;
            });

            modalDialog.addEventListener("mouseout", () => {
                isDragged = false;
            });

            modalDialog.addEventListener("mousemove", (e) => {
                if (isDragged) {
                    e.preventDefault();
                    currentX = e.clientX - initialX;
                    currentY = e.clientY - initialY;
                    xOffset = currentX;
                    yOffset = currentY;
                    modalDialog.style.top = currentY + "px";
                    modalDialog.style.left = currentX + "px";
                }
            });
        }
    }
    modal.show();
    // startEventAfterChargeView();
}

function languageDataTable() {
    return {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "No se encontraron registros",
        info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
        search: "Buscar:",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior",
        },
        processing: "Procesando...",
        loadingRecords: "Cargando...",
        emptyTable: "No hay datos disponibles en la tabla",
        aria: {
            sortAscending: ": Activar para ordenar la columna de manera ascendente",
            sortDescending: ": Activar para ordenar la columna de manera descendente",
        },
        buttons: {
            copy: "Copiar",
            colvis: "Visibilidad",
        },
    };
}
function lengthMenuDataTable() {
    return [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "Todo"],
    ];
}
function startEventAfterChargeView() {
    $('[data-bs-toggle="tooltip"]').tooltip();
    $('[data-control="select2"]').select2({
        language: {
            noResults: function () {
                return "No se encontraron resultados";
            },
            inputTooShort: function () {
                return "Por favor, ingrese más caracteres";
            },
            searching: function () {
                return "Buscando...";
            },
            errorLoading: function () {
                return "No se pudo cargar la búsqueda";
            },
        },
        dropdownParent: $(idModal),
        allowClear: true,
        width: "100%",
    });
    chargeLocaleSpanish();
    $('[data-control="date"]').flatpickr({
        dateFormat: "Y-m-d",
        locale: "es",
    });
}
function chargeLocaleSpanish() {
    (function (global, factory) {
        typeof exports === "object" && typeof module !== "undefined"
            ? factory(exports)
            : typeof define === "function" && define.amd
                ? define(["exports"], factory)
                : ((global =
                    typeof globalThis !== "undefined" ? globalThis : global || self),
                    factory((global.es = {})));
    })(this, function (exports) {
        "use strict";

        var fp =
            typeof window !== "undefined" && window.flatpickr !== undefined
                ? window.flatpickr
                : {
                    l10ns: {},
                };
        var Spanish = {
            weekdays: {
                shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Miércoles",
                    "Jueves",
                    "Viernes",
                    "Sábado",
                ],
            },
            months: {
                shorthand: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                ],
                longhand: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ],
            },
            ordinal: function () {
                return "º";
            },
            firstDayOfWeek: 1,
            rangeSeparator: " a ",
            time_24hr: true,
        };
        fp.l10ns.es = Spanish;
        var es = fp.l10ns;

        exports.Spanish = Spanish;
        exports.default = es;

        Object.defineProperty(exports, "__esModule", { value: true });
    });
}
function chargeLocaleSpanishDatePicker() {
    return {
        format: "DD/MM/YYYY",
        applyLabel: "Aplicar",
        cancelLabel: "Cancelar",
        fromLabel: "Desde",
        toLabel: "Hasta",
        customRangeLabel: "Personalizado",
        daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ],
        firstDay: 1,
    };
}
function eventCancelModal(modal, cancelButton, form) {
    cancelButton.addEventListener("click", function (e) {
        e.preventDefault();
        Swal.fire({
            text: "¿Estás seguro de que quieres cancelar?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "¡Sí, cancelar!",
            cancelButtonText: "No, volver",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light",
            },
        }).then(function (result) {
            if (result.value) {
                form.reset();
                modal.hide();
            } else if (result.dismiss === "cancel") {
                Swal.fire({
                    text: "¡Tu formulario no ha sido cancelado!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, ¡entendido!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            }
        });
    });
}
function BASE_URL(url) {
    return window.BASE_URL + url;
}
export {
    parametrosModal,
    languageDataTable,
    lengthMenuDataTable,
    eventCancelModal,
    BASE_URL,
    chargeLocaleSpanishDatePicker,
};
