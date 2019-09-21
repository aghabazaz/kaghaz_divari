<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 *
 * @package \core\gallery
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class galleryService extends \f\service
{

    public function creatGallery ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);

        if ( ! isset ( $_COOKIE[ $params[ 'name' ] ] ) )
        {
            $galId = rand ( 10000, 100000 ) ;
            setcookie ( $params[ 'name' ], $galId, time () + ( 864000 ), '/' ) ;

            \f\ttt::service ( 'core.fileManager.createFolder',
                [
                    'path'  => $params[ 'path' ],
                    'name'  => $galId,
                    'title' => $params[ 'title' ] ? $params[ 'title' ] : 'آلبوم پیش فرض'
                ] ) ;
        }
        else
        {
            $galId = $_COOKIE[ $params[ 'name' ] ] ;
            \f\ttt::service ( 'core.fileManager.createFolder',
                [
                    'path'  => $params[ 'path' ],
                    'name'  => $galId,
                    'title' => $params[ 'title' ] ? $params[ 'title' ] : 'آلبوم پیش فرض'
                ] ) ;
        }

        return $galId ;
    }

    public function checkGalleryExist ()
    {
        $params = $this->request->getAssocParams () ;


        $pathToGalleryFolder = \f\ifm::app ()->uploadDir . \f\DS . str_replace ( '.',
                \f\DS,
                $params[ 'path' ] ) . \f\DS . $params[ 'galleryId' ] ;

        if ( ! file_exists ( $pathToGalleryFolder ) )
        {
            \f\ttt::service ( 'core.fileManager.createFolder',
                [
                    'path'  => $params[ 'path' ],
                    'name'  => $params['galleryId'],
                    'title' => $params[ 'title' ] ? $params[ 'title' ] : 'آلبوم پیش فرض'
                ] ) ;
        }
    }

    public function updateGalleryInfo ()
    {
        $params  = $this->request->getAssocParams () ;
        $params['oldGalleryId']=$_COOKIE[$params['name']];
        $picture = \f\ttt::service ( 'core.fileManager.getList',
            array (
                'path' => $params[ 'path' ].'.'.$params['oldGalleryId'],
            ) ) ;




        $galleryDirectory= \f\ifm::app ()->uploadDir . \f\DS. str_replace ( '.',
                \f\DS,
                $params['path'] ).\f\DS ;

        $params['picture']=$picture[ 'list' ];
        rename ( $galleryDirectory . $params[ 'oldGalleryId' ],
            $galleryDirectory. $params[ 'newGalleryId' ] ) ;

        \f\ttt::dal ( 'core.gallery.updateGalInfo', $params ) ;

        setcookie ( $params['name'], '', time () - 10, '/' ) ;
    }

}
