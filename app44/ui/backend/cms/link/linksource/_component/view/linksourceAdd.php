<?php
//echo $param;
$title = $row ? 'editattlink' : 'addattlink' ;
//var_dump($param);
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'attlink' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/link/linksource/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



 $form = '' ;

        $form.=$this->formW->begin ( array (
            'htmlOptions' => array (
                'method' => 'post',
                'action' => \f\ifm::app ()->baseUrl . 'cms/link/linksource/linksourceSave',
                'id'     => 'attlink-form'
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
                'type'       => 'text',
                'name'       => 'title',
                'value'      => $row[ 'title' ],
            ),
            'validation' => array (
                'required' => ''
            ),
            'label'    => array (
                'text'  => \f\ifm::t ( 'titleattlink' ),
            ),
           
                ) ) ;
        $form.=$this->formW->rowEnd () ;

                $form.=$this->formW->rowStart () ;
        $form.=$this->formW->input ( array (
            'htmlOptions' => array (
                'type'       => 'text',
                'name'       => 'link',
                'value'      => $row[ 'link' ],
            ),
            'validation' => array (
                'required' => ''
            ),
            'label'    => array (
                'text'  => \f\ifm::t ( 'link' ),
            ),
           
                ) ) ;
        $form.=$this->formW->rowEnd () ;
        
        
        
        $form.=$this->formW->rowStart () ;
        $form.=$this->formW->select ( array (
            'htmlOptions' => array (
                'id'       => 'category_id',
                'name'     => 'category_id',
                //'onchange' => 'getCityByStateId()'
            ),
            'label'    => array (
                'text'       => \f\ifm::t ( 'category' ),
            ),
            'choices'    => $category,
            'selected'   => $row[ 'category_id' ] ? $row[ 'category_id' ] : '',
          
            'validation' => array (
                'required' => ''
            ),
                ) ) ;

        $form.=$this->formW->rowEnd () ;
 
        $form.=$this->formW->rowStart () ;
        $form.=$this->formW->buttonTag ( array (
            'htmlOptions' => array (
                'type'    => 'submit',
                'id'      => 'submit-contact'
            ),
            'content' => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
                ) ) ;
        $form.=$this->formW->rowEnd () ;


        $form.=$this->formW->flush () ;

        echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.formSubmit('#attlink-form');
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&language=fa"></script>


<div id="ipDialog">
    <div id="map" style="height:550px"></div> 
</div>
