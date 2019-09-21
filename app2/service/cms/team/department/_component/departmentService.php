<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \cms.team\department
 * @department component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class departmentService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.team.department' ) ;
    }

    public function departmentList ()
    {
        return \f\ttt::dal ( 'cms.team.department.departmentList',
                             $this->request->getAssocParams () ) ;
    }

    public function departmentSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.team.department.departmentSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'departmentSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.team.department.departmentSave', $params ) ;
            $msg    = \f\ifm::t ( 'departmentSave' ) ;
            $reset  = TRUE ;
        }

        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg, 'reset'   => $reset ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function departmentDelete ()
    {
        return \f\ttt::dal ( 'cms.team.department.departmentDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function departmentStatus ()
    {
        return \f\ttt::dal ( 'cms.team.department.departmentStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getDepartmentById ()
    {
        return \f\ttt::dal ( 'cms.team.department.getDepartmentById',
                             $this->request->getAssocParams () ) ;
    }
    public function getDepartmentByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.team.department.getDepartmentByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

}