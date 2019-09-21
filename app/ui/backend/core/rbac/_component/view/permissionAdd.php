<style>
    #selectMethodToggle{
        border: 1px solid rgb(232, 227, 227);
        padding: 4px;
        background-color: whitesmoke;
        cursor: pointer;
        margin-left: 20px;
        margin-bottom: 20px;
        width: 35px;
    }
    #selectMethodToggle:hover{
        background-color:rgb(53, 126, 189);
        color: white;

    }

    #selectMethodToggle.showState > span.downBtn{
        display: none;
    }

    #selectMethodToggle.showState > span.topBtn{
        display: inline;
    }    

    #selectMethodToggle.hideState > span.downBtn{
        display: inline;
    }

    #selectMethodToggle.hideState > span.topBtn{
        display: none;
    }  
</style>

<div id="contentDv">

    <?php
    /* @var $this rbacView */

    $this->registerWidgets(array (
        'pageTitleW' => 'pageTitle',
        'boxW'       => 'box',
        'formW'      => 'form',
        'dialogW'    => 'dialog'
    )) ;

    echo $this->pageTitleW->renderTitle(array (
        'title' => 'ایجاد دسترسی جدید',
        'links' => array ( array (
                'title' => \f\ifm::t('permissionList'),
                'href'  => \f\ifm::app()->baseUrl . 'core/rbac/permissions'
            ) )
    )) ;

    echo $this->boxW->begin(array (
        'type'  => 'form',
        'title' => 'ایجاد دسترسی جدید'
    )) ;

    $formMarkup = '' ;

    $formMarkup .= $this->formW->begin(array (
        'htmlOptions' => array (
            'method' => 'post',
            'action' => \f\ifm::app()->baseUrl . 'core/rbac/permissionAdd/savePerm',
            'id'     => 'permissionForm'
        ),
            )) ;

    $formMarkup .= $this->formW->input(array (
        'htmlOptions' => array (
            'type' => 'hidden',
            'name' => 'id',
            'id'   => 'pr_id',
        ),
        'inline'      => true
            )) ;

    ### Permission title ###

    $formMarkup .= $this->formW->rowStart() ;

    $formMarkup .= $this->formW->input(array (
        'htmlOptions' => array (
            'type' => 'text',
            'name' => 'title',
        ),
        'validation'  => array (
            'required' => ''
        ),
        'block'       => true,
        'style'       => array (
            'direction' => 'rtl',
        ),
        'label'       => array (
            'text' => 'عنوان',
        )
            )) ;

    $formMarkup .= $this->formW->rowEnd() ;

    ### Project tree ###

    $formMarkup.= $this->formW->rowStart() ;

    $formMarkup.= $this->formW->fieldsetStart(array (
        'htmlOptions' => array (
            'id' => 'methodFieldset'
        ),
            )) ;
    $formMarkup .= "
        <div class='alert alert-warning alert-dismissable' style='width: 496px; margin-top: 10px;'>
            <a href='' class='close' style='position: inherit'>×</a>
            برای ایجاد دسترسی از ساختار درختی زیر عملیات مورد نظر را انتخاب کنید.
	</div>  
        ساختار درختی پروژه :<br><br>
        " ;
    $formMarkup .= "<div id='codeTree' style='margin-right:10px;'>" ;
    // display code tree

    $formMarkup .= \f\ttt::ui('ui.backend.core.code.viewSelectableCodesList',
                              array (
                'treeid' => 'jstree'
            )) ;

    $formMarkup .= "</div>" ;
    $formMarkup.= $this->formW->fieldsetEnd() ;

    $formMarkup.= $this->formW->rowEnd() ;

    $formMarkup.='<div class="col-sm-9" id="hidInput"></div>' ;
    $formMarkup.='<div class="col-sm-9" id="hidFilter"></div>' ;

    $formMarkup .= $this->formW->rowStart() ;
    $formMarkup .= $this->formW->button(array (
        'htmlOptions' => array (
            'type' => 'submit',
            'id'   => 'save',
        ),
        'inline'      => array (),
        'content'     => 'ذخیره'
            )) ;

    $formMarkup.=$this->formW->rowEnd() ;

    $formMarkup .= $this->formW->rowEnd() ;

    $formMarkup .= $this->formW->flush() ;

    $pathToHelpFile = __DIR__ . \f\DS . 'helps' . \f\DS . 'permHelp.php' ;
    //$helpMarkup     = $this->iinclude($pathToHelpFile) ;
    $widgetContent  = "
        <div class='row'>
            <div class='col-md-6'>" . $formMarkup . "
            <div class='col-md-6' >" . $helpMarkup . "</div>
        </div>        
        " ;
    echo $widgetContent ;
    ?>
</div>

<script>

    var treeEvents = {
        /* On Node select Handler */
        onSelectNode: function (e, data) {
            console.log('node selected');
            $('#jstree').jstree('open_node', data.node);
            firstChildNode = $('#' + data.node.children[0]);
            if (data.node.children.length === 1 && typeof ($(firstChildNode).attr('data-id')) === 'undefined') {
                $('#jstree').jstree('open_node', firstChildNode);
            }
        },
        /* On Node deselect Handler */
        onDeselectNode: function (e, data) {
            nodeLevel = data.node.li_attr['data-path'];
            console.log(data.node);
            if (typeof (nodeLevel) !== 'undefined' && nodeLevel !== '1') {
                $('#jstree').jstree('close_node', data.node);
            }
        }
    };
    var treeManager = {
        setTreeEvents: function () {
            $('#jstree').on('select_node.jstree', treeEvents.onSelectNode);
            $('#jstree').on('deselect_node.jstree', treeEvents.onDeselectNode);
        },
        initNewMode: function () {
            $("#jstree").jstree('close_all');
            /* Open root node */
            $("#jstree").jstree('open_node', $('li[aria-level=1]:visible'));
            this.setTreeEvents();
        },
        initEditMode: function (actions) {
            this.initNewMode();
            this.setTreeEvents();
        }
    };
    $(document).ready(function ()
    {
        treeManager.initNewMode();
        widgetHelper.makeSelect2('select', 'انتخاب کنید');
        $('#permissionForm').submit(function () {
            var selectedIds = $('#jstree').jstree('get_selected');
            var selectedsArr = [];
            $(selectedIds).each(function (i, selectedId) {
                nodeEl = $('#jstree').jstree('get_node', selectedId);
                id = nodeEl.li_attr['data-id'];
                type = nodeEl.li_attr['data-type'];
                if (typeof (type) !== 'undefined' && type === 'method.ui') {
                    selectedsArr.push({
                        type: type,
                        id: id
                    });
                }
            });
            console.log(selectedsArr);
            selectedsString = JSON.stringify(selectedsArr);
            var actionsEl = "<input type='hidden' name='selectedCodes' value='" + selectedsString + "'>";
            $('#permissionForm').prepend(actionsEl);
        });
        widgetHelper.formSubmit('#permissionForm');
    });
</script>