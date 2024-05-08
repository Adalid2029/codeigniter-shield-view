"use strict";
import {
  eventActivateUser,
  eventForceResetPassword,
  eventAddUser,
  eventEditUser,
  eventDeleteUser
} from "./seguridadUsuariosAcciones.js";
var iniciarListar = () => {
  document.addEventListener('DOMContentLoaded', function () {
    principal().init();
  });
};
var principal = () => (function () {
  var table;
  var datatable;
  var modalEl;
  var modal;
  var btnAddUser;
  var initDatatable = function () {
    datatable = $(table)
      .DataTable({
        ajax: {
          url: table.getAttribute("data-url_datatable"),
          type: "GET",
        },
        responsive: true,
        // language: languageDataTable,
        // scrollX: true,
        autoWidth: true,
        processing: true,
        serverSide: true,
        info: true,
        order: [
          [1, "desc"]
        ],
        searching: false,
        columnDefs: [
          {
            targets: [0],
            orderable: false,
          },
        ],
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "Todo"],
        ],
        zeroRecords: "No hay registros",
        dom: "<'row'<'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'p>>",

      }).on("draw.dt", function () {
        $('[data-bs-original-title]').tooltip();
      })
  };
  var exportButtons = () => {
    const documentTitle = `Reporte ${new Date().toLocaleDateString("es-ES", {
      weekday: "long",
      day: "numeric",
      month: "long",
      year: "numeric",
    })}`;
    var buttons = new $.fn.dataTable.Buttons(table, {
      buttons: [
        {
          extend: "copyHtml5",
          title: documentTitle,
        },
        {
          extend: "excelHtml5",
          title: documentTitle,
        },
        {
          extend: "csvHtml5",
          title: documentTitle,
        },
        {
          extend: "pdfHtml5",
          title: documentTitle,
        },
      ],
    })
      .container()
      .appendTo($("#kt_datatable_example_buttons"));

    // Hook dropdown menu click event to datatable export buttons
    const exportButtons = document.querySelectorAll(
      "#kt_datatable_example_export_menu [data-kt-export]"
    );
    exportButtons.forEach((exportButton) => {
      exportButton.addEventListener("click", (e) => {
        e.preventDefault();

        // Get clicked export value
        const exportValue = e.target.getAttribute("data-kt-export");
        const target = document.querySelector(
          ".dt-buttons .buttons-" + exportValue
        );

        target.click();
      });
    });
  };
  var handleSearchDatatable = () => {
    const filterSearch = document.querySelector('[data-kt-filter="search"]');
    filterSearch.addEventListener("keyup", function (e) {
      datatable.search(e.target.value).draw();
    });
  };
  var eventsEdit = () => {
    datatable.on("click", ".edit", async function (e) {
      const response = await axios.get(this.getAttribute("href"));
      if (
        typeof response.data.type !== "undefined" &&
        response.data.type === "success"
      ) {
        edit(response.data.data, modal, datatable);
      }
    });
    datatable.on("change", ".active-user", async function (e) {
      e.preventDefault();
      eventActivateUser(this, datatable);
    });
    datatable.on("change", ".force-reset-password-user", async function (e) {
      e.preventDefault();
      eventForceResetPassword(this, datatable);
    });
    datatable.on('click', '.edit-user', async function (e) {
      e.preventDefault();
      eventEditUser(this, modal, datatable);
    });
    datatable.on('click', '.delete-user', async function (e) {
      e.preventDefault();
      eventDeleteUser(this, modal, datatable);
    });
    btnAddUser.addEventListener("click", async function (e) {
      e.preventDefault();
      eventAddUser(this, modal, datatable);
    });
  };

  return {
    init: function () {
      table = document.querySelector("#kt_datatable_example_4");
      modalEl = document.querySelector("#kt_modal_new_target");
      btnAddUser = document.querySelector("#btn_add_user");
      if (!modalEl) return;
      modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      if (!table) {
        return;
      }
      initDatatable();
      exportButtons();
      // handleSearchDatatable();
      eventsEdit();
    },
  };
})();

export { iniciarListar };