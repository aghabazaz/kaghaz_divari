<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\contact
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class contactService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.contact' ) ;
    }

    public function contactList ()
    {
        return \f\ttt::dal ( 'cms.contact.contactList',
                             $this->request->getAssocParams () ) ;
    }

    public function contactSave ()
    {
        $params = $this->request->getAssocParams () ;
        $result = \f\ttt::dal ( 'cms.contact.contactSave', $params ) ;


        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => 'دیدگاه شما با موفقیت ثبت شد.',
                'reset'   => TRUE ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => 'اشکال در ارتباط با سرور! لطفا چند لحظه دیگر تلاش کنید...' ) ;
        }

        return $data ;
    }

    public function contactDelete ()
    {
        return \f\ttt::dal ( 'cms.contact.contactDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function getContactById ()
    {
        $param = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.contact.getContactById', $param ) ;
    }

    public function getContactByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.contact.getContactByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getMainPageContact ()
    {
        return \f\ttt::dal ( 'cms.contact.getMainPageContact',
                             $this->request->getAssocParams () ) ;
    }


}
