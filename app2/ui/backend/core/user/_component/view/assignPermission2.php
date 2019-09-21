<style>
    label{
        width: 100%;
        cursor: pointer;
    }
    label input{
        float: left !important;
    }

    .modal-body{
        overflow-y: scroll;
        max-height: 400px;
    }
</style>
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div class="col-md-2">دسترسی ها</div>
        </div>
        <div class="row">
            <div class="col-md-7" style="background: rgb(225, 240, 219);  padding: 12px;  border-radius: 5px;  border: 1px solid rgb(205, 205, 205);">
                <?php
                foreach ( $perms as $permId => $perm )
                {
                    ?>
                    <div class="row">
                        <div class="col-md-10">
                            <label>
                                <input name="perms" <?= $perm[ 'checked' ] ? 'checked' : '' ?> type="checkbox" class="perm" data-id="<?= $permId ?>">
                                <?= $perm[ 'permTitle' ] ?>
                            </label>
                        </div>
                    </div>                
                <?php }
                ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">نقش ها</div>
        </div>
        <div class="row">
            <div class="col-md-7" style="background: rgb(228, 228, 242);  padding: 12px;  border-radius: 5px;  border: 1px solid rgb(205, 205, 205);">
                <?php
                foreach ( $roles as $roleId => $role )
                {
                    ?>
                    <div class="row">
                        <div class="col-md-10">
                            <label>
                                <input name="roles" <?= $role[ 'checked' ] ? 'checked' : '' ?> type="checkbox" class="role" data-id="<?= $roleId ?>">
                                <?= $role[ 'roleTitle' ] ?>
                            </label>
                        </div>
                    </div>
                <?php }
                ?>

            </div>
        </div>
    </div>
</div>
<div class="formRow">
    <div class="full">
        <input type="submit" id="save" value="ذخیره" class="btn btn-primary">
    </div>
    <div class="clear"></div>    
</div>

<script>
    function c(response) {
        if (response.result === 'success') {
            widgetHelper.successDialog('تغییرات ذخیره شد');
        }
    }
    $(document).ready(function () {
        $('#save').click(function (e) {
            e.preventDefault();
            var params = {
                perms: [],
                roles: [],
                save: true,
                userId: <?= $userId ?>
            };
            $('.perm:checked').each(function (i, permEl) {
                params.perms.push($(permEl).attr('data-id'));
            });
            $('.role:checked').each(function (i, roleEl) {
                params.roles.push($(roleEl).attr('data-id'));
            });
            widgetHelper.tt('ui', 'core.user.assignPermission', params, 'c');
        });
    });
</script>