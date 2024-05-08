<link href="<?= base_url() ?>assets-personalizados/custom/password-strength-meter/dist/password.min.css" rel="stylesheet" type="text/css" />

<style>
    .autocomplete-suggestions {
        border: 1px solid #999;
        background: #FFF;
        overflow: auto;
    }

    .autocomplete-suggestion {
        padding: 2px 5px;
        white-space: nowrap;
        overflow: hidden;
    }

    .autocomplete-selected {
        background: #F0F0F0;
    }

    .autocomplete-suggestions strong {
        font-weight: normal;
        color: #3399FF;
    }

    .autocomplete-group {
        padding: 2px 5px;
    }

    .autocomplete-group strong {
        display: block;
        border-bottom: 1px solid #000;
    }
</style>
<form id="kt_modal_new_target_form" class="form" action="<?= $urlSubmit ?>">
    <div class="mb-13 text-center">
        <h1 class="mb-3"><?= lang('SeguridadLang.formModalAddUserTitle') ?></h1>

        <div class="text-muted fw-semibold fs-5">
            <!-- If you need more info, please check
            <a href="#" class="fw-bold link-primary">Project Guidelines</a>. -->
        </div>
    </div>
    <!-- 
    <div class="d-flex flex-column mb-8 fv-row">
        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
            <span class="required"><?= lang('SeguridadLang.formModalAddUserPerson') ?></span>
        </label>
        <input class="form-control form-control-solid" type="text" name="autocomplete" id="autocomplete" placeholder="<?= lang('SeguridadLang.formModalAddUserPersonPlaceholder') ?>" data-ajax-url="<?= $urlSearch ?>" />
        <input type="hidden" name="id" id="id">
    </div> -->

    <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2"><?= lang('SeguridadLang.formModalAddUserEmail') ?></label>
            <input type="text" class="form-control form-control-solid" placeholder="<?= lang('SeguridadLang.formModalAddUserEmailPlaceholder') ?>" name="email" />
        </div>
        <div class="col-md-6 fv-row fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                <?= lang('SeguridadLang.formModalAddUserPassword') ?></label>
            <div class="position-relative">
                <input type="text" class="form-control form-control-solid" name="password" id="password" placeholder="<?= lang('SeguridadLang.formModalAddUserPasswordPlaceholder') ?>">
            </div>
            <div class="text-end pt-1">
                <button type="button" id="generate_password_btn" class="purchase-btn btn btn-primary btn-sm btn-hover-effect f-w-500"><?= lang('SeguridadLang.formModalAddUserGeneratePassword') ?></button>
            </div>
        </div>
    </div>

    <div class="d-flex flex-stack mb-4 mt-4">
        <div class="me-5">
            <label class="fs-6 fw-semibold"><?= lang('SeguridadLang.formModalAddUserForceResetPassword') ?></label>
            <div class="fs-7 fw-semibold text-muted">
                <?= lang('SeguridadLang.formModalAddUserForceResetPasswordTooltip') ?>
            </div>
        </div>

        <label class="form-check form-switch form-check-custom form-check-solid text-end">
            <span class="form-check-label fw-semibold text-muted"><?= lang('SeguridadLang.formModalAddUserForce') ?></span>
            <div class="media-body text-end icon-state switch-outline">
                <label class="switch">
                    <input type="checkbox" name="force_reset"><span class="switch-state bg-primary"></span>
                </label>
            </div>
        </label>
    </div>

    <div class="mb-2 fv-row">
        <div class="d-flex flex-stack">
            <div class="fw-semibold me-5">
                <label class="fs-6"><?= lang('SeguridadLang.formModalAddUserSelectGroups') ?></label>
            </div>
        </div>
    </div>
    <?php foreach ($group as $key => $value) : ?>
        <div class="mb-2 fv-row">
            <div class="d-flex flex-stack">
                <div class="fw-semibold me-5">
                    <div class="fs-7 text-muted">
                        <?= $value ?>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-20px w-20px" type="checkbox" name="group[]" value="<?= $value ?>" />
                    </label>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <div class="mt-8 fv-row">
        <div class="d-flex flex-stack">
            <div class="fw-semibold me-5">
                <label class="fs-6"><?= lang('SeguridadLang.formModalAddUserSelectGroups') ?></label>
            </div>
        </div>
    </div>
    <?php foreach ($permissions as $key => $value) : ?>
        <div class="mb-2 fv-row">
            <div class="d-flex flex-stack">
                <div class="fw-semibold me-5">
                    <div class="fs-7 text-muted">
                        <?= $value ?>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-20px w-20px" type="checkbox" name="permission[]" value="<?= $value ?>" />
                    </label>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <div class="mt-15 text-center">
        <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
            <?= lang('SeguridadLang.formModalAddUserButtonCancel') ?>
        </button>

        <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
            <?= lang('SeguridadLang.formModalAddUserButtonSubmit') ?>
        </button>
    </div>
</form>