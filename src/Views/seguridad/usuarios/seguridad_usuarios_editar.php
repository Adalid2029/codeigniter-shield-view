<form id="kt_modal_new_target_form" class="form" action="<?= $urlSubmit ?>">
    <div class="mb-13 text-center">
        <h1 class="mb-3"><?= lang('SeguridadLang.formModalEditUserTitle') ?></h1>
    </div>
    <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2"><?= lang('SeguridadLang.formModalAddUserEmail') ?></label>
            <input type="text" class="form-control form-control-solid" placeholder="<?= lang('SeguridadLang.formModalAddUserEmailPlaceholder') ?>" name="email" />
        </div>
        <div class="col-md-6 fv-row fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                <?= lang('SeguridadLang.formModalAddUserPassword') ?>
            </label>

            <div class="position-relative">
                <input type="text" class="form-control form-control-solid" placeholder="<?= lang('SeguridadLang.formModalAddUserPasswordPlaceholder') ?>" name="password">
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                    <i class="ki-duotone ki-eye-slash fs-2"></i> <i class="ki-duotone ki-eye fs-2 d-none"></i> </span>

                <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                    <i class="ki-duotone ki-loading fs-2hx" style="cursor: pointer" id="reload_password">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                </div>
                <div class="d-flex align-items-center mt-2 mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
            </div>
            <div class="text-muted">
                <?= lang('SeguridadLang.titleUserSetupNewPasswordMessagePasswordRequirements') ?>
            </div>
        </div>
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
        <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-toogle="dismiss" data-bs-dismiss="modal">
            <?= lang('SeguridadLang.formModalAddUserButtonCancel') ?>
        </button>

        <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
            <span class="indicator-label"> <?= lang('SeguridadLang.formModalAddUserButtonSubmit') ?> </span>
            <!-- <span class="spinner-border spinner-border-sm align-middle ms-2"></span> -->
        </button>
    </div>
</form>