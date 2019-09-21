<?php

class pictureMapper extends \f\dal
{

    public $sqlEngine;
    private $dataTable;
    private $galleryPic_tbl = 'cms_gallery_pic';
    private $product_related_tbl = 'shop_product_related';
    private $product_gift_tbl = 'shop_product_gift';
    private $product_feature_tbl = 'shop_product_feature';
    private $product_price_tbl = 'shop_product_price';
    private $product_rate_tbl = 'shop_product_rate';
    private $product_price_history_tbl = 'shop_product_price_history';
    private $shop_amazing = 'shop_amazing';
    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;
        $this->dataTable = \f\dalFactory::make('core.dataTable');
    }
    public function pictureList()
    {
        $pr = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];
        $columns = array(
            array(
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array(
                'db' => 't1.title',
                'dt' => 1,
            ),
            array(
                'db' => 't1.status',
                'dt' => 2,
            )
        );


        $whereJoin = array(1);

        $result = array(
            'requestDataTble' => $requestDataTable,
            'tableName' => $this->galleryPic_tbl . ' AS t1',
            'primaryKey' => 't1.id',
            'columnsArray' => $columns,

        );
        $out = $this->dataTable->getDataTable($result);
        return $out;
    }
    public function getPictureById()
    {
        $param = $this->request->getAssocParams();
       // \f\pre($param);
        $this->sqlEngine->Select('t1.*')
            ->From($this->galleryPic_tbl . ' AS t1')
            ->Where('t1.status=?', 'enabled')
            ->andWhere('t1.id=?', $param['id'])
            ->Run();
        return $this->sqlEngine->getRow();
    }
    public function pictureSave()
    {
        $params = $this->request->getAssocParams();
        //\f\pre($params);
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['date_register'] = time();
        $params['pictureUrl']=f\ttt::service( 'core.fileManager.getFileUrlById',

            [

                'fileId' => $params['picture']

            ] );

        $result = $this->sqlEngine->save($this->galleryPic_tbl,
            array(
                'title' => $params['title'],
                'title_en' => $params['title_en'],
                'picture' => $params['picture'],
                'pictureUrl' => $params['pictureUrl'],
            )
        );
      // \f\pr($params);
       // \f\pre($this->sqlEngine->last_query());
        $id = $result;


        //rename gallery folder
        $galId = $_SESSION['galId'];
        $params['pictureUrl']=f\ttt::service( 'core.fileManager.getFileUrlById',

            [

                'fileId' => $params['picture']

            ] );
       // \f\pre($params['pictureUrl']);
        $picture = \f\ttt::service('core.fileManager.getList',
            array(
                'path' => 'cms.picture.' . $galId,
            ));


        rename(\f\ifm::app()->uploadDir . \f\DS . 'cms' . \f\DS . 'picture' . \f\DS . $galId,
            \f\ifm::app()->uploadDir . \f\DS . 'cms' . \f\DS . 'picture' . \f\DS . $id);

        $this->sqlEngine->save('core_file',
            array(
                'title' => $params['title'],
                'name' => $id
            ),
            array(
                'name=?',
                array(
                    $galId)));

        $path = 'cms.picture.';
        $this->sqlEngine->save('core_file', array(
            'path' => $path . $id
        ), array(
            'path=?', array($path . $galId)
        ));

        foreach ($picture['list'] AS $data) {
            unset ($_SESSION['file' . $data['id']]);
            $pathFile = explode('.', $data['path']);
            $newPath = 'cms.picture.' . $id . '.' . $pathFile[3];
            $this->sqlEngine->save('core_file',
                array(
                    'path' => $newPath
                ),
                array(
                    'id=?',
                    array(
                        $data['id'])));
        }

        unset ($_SESSION['galId']);

        return $result;
    }
    public function pictureSaveEdit ()
    {
        $params              = $this->request->getAssocParams () ;
        $params[ 'picture' ] = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $id                  = $params[ 'id' ] ;
        $params['pictureUrl']=f\ttt::service( 'core.fileManager.getFileUrlById',

            [

                'fileId' => $params['picture']

            ] );
       // \f\pre($params['pictureUrl']);
        $result = $this->sqlEngine->save ( $this->galleryPic_tbl,
            array (
                'title'             => $params[ 'title' ],
                'picture'           => $params[ 'picture' ],
                'title_en' => $params['title_en'],
                'pictureUrl' => $params['pictureUrl'],
            ),
            array (
                'id=?',
                array (
                    $id ) )
        ) ;

        return $result ;
    }
    public function pictureDelete()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $this->sqlEngine->remove($this->galleryPic_tbl,
            array(
                'id=?',
                array(
                    $id)));

        return array(
            'result' => 'success',
            'func' => 'remove');
    }
    public function pictureStatus()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save($this->galleryPic_tbl,
            array(
                'status' => $status
            ),
            array(
                'id=?',
                array(
                    $id)));

        return array(
            'result' => 'success',
            'status' => $status,
            'id' => $id,
            'func' => 'status');
    }
    public function getPictureByOwnerId()
    {
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');

        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select()
            ->From($this->galleryPic_tbl . ' AS t1')
            ->Where('t1.owner_id=?', $ownerId)
            ->andWhere('status=?', 'enabled')
            ->OrderBy('title ASC')
            ->Run();
        return $this->sqlEngine->getRows();
    }
    public function getPictureListFront(){
       $this->sqlEngine->Select('t1.*')
            ->From($this->galleryPic_tbl . ' AS t1')
            ->Where('t1.status=?','enabled' )
            ->Run();
       $row=$this->sqlEngine->getRows();
      // $i=0;
       //\f\pr($row);
      // $arrayList=array();
      /* foreach ($row as $data){
           $arrayList[$i]=$this->getGalleryPicDetails($data['id']);
           $i++;
       }*/
      // \f\pre($arrayList);
        return $row;
    }
    public function getGalleryPicDetails($idVal){
       // $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.*')
            ->From($this->galleryPic_tbl . ' AS t1')
            ->Where('t1.status=?','enabled' )
            ->andWhere('t1.id=?',$idVal)
            ->Run();
    //    \f\pr($idVal);
    //   \f\pr($this->sqlEngine->last_query());
        return $this->sqlEngine->getRows();
    }
}
