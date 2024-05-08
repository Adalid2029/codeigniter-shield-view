import {
    parametrosModal,
    eventCancelModal,
} from "../../helper.js";
import { eventsAddUser } from "./seguridadUsuariosAgregar.js";
import { eventsEditUser } from "./seguridadUsuariosEditar.js";
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
const eventActivateUser = async (element, datatable) => {
    const response = await axios
        .get(element.getAttribute("data-url"))
        .then((response) => {
            if (response.data.type === "success") {
                datatable.ajax.reload();

                Toast.fire({
                    icon: "success",
                    title: response.data.message,
                });
            }
        })
        .catch((error) => { });
};
const eventForceResetPassword = async (element, datatable) => {
    const response = await axios
        .post(element.getAttribute("data-url"), {
            forceChangePassword: element.checked ? 1 : 0,
        })
        .then((response) => {
            if ((response.data.typer = "success")) {
                datatable.ajax.reload();
                Toast.fire({
                    icon: "success",
                    title: response.data.message,
                });
            }
        });
};
const eventAddUser = async (element, modal, datatable) => {
    const response = await axios.get(element.href).then((response) => {
        parametrosModal(modal, "modal-lg", false, "static", response.data.data, false);
        eventsAddUser(modal, datatable);
    });
}
const eventEditUser = async (element, modal, datatable) => {
    const response = await axios.get(element.href).then((response) => {
        parametrosModal(modal, "modal-lg", false, "static", response.data.data, false);
        eventsEditUser(modal, datatable, response.data);
    });
}
const eventDeleteUser = async (element, modal, datatable) => {
    const response = await axios.get(element.href).then((response) => {
        Toast.fire({
            icon: "success",
            title: response.data.message,
        });
        datatable.ajax.reload();
    }).catch(function (error) {
        Toast.fire({
            icon: 'error',
            title: 'Error al eliminar'
        })
    })
}
export { eventActivateUser, eventForceResetPassword, eventAddUser, eventEditUser, eventDeleteUser };
