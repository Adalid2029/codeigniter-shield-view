<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link href="https://cdn.datatables.net/v/dt/dt-2.0.7/b-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/dt/dt-2.0.7/b-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<body class="box-layout">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Seguridad</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url("/") ?>">
                                <svg class="stroke-icon">
                                    <use href="<?= base_url() ?>/assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Seguridad</li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid basic_table">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3><?= lang('SeguridadLang.titleSubMenuUsers') ?></h3>
                        <span>Hoverable row use a class <code>table-hover</code> and for Horizontal border use a class <code>.table-border-horizontal</code> , Solid border Use a class<code>.border-solid .table</code>class.</span>
                    </div>
                    <div class="card-body">
                        <div class="text-end mb-2">
                            <a class="purchase-btn btn btn-primary btn-hover-effect f-w-500" href="<?= $urlAdd ?>" id="btn_add_user"><?= lang('SeguridadLang.formModalAddUserTitle') ?></a>
                        </div>
                        <table class="table" id="kt_datatable_example_4">
                            <thead>
                                <tr>
                                    <th scope="col"><?= lang('SeguridadLang.tableFieldActions') ?></th>
                                    <th style="width: 50px;"><?= lang('SeguridadLang.tableFieldId') ?></th>
                                    <th scope="col"><?= lang('SeguridadLang.tableFieldUserName') ?></th>
                                    <th scope="col"><?= lang('SeguridadLang.tableFieldForceChangePassword') ?></th>
                                    <th scope="col"><?= lang('SeguridadLang.tableActive') ?></th>
                                    <th scope="col"><?= lang('SeguridadLang.tableLastActive') ?></th>
                                    <th scope="col"><?= lang('SeguridadLang.tableUpdatedAt') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade bd-example-modal-lg" id="kt_modal_new_target" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="kt_modal_new_target-body">...</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        import {
            iniciarListar
        } from '<?= base_url() ?>js/seguridad/seguridadUsuariosListar.js';
        iniciarListar();
    </script>
</body>