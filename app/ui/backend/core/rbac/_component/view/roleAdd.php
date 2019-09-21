<link rel="stylesheet" href="<?= f\ifm::app()->componentBaseUrl . 'view/lib/jstree/dist/themes/default/style.min.css' ?>" />
<script src="<?= f\ifm::app()->componentBaseUrl . 'view/lib/jstree/dist/jstree.js' ?>"></script>

<style>
    .l{
        cursor: pointer;
        display: block;
        line-height: 37px;
        padding-bottom: 34px !important;
        padding-right: 5px !important;
    }
    .l input{
        margin-left: 10px !important;
    }

    input[type=checkbox]{
        cursor: pointer;
    }

    .jstree {
        margin-bottom: 8px;
    }
    .permWrapper{
        cursor: pointer;
        padding-top: 4px;
        margin-top: 14px;
    }
    .permWrapper:hover{
        background-color: rgb(234, 234, 234);
    }

    .permWrapper[data-state='loaded']{
        background-color: rgb(219, 255, 219);
        border: 1px solid rgb(218, 237, 218);
    }

    .permWrapper[data-state='loaded'] .jstree-default .jstree-clicked{
        background-color: #C3E0C3 !important;
    }

    .jstree-default .jstree-anchor{
        background-color: rgb(255, 192, 192);
        margin-top: 3px;
    }

</style>

<div id="contentDv">

    <?php
    /* @var $this rbacView */

    $this->registerWidgets(array (
        'pageTitleW' => 'pageTitle',
        'boxW'       => 'box',
        'dialogW'    => 'dialog'
    )) ;

    echo $this->pageTitleW->renderTitle(array (
        'title' => 'ایجاد نقش جدید',
        'links' => array ( array (
                'title' => 'لیست نقش ها',
                'href'  => \f\ifm::app()->baseUrl . 'core/rbac/roles'
    ) ) )) ;

    echo $this->boxW->begin(array (
        'type'  => 'form',
        'title' => 'ایجاد نقش جدید'
    )) ;
    ?>

    <div class="container">
        <div class="row" style="width: 53%; padding-right: 10px;">
            <label class="col-sm-3 control-label">عنوان نقش</label>
            <div class="col-sm-9">
                <input style="direction: rtl; " type="text" name="title" data-parsley-required="" class="form-control" data-parsley-id="8180">
            </div>
        </div>

        <br><br>

        <div class="row">
            <b style="font-weight: bold">انتخاب دسترسی</b>
        </div>
        <?php
        foreach ( $permissions as $permission )
        {
            ?>
            <div class="row">
                <div class="col-md-6 permWrapper" data-id="<?= $permission[ 'id' ] ?>" data-state="not-loaded">
                    <label class="l" for="permission<?= $permission[ 'id' ] ?>">
                        <?= $permission[ 'title' ] ?>
                        <input class="permCheck" type="checkbox" id="permission<?= $permission[ 'id' ] ?>" name="permission" value="<?= $permission[ 'id' ] ?>">
                    </label>
                </div>
            </div>
        <?php } ?>
        <div class='row'>
            <div class="formRow">
                <div class="col-sm-6">
                    <div class="full">
                        <input type="submit" id="save" value="ذخیره" class="btn btn-primary">
                    </div>
                </div>
                <div class="clear"></div>                    
            </div>            
        </div>
        <?= $this->boxW->flush() ?>
    </div>
</div>
<script>

<?php
$selectableActionsMarkup = \f\ttt::ui('ui.backend.core.code.viewSelectableCodesList',
                                      array (
            'treeid'               => 'jstree',
            'dontIncludeResources' => true
        )) ;
?>

    var rawSelectableTree = <?= json_encode($selectableActionsMarkup) ?>;

    var pManager = {
        checkPermActions: function (treeSelector, permActions) {

            $(treeSelector).jstree('open_all');

            $(permActions).each(function (i, action) {
                actionSelector = "li[data-type='method.ui'][data-id='" + action.actionId + "']";
                $(treeSelector).jstree("select_node", actionSelector, true);
            });

            $(treeSelector).jstree('close_all');
            $(treeSelector).jstree('open_node', $('li[aria-level=1]:visible'));
        },
        makeTree: function (selector) {
            $(selector).jstree({
                "plugins": ["html_data", "dnd", "ui", "checkbox"]
            });
        },
        removeUnused: function (node, treeSelector) {
            liObj = $('li#' + node.id);
            checkboxObj_UNDE = $('#' + node.id + '_anchor' + ' i.jstree-undetermined');
            if (!node.state.selected && checkboxObj_UNDE.length === 0) {
                $(treeSelector).jstree("delete_node", node);
                $(liObj).remove();
                return false;
            }
            if (node.children.length > 0) {
                $(node.children).each(function (i, childNode) {
                    pManager.removeUnused(childNode, treeSelector);
                });
            }
        },
        removeUncheckedNodes: function (treeSelector) {
            this.selectedIds = $(treeSelector).jstree('get_selected');
            var allNodes = $(treeSelector).jstree('get_json');
            $(treeSelector).jstree('open_all');
            setTimeout(function () {
                pManager.removeUnused(allNodes[0], treeSelector);
                $(treeSelector).jstree('close_all');
                $(treeSelector).jstree('open_node', $('li[aria-level=1]:visible'));
            }, 500);
        },
        loadActions: function (permWrapper) {
            var permissionId = $(permWrapper).data('id');
            $.ajax({
                url: '<?= \f\ifm::app()->baseUrl ?>core/rbac/getPermissionActions',
                method: "POST",
                dataType: "JSON",
                data: {permId: permissionId},
                success: function (response) {
                    $('.permWrapper[data-id=' + permissionId + ']').append(rawSelectableTree);
                    treeSelector = '.permWrapper[data-id=' + permissionId + '] .jstree';
                    pManager.makeTree(treeSelector);
                    pManager.checkPermActions(treeSelector, response);
                    pManager.removeUncheckedNodes(treeSelector);
                    roleManager.handleActions(treeSelector, permissionId);
                }
            });
        }
    };

    var roleManager = {
        saveRole: function () {

            widgetHelper.addLoading();
            var roleTitle = $('input[name="title"]').val();
            var perms = JSON.stringify(roleManager.perms);
            console.log(perms);
            $.ajax({
                url: '<?= \f\ifm::app()->baseUrl ?>core/rbac/roleAdd/saveRole',
                method: "POST",
                dataType: "JSON",
                data: {roleTitle: roleTitle, perms: perms},
                success: function (response) {
                    if (response.result === 'success') {
                        widgetHelper.removeLoading( );
                        widgetHelper.successDialog('نقش با موفقیت ایجاد شد.');
                        setTimeout(function () {
                            window.location.href = '<?= \f\ifm::app()->baseUrl ?>core/rbac/roles';
                        }, 2000);
                    }
                }
            });
        },
        perms: {},
        removePerm: function (permId) {
            if (typeof (this.perms[permId]) !== 'undefined') {
                delete this.perms[permId];
            }
        },
        addPerm: function (permId) {
            this.perms[permId] = [];
        },
        excludeAction: function (permId, actionId) {
            console.log("Excluding " + permId + "[" + actionId + "]");
            if (roleManager.perms[permId].indexOf(actionId) === -1) {
                roleManager.perms[permId].push(actionId);
            }
        },
        removeExclusion: function (permId, actionId) {
            console.log(roleManager.perms[permId].indexOf(actionId));
            i = roleManager.perms[permId].indexOf(actionId);
            if (i > -1) {
                roleManager.perms[permId].splice(i, 1);
            }
        },
        resetExclusions: function (node, permId, treeSelector) {
            if (node.data.type === 'method.ui' && $(treeSelector + ' #' + node.id).length > 0) {
                if (roleManager.selectedIds.indexOf(node.id) === -1) {
                    roleManager.excludeAction(permId, node.data.id);
                }
                else
                {
                    roleManager.removeExclusion(permId, node.data.id);
                }
            }
            else if (node.children.length > 0) {
                $(node.children).each(function (i, childNode) {
                    roleManager.resetExclusions(childNode, permId, treeSelector);
                });
            }
        },
        handleActions: function (treeSelector, permissionId) {
            $(treeSelector).on('select_node.jstree', function (e, data) {
                roleManager.resetExclusionsRun(treeSelector, permissionId);
            });
            $(treeSelector).on('deselect_node.jstree', function (e, data) {
                roleManager.resetExclusionsRun(treeSelector, permissionId);
            });
        },
        resetExclusionsRun: function (treeSelector, permissionId) {
            roleManager.selectedIds = $(treeSelector).jstree('get_selected');
            var rootNode = $(treeSelector).jstree('get_json');
            roleManager.resetExclusions(rootNode[0], permissionId, treeSelector);
        }
    };

    $(document).ready(function () {
        $('.permCheck').click(function () {
            var permWrapper = $(this).parent().parent();

            var permissionId = $(permWrapper).attr('data-id');
            var currentState = $(permWrapper).attr('data-state');
            treeSelector = '.permWrapper[data-id=' + permissionId + '] .jstree';

            if (currentState === 'not-loaded') {
                pManager.loadActions(permWrapper);
                $(permWrapper).attr('data-state', 'loaded');
                roleManager.addPerm(permissionId);
            }
            else if (currentState === 'loaded')
            {
                $(treeSelector).slideUp(400);
                $(permWrapper).attr('data-state', 'hidden');
                roleManager.removePerm(permissionId);
            }
            else if (currentState === 'hidden')
            {
                $(treeSelector).slideDown(400);
                $(permWrapper).attr('data-state', 'loaded');
                roleManager.addPerm(permissionId);
                roleManager.resetExclusionsRun(treeSelector, permissionId);
            }
        });

        $('#save').click(function () {
            roleManager.saveRole();
        });
    });

</script>