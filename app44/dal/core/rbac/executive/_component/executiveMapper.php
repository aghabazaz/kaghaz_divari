<?php

class executiveMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine   = new \f\sqlStorageEngine ;
        $this->cacheEngine = new \f\cacheStorageEngine ;
    }

    private function getMyActions()
    {
        include __DIR__ . \f\DS . 'action.php' ;
        $actionObj = new action ;
        
       

        $userId = $this->request->getParam('userId') ;

        return $actionObj->getActionsWithFilters($userId) ;
    }

    public function cacheMyPermissions()
    {

        $actions = $this->getMyActions() ;

        $permissions = $this->getMyPermissions() ;

        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $this->sessionG->write('actions', $actions) ;
        $this->sessionG->write('permissions', $permissions) ;
        //return $_SESSION;
    }

    public function cacheAllActions()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $this->sqlEngine->Select('*')
                ->From('core_action')
                ->Run() ;

        $allActions = $this->sqlEngine->getRows() ;

        $cachableActions = array () ;

        foreach ( $allActions as $action )
        {
            $action[ 'permissionId' ] = '' ;

            $action[ 'filterId_p' ]    = '' ;
            $action[ 'filterId_upaf' ] = '' ;
            $action[ 'filterId_uraf' ] = '' ;
            $action[ 'filterId_rpaf' ] = '' ;

            $cachableActions[ $action[ 'path' ] ] = $action ;
        }

        $this->sessionG->write('actions', $cachableActions) ;
        $this->sessionG->write('permissions', array ()) ;
    }

    public function getMyAction()
    {
        $params = $this->request->getAssocParams() ;

        $fetchSource = $params[ 'fetchSource' ] ;
        $userId      = $params[ 'userId' ] ;
        
        //$this->cacheEngine->clear();

        if ( $fetchSource === 'cache' )
        {
            if ( $this->cacheEngine->exists("actions_$userId") )
            {
                 //\f\pr('hi');
                $actions = $this->cacheEngine->fetch("actions_$userId") ;
            }
            else # cache actions not exists
            {
                $actions = $this->getMyActions() ;
                $this->cacheEngine->store("actions_$userId", $actions) ;
            }
        }
        else
        {
           
            $actions = $this->getMyActions() ;
        }
         
        return $actions ;
    }

    public function getCachedPermissions()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $actions     = $this->sessionG->read('actions') ;
        $permissions = $this->sessionG->read('permissions') ;

        return array (
            'actions'     => $actions,
            'permissions' => $permissions
                ) ;
    }

    private function getMyPermissions()
    {
        include __DIR__ . \f\DS . 'permission.php' ;
        $permissionObj = new permission ;

        $userId = $this->request->getParam('userId') ;

        return $permissionObj->getMyPermissions($userId) ;
    }

}
