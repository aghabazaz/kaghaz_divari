<?php

namespace f\w ;

class table extends \f\widget
{

    private $renderMarkup ;

    public function __construct()
    {
        $this->renderMarkup = '' ;
    }

    public function renderTable($params)
    {
        $renderMarkup = $this->begin($params[ 'table' ]) ;
        $renderMarkup .= $this->thead($params[ 'thead' ]) ;
        if ( $params[ 'body' ] )
        {
            $renderMarkup .= $this->defultRenderRow($params[ 'body' ]) ;
        }
        $renderMarkup .= $this->flush() ;

        return $renderMarkup ;
    }

    private function begin($params)
    {
        $beginMarkup = '' ;
        $attr        = $this->attr($params) ;
        $beginMarkup .= "</br></br></br>" ;
        if ( $params[ 'title' ] )
        {
            //$beginMarkup .= "<h2><span>".$params['title']."</span></h2>";
        }
        $beginMarkup .= "<table class='display compact' cellspacing='0' $attr>" ;
        return $beginMarkup ;
    }

    private function flush()
    {
        $flushMarkup = '' ;
        $flushMarkup .= "</tbody></table>" ;
        return $flushMarkup ;
    }

    private function thead($params = array ())
    {
        $headMarkup = '' ;
        $headMarkup .= "<thead>" ;

        foreach ( $params as $key => $value )
        {
            $attr = $this->attr($value) ;
            $headMarkup .= "<th  " . $attr . ">" . $value[ 'formatter' ] . "</th>" ;
        }

        $headMarkup .= "</thead><tbody>" ;
        return $headMarkup ;
    }

    public function renderRow($params = array ())
    {
        //\f\pr($params);
        //output is a json array from rows
        $bodyMarkup = array () ;
        $paramsTr   = $params ;
        $i          = 0 ;
        if ( $paramsTr )
        {
            foreach ( $paramsTr as $key => $value )
            {
                if ( count($paramsTr) == 2 )
                {
                    break ;
                }

                $paramsTd = $value[ 'td' ] ;

                if ( $paramsTd )
                {
                    foreach ( $paramsTd as $key0 => $value0 )
                    {
                        $bodyMarkup[ $i ][] = $value0[ 'formatter' ] ;
                    }
                }
                $i ++ ;
                if ( $i + 1 == count($paramsTr) - 1 )
                {
                    break ;
                }
            }
        }
        if ( $paramsTr[ 'draw' ] )
        {
            $dr = intval($paramsTr[ 'draw' ]) ;
        }
        else
        {
            $dr = 1 ;
        }
        return array (
            "draw"            => $dr,
            "recordsTotal"    => intval($paramsTr[ 'total' ]), //intval($_POST['length']),
            "recordsFiltered" => intval($paramsTr[ 'total' ]),
            "data"            => $bodyMarkup
                ) ;
    }

    private function defultRenderRow($params = array ())
    {
        /*
          output is a string from rows
         */
        $bodyMarkup = '' ;
        $paramsTr   = $params ;
        foreach ( $paramsTr as $key => $value )
        {
            $attr = $this->attr($value) ;
            $bodyMarkup .= "<tr " . $attr . ">" ;

            $paramsTd = $value[ 'td' ] ;
            foreach ( $paramsTd as $key => $value )
            {
                $attr = $this->attr($value) ;
                $bodyMarkup .= "<td  " . $attr . ">" . $value[ 'formatter' ] . "</td>" ;
            }

            $bodyMarkup .= "</tr>" ;
        }
        return $bodyMarkup ;
    }

    private function attr($params)
    {
        $htmlOptionsArr = isset($params[ 'htmlOptions' ]) ? $params[ 'htmlOptions' ] : array () ;
        $htmlOptions    = $this->paramsToAttr($htmlOptionsArr) ;

        $styleArr = isset($params[ 'style' ]) ? $params[ 'style' ] : array () ;
        $style    = ! empty($styleArr) ? "style='" . $this->paramsToCss($styleArr) . "'" : "" ;

        return "$htmlOptions $style" ;
    }

    private function paramsToAttr($params)
    {
        $attr = '' ;
        foreach ( $params as $key => $value )
        {
            $attr .= " $key='$value' " ;
        }

        return $attr ;
    }

    private function paramsToCss($params)
    {
        $css = '' ;
        foreach ( $params as $key => $value )
        {
            $css .= "$key: $value; " ;
        }

        return $css ;
    }

}
