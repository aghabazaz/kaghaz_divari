<?php

/**
 * Database
 */
class galleryMapper extends \f\dal
{

    /**
     *
     * @var \f\g\validator
     */
    public $sqlEngine ;

    /**
     *
     * @var dataTable 
     */
    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function updateGalInfo ()
    {
        $params= $this->request->getAssocParams();
        $this->sqlEngine->save ( 'core_file',
                                 array (
            'title' => $params[ 'title' ],
            'name'  => $params[ 'newGalleryId' ]
                ),
                                 array (
            'name=?',
            array (
                $params[ 'oldGalleryId' ]) ) ) ;
        
        $params['path'].='.';
        
        $this->sqlEngine->save('core_file', array(
            'path'=>$params['path'].$params[ 'newGalleryId' ]
        ),array(
            'path=?',array($params['path'] .  $params[ 'oldGalleryId' ])
        ));
        
        foreach ( $params['picture'] AS $data )
        {
            unset ( $_SESSION[ 'file' . $data[ 'id' ] ] ) ;
            
            $pathFile = explode ( '.', $data[ 'path' ] ) ;

            $newPath = $params['path'] . $params[ 'newGalleryId' ] . '.' . $pathFile[ count($pathFile)-1 ] ;
            $this->sqlEngine->save ( 'core_file',
                                     array (
                'path' => $newPath
                    ),
                                     array (
                'id=?',
                array (
                    $data[ 'id' ] ) ) ) ;
        }

        /*
        $this->sqlEngine->Update ( 'core_file' )
                ->setField ( "path=REPLACE(path,'" . $params['path'] .  $params[ 'oldGalleryId' ] . "','" . $params['path'] .  $params[ 'newGalleryId' ] . "')" )
                ->Where ( "path LIKE '%" . $params['path'] .  $params[ 'oldGalleryId' ] . "%'" )
                ->Run () ;
         * 
         */
    }

}
