<?php

class treeView extends \f\component
{

    private $arrayTemp ;
    private $icons;

    public function __construct()
    {
        require_once __DIR__ . \f\DS . 'config.php' ;
        $this->extractVars($iconsUrl) ;
        $this->icons=$iconsUrl;
        
    }

    private function extractVars($vars)
    {
        foreach ( $vars as $key => $value )
        {
            $this->$key = $value ;
        }
    }

    public function iconicLiOpen($urlToIcon, $title, $data = array ())
    {
        $data[ 'data-jstree' ]   = '{"icon" : "' . $urlToIcon . '"}' ;
        $params[ 'htmlOptions' ] = $data ;
        return \f\html::markupBegin('li', $params) . $title ;
    }

    public function getTreeRecursive($templateArray)
    {
        $treeMarkup = \f\html::markupBegin('div',
                                           array (
                    'htmlOptions' => array (
                        'id' => 'jstree'
            ) )) ;
        
        $path= \f\ifm::app ()->templateDir.\f\DS ;
        $this->arrayTemp=  $this->arrayOfTemplate();
        
        //\f\pre($templateArray);

        $treeMarkup .= \f\html::markupBegin('ul') ;
        $this->generateTreeMarkup($templateArray,$treeMarkup,$path,'',1) ;
        $treeMarkup .= \f\html::markupEndGroup(array ( 'ul', 'div' )) ;
        return $treeMarkup ;
    }

    private function openLi($dirName, $fileName,$path,$level)
    {
        
        if(  is_array ($fileName))
        {
            $liTitle = $dirName ;
            if($level==1)
            {
                if(isset($this->arrayTemp[$dirName]))
                {
                    $liTitle=$this->arrayTemp[$dirName];
                }
                else
                {
                    $liTitle.=' <span style="color:red;font-size:11px">( '.\f\ifm::t ('notRegisterd').' )</span>';
                }
                $urlToIcon = $this->template ;
                $data    = array (
                    'data-path' => $dirName,
                    'data-type' => "template"
                    ) ;
            }
            else
            {
                $urlToIcon = $this->folder ;
                $data=array(
                    
                    'data-type' => "folder"
                );
            }
            
        }
        else
        {
            
            $liTitle = $fileName ;
            $filePart=  explode('.', $fileName);
            if(isset($this->icons[$filePart[1]]))
            {
                 $urlToIcon = $this->{$filePart[1]};
                  $data    = array (
                    'data-path' => $path.$fileName,
                    'data-type' => "file"
                    ) ;
            }
            else
            {
                $urlToIcon=  $this->file;
                 $data    = array (
                   
                    'data-type' => "file"
                    ) ;
            }
           
           
        }
        
        
        
        
        return $this->iconicLiOpen($urlToIcon, $liTitle, $data) ;
    }
    private function generateTreeMarkup($templateArray, &$treeMarkup, $currentRoute,$currentPath='',$level='')
    {
        foreach ( $templateArray as $dirName => $structure )
        {
            if(!is_array($structure))
            {
                $path      = $currentPath ;
                $tempRoute = $currentRoute;
            }
            else
            {
                $path      = $currentPath . ( ! empty ( $currentPath ) ? \f\DS : '') . $dirName ;
                $tempRoute = $currentRoute . $dirName . \f\DS ;
            }
            
            
            
            $treeMarkup .= $this->openLi($dirName, $structure,$tempRoute,$level) ;
            $treeMarkup .= \f\html::markupBegin('ul') ;
            
            
            if ( is_array($structure))
            {
				
                 $this->generateTreeMarkup($structure, $treeMarkup,$tempRoute,$path) ;
                
            }
            
            
            $treeMarkup .= \f\html::markupEnd('ul') ;

            $treeMarkup .= \f\html::markupEnd('li') ;
        }

       
    }
    private function arrayOfTemplate()
    {
        $allTemp= \f\ttt::service('core.template.getAllActiveTemplate');
        //$arrayTemp=array();
        foreach ($allTemp AS $data)
        {
            $arrayTemp[$data['name']]=$data['title'];
        }
        return $arrayTemp;
    }


}