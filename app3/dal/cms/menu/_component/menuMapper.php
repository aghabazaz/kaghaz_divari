<?php

class menuMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $menu_section_tbl = 'cms_menu_section' ;
    private $menu_tbl         = 'cms_menu' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function menusectionSave ()
    {
        $params = $this->request->getAssocParams () ;

        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;

        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->menu_section_tbl, $params
                ) ;
        return $result ;
    }

    public function menusectionSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->menu_section_tbl, $params,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function menusectionList ()
    {
        $pr = $this->request->getAssocParams () ;

        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.title',
                'dt' => 1,
            ),
            array (
                'db' => 't1.name',
                'dt' => 2,
            ),
            array (
                'db' => 't1.owner_id',
                'dt' => 3,
            ),
            array (
                'db' => 't1.status',
                'dt' => 4,
            ),
                ) ;

        $whereJoin = array (
            't1.id>0' ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->menu_section_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => array (),
            'whereJoin'       => $whereJoin,
            'joinType'        => '',
            'onJoin'          => '',
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function getMenuSectionById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->menu_section_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function menusectionStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;
        $this->sqlEngine->save ( $this->menu_section_tbl,
                                 array (
            'status' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ) ;
    }

    public function menusectionDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->menu_section_tbl,
                                   array (
            'id=?',
            array (
                $id )
        ) ) ;

        return array (
            'parentId' => 'success',
            'func'     => 'remove' ) ;
    }

    public function renderMenuBackend ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->menu_tbl . ' AS t1' )
                ->Where ( 't1.section_id=?', $param[ 'id' ] )
                ->OrderBy ( 'priority ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function menuStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;
        $this->sqlEngine->save ( $this->menu_tbl,
                                 array (
            'status' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ) ;
    }

    public function priorityUp ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = substr ( $param[ 'id' ], 1 ) ;

        $this->sqlEngine->Select ()
                ->From ( $this->menu_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $id )
                ->Run () ;
        $priorityup = $this->sqlEngine->getRow () ;

        //\f\pre($priorityup);

        if ( $priorityup[ 'priority' ] <= 1 )
        {
            return array (
                'result' => 'failed',
                'type'   => 'Up' ) ;
        }
        else
        {
            $uppriority = $priorityup[ 'priority' ] - 1 ;

            $this->sqlEngine->Select ()
                    ->From ( $this->menu_tbl . ' AS t1' )
                    ->Where ( 'parent_id=' . $priorityup[ 'parent_id' ] )
                    ->andWhere ( 'section_id=?', $priorityup[ 'section_id' ] )
                    ->andWhere ( 'priority=' . $uppriority )
                    ->Run () ;
            $parentId = $this->sqlEngine->getRow () ;
            $this->sqlEngine->Update ( $this->menu_tbl )
                    ->setField ( 'priority=priority+1' )
                    ->Where ( 'id=?', $parentId[ 'id' ] )
                    ->Run () ;
            $this->sqlEngine->Update ( $this->menu_tbl )
                    ->setField ( 'priority=priority-1' )
                    ->Where ( 'id=?', $priorityup[ 'id' ] )
                    ->Run () ;
            return array (
                'result'   => 'success',
                'parentId' => 'f' . $parentId[ 'id' ],
                'id'       => 'f' . $priorityup[ 'id' ],
                'type'     => 'Up'
                    ) ;
        }
    }

    public function priorityDown ()
    {
        $param        = $this->request->getAssocParams () ;
        $id           = substr ( $param[ 'id' ], 1 ) ;
        $this->sqlEngine->Select ()
                ->From ( $this->menu_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $id )
                ->Run () ;
        $prioritydown = $this->sqlEngine->getRow () ;

        $this->sqlEngine->Select ( 'count(id)' )
                ->From ( $this->menu_tbl . ' AS t1' )
                ->Where ( 'parent_id=' . $prioritydown[ 'parent_id' ] )
                ->andWhere ( 'section_id=?', $prioritydown[ 'section_id' ] )
                ->Run () ;
        $countpriority = $this->sqlEngine->getRows () ;

        if ( $prioritydown[ 'priority' ] >= $countpriority[ 0 ][ 'count(id)' ] )
        {
            return array (
                'result' => 'failed',
                'type'   => 'Down' ) ;
        }
        else
        {
            $downpriority = $prioritydown[ 'priority' ] + 1 ;

            $this->sqlEngine->Select ()
                    ->From ( $this->menu_tbl . ' AS t1' )
                    ->Where ( 'parent_id=' . $prioritydown[ 'parent_id' ] )
                    ->andWhere ( 'section_id=?', $prioritydown[ 'section_id' ] )
                    ->andWhere ( 'priority=' . $downpriority )
                    ->Run () ;
            $parentId = $this->sqlEngine->getRow () ;

            $this->sqlEngine->Update ( $this->menu_tbl )
                    ->setField ( 'priority=priority-1' )
                    ->Where ( 'id=?', $parentId[ 'id' ] )
                    ->Run () ;
            $this->sqlEngine->Update ( $this->menu_tbl )
                    ->setField ( 'priority=priority+1' )
                    ->Where ( 'id=?', $prioritydown[ 'id' ] )
                    ->Run () ;

            return array (
                'result'   => 'success',
                'parentId' => 'f' . $parentId[ 'id' ],
                'id'       => 'f' . $prioritydown[ 'id' ],
                'type'     => 'Down'
                    ) ;
        }
    }

    public function menuDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;

        $this->sqlEngine->Select ()
                ->From ( $this->menu_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        $menuremove = $this->sqlEngine->getRow () ;

        $this->sqlEngine->Update ( $this->menu_tbl )
                ->setField ( 'priority=priority-1' )
                ->Where ( 'parent_id=' . $menuremove[ 'parent_id' ] )
                ->andWhere ( 'section_id=?', $menuremove[ 'section_id' ] )
                ->andWhere ( 'priority>' . $menuremove[ 'priority' ] )
                ->Run () ;

        //\f\pre($this->sqlEngine->last_query());

        $this->sqlEngine->remove ( $this->menu_tbl,
                                   array (
            'id=?',
            array (
                $id )
        ) ) ;

        return array (
            'parentId' => 'success',
            'func'     => 'remove' ) ;
    }

    public function renderMenuAdd ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.type,t1.show_title,t1.icon,t1.id,t1.section_id AS section_id,t1.title AS Title,t1.parent_id AS parentTitle,t1.priority AS priority,t1.link AS Link,t1.content AS content,t1.status AS status,t1.picture ' )
                ->From ( $this->menu_tbl . ' AS t1' )
                ->leftJoin ( 'cms_menu AS t2' )
                ->On ( 't1.parent_id=t2.id' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function menuSave ()
    {
        $params             = $this->request->getAssocParams () ;
        $params[ 'status' ] = 'enabled' ;

        if ( ! $params[ 'parent_id' ] )
        {
            $params[ 'parent_id' ] = 0 ;
        }
        $this->sqlEngine->Select ( 'count(id)' )
                ->From ( $this->menu_tbl . ' AS t1' )//;
                ->Where ( 't1.parent_id=' . $params[ 'parent_id' ] )
                ->andWhere ( 'section_id=?', $params[ 'section_id' ] )
                ->Run () ;
        $priority = $this->sqlEngine->getRow () ;

        $params[ 'priority' ] = $priority[ 'count(id)' ] + 1 ;
        unset ( $params[ 'id' ] ) ;
        unset ( $params[ 'parentTitle' ] ) ;

        $result = $this->sqlEngine->save ( $this->menu_tbl, $params
                ) ;
        return $result ;
    }

    public function menuSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;

        //\f\pre($params);

        if ( $params[ 'parentTitle' ] != $params[ 'parent_id' ] )
        {
            $this->sqlEngine->Update ( $this->menu_tbl )
                    ->setField ( 'priority=priority-1' )
                    ->Where ( 'parent_id=' . $params[ 'parentTitle' ] )
                    ->andWhere ( 'section_id=?', $params[ 'section_id' ] )
                    ->andWhere ( 'priority>' . $params[ 'priority' ] )
                    ->Run () ;

            $this->sqlEngine->Select ( 'count(id)' )
                    ->From ( $this->menu_tbl . ' AS t1' )//;
                    ->Where ( 't1.parent_id=' . $params[ 'parent_id' ] )
                    ->andWhere ( 'section_id=?', $params[ 'section_id' ] )
                    ->Run () ;
            $priority             = $this->sqlEngine->getRow () ;
            $params[ 'priority' ] = $priority[ 'count(id)' ] + 1 ;
        }

        unset ( $params[ 'id' ] ) ;
        unset ( $params[ 'parentTitle' ] ) ;
        $result = $this->sqlEngine->save ( $this->menu_tbl, $params,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function renderMenuFrontend ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->menu_tbl . ' AS t1' )
                ->leftJoin ( $this->menu_section_tbl . ' AS t2' )
                ->On ( 't1.section_id=t2.id' )
                ->Where ( 't1.status=?', 'enabled' )
                ->andWhere ( 't2.name=?', $params[ 'name' ] )
                ->OrderBy ( 't1.priority ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function renderTopFooterMenu ()
    {
        
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->menu_tbl . ' AS t1' )
                ->leftJoin ( $this->menu_section_tbl . ' AS t2' )
                ->On ( 't1.section_id=t2.id' )
                ->Where ( 't1.status=?', 'enabled' )
                ->andWhere ( 't2.name=?', $params[ 'name' ] )
                ->OrderBy ( 't1.priority ASC' )
                ->Run () ;
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows () ;
    }
    public function renderBottomFooterMenu ()
    {
        
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->menu_tbl . ' AS t1' )
                ->leftJoin ( $this->menu_section_tbl . ' AS t2' )
                ->On ( 't1.section_id=t2.id' )
                ->Where ( 't1.status=?', 'enabled' )
                ->andWhere ( 't2.name=?', $params[ 'name' ] )
                ->OrderBy ( 't1.priority ASC' )
                ->Run () ;
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows () ;
    }

}
