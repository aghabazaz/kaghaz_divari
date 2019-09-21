<?php
$title = $row ? 'editfeature' : 'addfeature' ;
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


$type = array (
    'text'        => \f\ifm::t ( 'text' ),
    'textarea'        => \f\ifm::t ( 'textarea' ),
    'multiSelect' => \f\ifm::t ( 'multiSelect' ),
    'oneSelect'   => \f\ifm::t ( 'oneSelect' ),
    'yesOrNo'     => \f\ifm::t ( 'yesOrNo' ),
        ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listfeature' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/feature/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/feature/featureSave',
        'id'     => 'featureAdd'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'title',
        'value'       => $row[ 'title' ],
        'placeholder' => \f\ifm::t ( 'ex_title' )
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'title_long',
        'value'       => $row[ 'title_long' ],
        'placeholder' => \f\ifm::t ( 'ex_title_long' )
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title_long' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'parameter' )
    )
        ) ) ;
echo $form ;
?>
<div style="border:1px solid #ddd " id="paramBox">
    <div style="background: #ddd;padding: 5px;" class="paramHeader">
        <div class="col-md-3">عنوان</div>
        <div class="col-md-3">نوع</div>
        <div class="col-md-4">گزینه ها</div>
        <div class="col-md-1">اجباری</div>
        <div class="col-md-1">عملیات</div>
        <div class="clear"></div>
    </div>
    <div class="bodyParam">
        <?php
        if ( ! empty ( $parameter ) )
        {
            foreach ( $parameter AS $data )
            {
                $id = $data[ 'id' ] ;
                if ( $data[ 'type' ] == 'multiSelect' || $data[ 'type' ] == 'oneSelect' )
                {
                    $display = 'display:block' ;
                }
                else
                {
                    $display = 'display:none' ;
                }
                ?>
                <div style="padding: 5px;border-bottom: 1px solid #ddd;cursor: move" class="paramRow">
                    <div class="col-md-3">

                        <input type="hidden" name="idParam[]" id="id" value="f<?= $id ?>">
                        <?php
                        echo $this->formW->select ( array (
                            'htmlOptions' => array (
                                'id'   => 'titleParam' . $id,
                                'name' => 'titleParam[]',
                            ),
                            'choices'     => $wiki,
                            'selected'    => $data[ 'shop_wiki_id' ],
                            'validation'  => array (
                                'required' => ''
                            ),
                            'block'       => ''
                        ) ) ;
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo $this->formW->select ( array (
                            'htmlOptions' => array (
                                'id'    => 'typef' . $id,
                                'name'  => 'type[]',
                                'class' => 'typeParam'
                            ),
                            'choices'     => $type,
                            'selected'    => $data[ 'type' ],
                            'validation'  => array (
                                'required' => ''
                            ),
                            'block'       => ''
                        ) ) ;
                        ?>
                    </div>
                    <div class="col-md-4">
                        <div class="optionParam" style="<?= $display ?>">
                            <?php
                            echo $this->formW->select ( array (
                                'htmlOptions' => array (
                                    'id'       => 'optionf' . $id,
                                    'name'     => 'optionf' . $id . '[]',
                                    'multiple' => TRUE
                                ),
                                'choices'     => $wiki,
                                'selected'    => json_decode ( $data[ 'options' ],
                                                               TRUE ),
                                'block'       => '',
                            ) ) ;
                            ?> 
                        </div>

                    </div>
                    <div class="col-md-1">
                        <div class='simple-checkbox' style="margin-top:10px">
                            <input id="rf<?= $id ?>" name="requiredf<?= $id ?>" value="1" type='checkbox' class='checkBox' <?php if ( $data[ 'required' ] ) echo 'checked' ; ?>/>
                            <label for="rf<?= $id ?>"></label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <a href="javascript:void(0)" class="removeParam">
                            <i class="fa fa-times-circle fa-2x"  style="margin-top:12px"></i>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
        }
        else
        {
            ?>
            <div style="padding: 5px;border-bottom: 1px solid #ddd;cursor: move" class="paramRow">
                <div class="col-md-3">
                    <?php
                    $id = rand ( 10000, 100000 ) ;
                    ?>
                    <input type="hidden" name="idParam[]" id="id" value="f<?= $id ?>">
                    <?php
                    echo $this->formW->select ( array (
                        'htmlOptions' => array (
                            'id'   => 'titleParamf' . $id,
                            'name' => 'titleParam[]',
                        ),
                        'choices'     => $wiki,
                        'selected'    => '',
                        'validation'  => array (
                            'required' => ''
                        ),
                        'block'       => ''
                    ) ) ;
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                    echo $this->formW->select ( array (
                        'htmlOptions' => array (
                            'id'    => 'typef' . $id,
                            'name'  => 'type[]',
                            'class' => 'typeParam'
                        ),
                        'choices'     => $type,
                        'selected'    => $row[ 'city_id' ] ? $row[ 'city_id' ] : '',
                        'validation'  => array (
                            'required' => ''
                        ),
                        'block'       => ''
                    ) ) ;
                    ?>
                </div>
                <div class="col-md-4">
                    <div class="optionParam">
                        <?php
                        echo $this->formW->select ( array (
                            'htmlOptions' => array (
                                'id'       => 'optionf' . $id,
                                'name'     => 'optionf' . $id . '[]',
                                'multiple' => TRUE
                            ),
                            'choices'     => $wiki,
                            'selected'    => '',
                            'block'       => '',
                        ) ) ;
                        ?> 
                    </div>

                </div>
                <div class="col-md-1">
                    <div class='simple-checkbox' style="margin-top:10px">
                        <input id="rf<?= $id ?>" name="requiredf<?= $id ?>" type='checkbox' value="1" class='checkBox' <?php if ( $data[ 'required' ] ) echo 'checked' ; ?>/>
                        <label for="rf<?= $id ?>"></label>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="javascript:void(0)" class="removeParam">
                        <i class="fa fa-times-circle fa-2x"  style="margin-top:12px"></i>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
            <?php
        }
        ?>


    </div>

</div>
<br>
<a href='javascript:void(0)' id ='addParam'><i class='fa fa-plus-circle fa-2x'></i> <?= 'اضافه کردن پارامتر فنی جدید' ?></a>
<?php
$form = $this->formW->fieldsetEnd () ;

$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#featureAdd');

    jQuery(document).ready(function ()
    {
        $(".bodyParam").sortable();

        var i = 1;
        $("#addParam").click(function () {
            $('select').select2('destroy');
            var row = $(".paramRow:first").clone();

            var id = $(".paramRow:first #id").val();
            var newId = Math.floor(Math.random() * 100000) + 10000;
            //alert(newId);
            var regex = new RegExp(id, 'g');
            var newRow = row.html().replace(regex, 'f'+newId);
            var newRow = '<div class="paramRow ui-sortable-handle" style="padding: 5px;border-bottom: 1px solid #ddd;cursor: move">' + newRow + '</div>';
            //alert(newRow);
            $(".bodyParam").append(newRow);

            widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');

            $(".paramRow:last").find("select").each(function ()
            {
                //alert($(this).attr('id'));
                $(this).select2('val', 'All');

            });
            $('.paramRow:last a.removeParam').on('click', function ()
            {
                var rowCount = $('.paramRow').length;
                if (rowCount > 1)
                {
                    $(this).closest('.paramRow').remove();
                } else
                {
                    alert('وارد کردن حداقل یک سطر برای پارمترهای فنی الزامی است.');
                }
                return false;
            });
            $('.typeParam:last').on('change', function () {
                var val = $(this).val();
                //alert(val);
                if (val == 'oneSelect' || val == 'multiSelect')
                {
                    //alert('show');
                    $(this).closest('.paramRow').find("div.optionParam").fadeIn();
                } else
                {
                    //alert($(this).closest('.paramRow').find("div.optionParam").html());
                    $(this).closest('.paramRow').find("div.optionParam").fadeOut();
                }
            });
            i++;
        });
        $('a.removeParam').on('click', function () {
            var rowCount = $('.paramRow').length;
            if (rowCount > 1)
            {
                $(this).closest('.paramRow').remove();
            } else
            {
                alert('وارد کردن حداقل یک سطر برای پارمترهای فنی الزامی است.');
            }
            return false;
        });
        $('.typeParam').on('change', function () {
            var val = $(this).val();
            //alert(val);
            if (val == 'oneSelect' || val == 'multiSelect')
            {
                //alert('show');
                $(this).closest('.paramRow').find("div.optionParam").fadeIn();
            } else
            {
                //alert($(this).closest('.paramRow').find("div.optionParam").html());
                $(this).closest('.paramRow').find("div.optionParam").fadeOut();
            }
        });
    });
    
    function reload()
    {
        location.reload();
    }
</script>