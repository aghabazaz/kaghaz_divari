<?php
class pictureController extends \f\controller{
    private  $view;
    public function __construct ( $params = '' )
    {
        include_once 'pictureView.php';
        $this->view=new pictureView;
        parent::__construct ( $params ) ;
    }
    public function getPictureList(){
        $params=$this->request->getAssocParams();
        $content=$this->view->renderPictureList();
        $array=array(
            'content'=>$content,
            'websiteInfo'=>$params['websiteInfo'],
            'title'=>'گالری تصاویر'
        );
        return $this->render($array);
    }
    public function getGalleryPicDetails(){
        $params=$this->request->getAssocParams();
        $param=$this->request->getParam(0);

        $content=$this->view->renderGalleryPicDetails($param);
        $array=array(
            'content'=>$content,
            'websiteInfo'=>$params['websiteInfo'],
            'title'=>'گالری تصویر'
        );
        return $this->render($array);
    }
}


