<?php

namespace f\w ;

class dialog extends \f\widget
{

    public function begin($params)
    {
        $id = $params[ 'htmlOptions' ][ 'id' ] ;
        unset($params[ 'htmlOptions' ][ 'id' ]) ;

        $title  = $params[ 'title' ][ 'text' ] ;
        $markup = "<div class='modal fade' id='$id' >" ;

        $params[ 'htmlOptions' ][ 'class' ] = ! isset($params[ 'style' ][ 'class' ]) ? '' : $params[ 'style' ][ 'class' ] ;
        $params[ 'htmlOptions' ][ 'class' ] = $params[ 'style' ][ 'class' ] . ' modal-dialog' ;
        $markup .= \f\html::markupBegin('div', $params) ;
        $markup .= "<div class='modal-content'>
              <div class='modal-header dialog-header-form'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title' id='myModalLabel'><i class='fa fa-edit' ></i> $title</h4>
              </div>";
        $params['body']['htmlOptions']['class']='modal-body';
         $markup .= \f\html::markupBegin('div', $params['body']) ;
             
        return $markup ;
    }

    public function flush($params)
    {
        $footerContent = isset($params[ 'footer' ]) ? $params[ 'footer' ][ 'content' ] : '' ;
        $markup        = "</div>" ;
        if ( ! empty($footerContent) )
        {
            $markup .= "<div class='modal-footer'>       
                            $footerContent
                        </div>" ;
        }
        $markup .= "</div></div></div>" ;

        return $markup ;
    }
    

}
