<?php

namespace f\w ;

class box extends \f\widget
{
    private $icon=array(
        'table'=>'table',
        'form'=>'edit',
        'chart'=> 'bar-chart-o',
        'search'=> 'search',
        'file'=> 'file-o'
    );
    
    public function begin($params)
    {
        $boxMarkup=\f\html::markupBegin ( 'div', array ( 'htmlOptions' => array ( 'class' => 'widget widget-table','id'=>'box'.$params['id'] ) ) );
        $boxMarkup.=\f\html::markupBegin ( 'div', array ( 'htmlOptions' => array ( 'class' => 'widget-header' ) ) );
        $boxMarkup.=\f\html::markupBegin ( 'h3', array ());
        $boxMarkup.=\f\html::readyMarkup( 'i','',array('htmlOptions'=>array('class'=>'fa fa-'.  $this->icon[$params['type']])),true );
        $boxMarkup.=\f\html::markupBegin ( 'span', array ( 'htmlOptions' => array ( 'id' => $params['id'] ) ) );
        $boxMarkup.= $params['title'];
        $boxMarkup.=\f\html::markupEnd ( 'span' );
        $boxMarkup.=\f\html::markupEnd ( 'h3' );
        if($params['focus'] || $params['expand'] || $params['remove'])
        {
            $boxMarkup.=\f\html::markupBegin ( 'div', array ( 'htmlOptions' => array ( 'class' => 'btn-group widget-header-toolbar' ) ) );
            if($params['focus'])
            {
                $boxMarkup.='<a href="javascript:void(0)" title="Focus" class="btn-borderless btn-focus"><i class="fa fa-eye"></i></a>';
            }
            if($params['expand'])
            {
                $boxMarkup.='<a href="javascript:void(0)" title="Expand/Collapse" class="btn-borderless btn-toggle-expand"><i class="fa fa-chevron-up"></i></a>';
            }
            if($params['remove'])
            {
                $boxMarkup.='<a href="javascript:void(0)" title="Remove" class="btn-borderless btn-remove"><i class="fa fa-times"></i></a>';
            }
            $boxMarkup.=\f\html::markupEnd ( 'div' );
        }
        $boxMarkup.=\f\html::markupEnd ( 'div' );
        
        $boxMarkup.=\f\html::markupBegin ( 'div', array ( 'htmlOptions' => array ( 'class' => 'widget-content' ) ) );
        
        return $boxMarkup;
    }
    public function flush()
    {
         $boxMarkup=\f\html::markupEnd ( 'div' );
         $boxMarkup.=\f\html::markupEnd ( 'div' );
         
         return $boxMarkup;
    }

}
