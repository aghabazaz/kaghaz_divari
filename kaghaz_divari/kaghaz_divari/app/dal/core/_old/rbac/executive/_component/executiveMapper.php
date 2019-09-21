<?php

class executiveMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
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
       
        $actions     = $this->getMyActions() ;
        
        $permissions = $this->getMyPermissions() ;

        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;        
        
        $this->sessionG->write('actions', $actions) ;
        $this->sessionG->write('permissions', $permissions) ;
        //return $_SESSION;
    }
    public function getMyAction()
    {
       
        $actions     = $this->getMyActions() ;
        
       
        return $actions;
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
