<?php

class templateMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function defaultTemplate()
    {
        $this->sqlEngine->Select()
                ->From('core_template')
                ->Where('status=?','enabled')
                ->andWhere ('type=?','default')
                ->OrderBy ('title ASC')
                ->Run();
        
        return $this->sqlEngine->getRows ();
    }
    public function allActiveTemplate()
    {
        $this->sqlEngine->Select()
                ->From('core_template')
                ->Where('status=?','enabled')
                ->OrderBy ('title ASC')
                ->Run();
        
        return $this->sqlEngine->getRows ();
    }
    
    public function getTemplateByName()
    {
        $name=$this->request->getParam ( 'name' );
        $this->sqlEngine->Select()
                ->From('core_template')
                ->Where('name=?',$name)
                ->Run();
        
        return $this->sqlEngine->getRow ();
    }
    public function repeatTemplateName()
    {
        $name=$this->request->getParam ( 'name' );
        $this->sqlEngine->Select('id')
                ->From('core_template')
                ->Where('name=?',$name)
                ->Run();
        if($this->sqlEngine->numRows ())
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
        
    }
    
    public function saveTemplate()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->save('core_template', array(
            'name'=>$params['name'],
            'title'=>$params['title'],
            'status'=>$params['status'],
            'type'=>$params['type'],
            
        ));
        
        return $this->sqlEngine->last_id ();
    }
    
    public function editTemplate()
    {
        $params = $this->request->getAssocParams () ;
        $result=$this->sqlEngine->save('core_template', array(
            'name'=>$params['name'],
            'title'=>$params['title'],
            'status'=>$params['status'],
            'type'=>$params['type'],
            
        ),array('id=?',array($params['id'])));
        
        return $result;
    }
    
    public function removeDefaultTemplate()
    {
        $id=$this->request->getParam ( 'id' );
        
        $this->sqlEngine->remove('core_default_template_lang', array(
            'core_templateid=?',array($id)
        ));
        
    }
    
    public function setDefaultTemplate()
    {
        $result=$this->sqlEngine->save('core_default_template_lang',$this->request->getAssocParams () );  
        return $result;
    }
    
    public function getMainDefaultTemplate ()
    {
        $params= $this->request->getAssocParams ();
        $this->sqlEngine->Select()
                ->From('core_default_template_lang')
                ->Where('core_templateid=?',$params['id'])
                ->Run();
        
        return $this->sqlEngine->getRows ();
    }

}
?>
