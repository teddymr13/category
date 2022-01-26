<?php $isEdit = (isset($data_edit)); ?>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-body">
                <form id="form_category" method="post">
                    <div class="form-group">
                        <label for="category_name" class="label_required_field">Category</label>
                        <input id="category_name" name="category_name" type="text" class="form-control" maxlength="60"<?php if($isEdit) echo ' value="'.$data_edit['kategori'].'"'; ?> required />
                    </div>
                    <?php require_once 'views/includes/form-submit-buttons.php'; ?>
                </form>
            </div>
        </div>
    </div>
</div>