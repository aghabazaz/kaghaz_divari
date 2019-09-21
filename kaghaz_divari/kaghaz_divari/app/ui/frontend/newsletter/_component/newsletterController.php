<?php

class newsletterController extends \f\controller
{

    /**
     *
     * @var newsletterView
     */
    private $view;

    public function __construct ( $params )
    {
        include_once 'newsletterView.php';
        $this->view = new newsletterView;
        parent::__construct( $params );
    }

    public function getNewsLetterBlock ()
    {
        return $this->renderPartial( $this->view->getNewsLetterBlock() );
    }

    public function newsletterShareSave ()
    {
        $params = $this->request->getAssocParams();
        if ( empty ( $params['email'] ) )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'enterEmailOrMobile' ) ] );
        } else
        {
            return $this->response( \f\ttt::service( 'newsletter.newsletterSave',
                $params ) );
        }
    }

}
