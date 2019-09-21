<?php

/**
 * This component detects modules/components/plugins from
 * project source code structure and manages them.
 * 
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 * @package core.template
 * @category component
 */
class templateService extends \f\service
{

    public function getAllTemplates ()
    {
        $path              = \f\ifm::app ()->templateDir ;
        $directoryScanner  = new directoryScanner ;
        $templateStructure = $directoryScanner->scanDirRecursive ( $path ) ;

        foreach ( $templateStructure as $key => $val )
        {
            ksort ( $templateStructure[ $key ] ) ;
        }
        return $templateStructure ;
    }

    public function getAllDefaultTemplate ()
    {
        return \f\ttt::dal ( 'core.template.defaultTemplate' ) ;
    }

    
    public function getAllActiveTemplate ()
    {
        return \f\ttt::dal ( 'core.template.allActiveTemplate' ) ;
    }

    public function getTemplateByName ()
    {
        //\f\pr($param);
        return \f\ttt::dal ( 'core.template.getTemplateByName',
                             $this->request->getAssocParams () ) ;
    }

    public function documentSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( isset ( $params[ 'id' ] ) || \f\ttt::dal ( 'core.template.repeatTemplateName',
                                                        array (
                    'name' => $params[ 'name' ] ) ) )
        {
            if ( !( $params[ 'id' ] ) )
            {
                $result         = \f\ttt::dal ( 'core.template.saveTemplate',
                                                $params ) ; 
                $params[ 'id' ] = $result ;
            }
            else
            {
                \f\ttt::dal ( 'core.template.removeDefaultTemplate',
                              array (
                    'id' => $params[ 'id' ] ) ) ;
                $result = \f\ttt::dal ( 'core.template.editTemplate', $params ) ;
            }
            if ( $params[ 'type' ] == 'main' )
            {
                $i       = 0 ;
                $default = $params[ 'default' ] ;
                foreach ( $params[ 'lang' ] AS $data )
                {
                    if ( isset ( $default[ $i ] ) )
                    {
                        \f\ttt::dal ( 'core.template.setDefaultTemplate',
                                      array (
                            'core_templateid'         => $params[ 'id' ],
                            'core_default_templateid' => $default[ $i ],
                            'core_langid'             => $data
                        ) ) ;
                    }

                    $i ++ ;
                }
            }
            if ( $result )
            {
                $out = array (
                    'success',
                    \f\ifm::t ( 'successMsg' ) ) ;
            }
            else
            {
                $out = array (
                    'error',
                    \f\ifm::t ( 'dbError' ) ) ;
            }
        }
        else
        {
            $out = array (
                'error',
                \f\ifm::t ( 'repeatNameError' ) ) ;
        }
        return $out ;
    }
    
    public function getMainDefaultTemplate ()
    {
        return \f\ttt::dal ( 'core.template.getMainDefaultTemplate',
                             $this->request->getAssocParams () ) ;
    }

}
