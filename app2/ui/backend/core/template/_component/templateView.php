<?php

class templateView extends \f\view
{

    public function templateTree()
    {
        $templateTree = \f\ttt::service('core.template.getAllTemplates') ;
        //\f\pr($templateTree);
        //show_source('templateController.php');
        require_once \f\ifm::app()->componentBaseDir . \f\DS . 'view' . \f\DS . 'treeView.php' ;
        $treeViewObj  = new treeView ;

        return $this->render('templateTreeView',
                             array (
                    'treeMarkup' => $treeViewObj->getTreeRecursive($templateTree)
                        // 'editDialog' => $editDialog
                )) ;
    }

    public function documentTemplate($path)
    {
        //echo $path;
        $activeLang  = \f\ttt::service('core.lang.getAllActiveLang') ;
        $defaultTemp = \f\ttt::service('core.template.getAllDefaultTemplate') ;
        $row         = \f\ttt::service('core.template.getTemplateByName',
                                       array (
                    'name' => $path )) ;
        if ( $row[ 'id' ] )
        {
            $mainDefaultTemp = \f\ttt::service('core.template.getMainDefaultTemplate',
                                               array ( 'id' => $row[ 'id' ] )) ;
            foreach ( $mainDefaultTemp AS $data )
            {
                $arrayMainDefault[ $data[ 'core_langid' ] ] = $data[ 'core_default_templateid' ] ;
            }
        }



        foreach ( $defaultTemp AS $data )
        {
            $arrayDefault[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }




        return $this->render('documentTemplate',
                             array (
                    'lang'            => $activeLang,
                    'defaultTemp'     => $arrayDefault,
                    'row'             => $row,
                    'mainDefaultTemp' => $arrayMainDefault,
                    'path'            => $path
                )) ;
    }

}
