<?php

/**
 * 
 * This sub component does following tasks :
 * 1- filter permissions 
 * 
 * @author mina hajian <mn.hajian@gmail.com>
 * @package core.rbac.filter
 * @category component
 * 
 */
class filterService extends \f\service
{

    public function getfilterMakers ()
    {

        return \f\ttt::dal ( 'core.rbac.getfilterMakers',
                             $this->request->getAssocParams () ) ;
    }

    public function getfilterMaker ()
    {
        return \f\ttt::dal ( 'core.rbac.getfilterMaker',
                             array ( 'actionId' => $this->request->getParam ( 'actionId' ) ) ) ;
    }

    public function getFilters ()
    {
        return \f\ttt::dal ( 'core.rbac.getFilters',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getFilter(){
        return \f\ttt::dal('core.rbac.getFilter',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function filterSave ()
    {
        $params = $this->request->getAssocParams () ;
        
        $data[ 'id' ]    = $params[ 'id' ] ;
        $data[ 'title' ] = $params[ 'title' ] ;
        $data[ 'core_actionid' ] = $params[ 'core_actionid' ] ;
        $valid  = $this->validFilter ( $data ) ;
        if ( ! is_array($valid) )
        {
             
            $result = \f\ttt::dal('core.rbac.saveFilter', $data) ;
            $filterid = ( $data[ 'id' ] ) ? $data[ 'id' ] : $result ;
            $this->saveParamFilter($params, $filterid);
            
            if ( $result )
            {
                $out = array ( 'success', \f\ifm::t('successSave') ) ;
            }
            else
            {
                $out = array ( 'error', \f\ifm::t('errorDB') ) ;
            }
        }
        else
        {
            $out = array ( 'error', $valid ) ;
        }
        return $out ;
    }
    
    public function filterRemove(){
        $result = \f\ttt::dal('core.rbac.filterRemove',
                              array ( 'id' => $this->request->getParam('id') )) ;
        if ( $result )
        {
            return array (
                'func' => 'remove'
                    ) ;
        }
        return false ;
    }
    
    public function getFiltersMethod(){
        return \f\ttt::dal('core.rbac.getFiltersMethod',
                           array ( 'filter_maker_id' => $this->request->getParam('filter_maker_id') )) ;
    }
    
    private function saveParamFilter($params, $filterid){
        
        foreach ( $params['setting'] as $key => $value )
        {
            $data['keyValues'][ $key ] = $value ;
        }
        $data['params'] = array('filterid' => $filterid,'core_actionid' => $params['core_actionid']);
        
        \f\ttt::service ( 'core.setting.saveKeyGroup',$data ) ;
        
    }
    
    private function validFilter($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult'  => array (
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'title' ] )
                )
            )
                ) ;
        if ( $validator->group($paramGroupV) === false )
        {
            return $validator->getMessage() ;
        }
        else
        {
            return true ;
        }
    }


}

?>
