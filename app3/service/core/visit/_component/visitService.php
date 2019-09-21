<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\visit
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class visitService extends \f\service
{
    public function setVisit()
    {
        return \f\ttt::dal ( 'core.visit.setVisit',
                             $this->request->getAssocParams () ) ;
        
    }
    public function getDataVisit()
    {
        return \f\ttt::dal ( 'core.visit.getDataVisit',
                             $this->request->getAssocParams () ) ;
        
    }
    public function visitAll()
    {
        return \f\ttt::dal ( 'core.visit.visitAll',
                             $this->request->getAssocParams () ) ;
        
    }
    public function visitDay()
    {
        return \f\ttt::dal ( 'core.visit.visitDay',
                             $this->request->getAssocParams () ) ;
        
    }
    public function alexaRank ( )
    {
        $params=  $this->request->getAssocParams();
        return \f\ttt::dal ( 'core.visit.alexaRank',
                             $params ) ;
        
       
    }
    public function getChartByCount ( )
    {
        
        $params=  $this->request->getAssocParams();
        $row=\f\ttt::dal ( 'core.visit.getChartByCount',
                             $params ) ;
       
        if($params['id']=='country')
        {
            $countryArray=\f\ttt::dal ( 'core.visit.getCountryArray') ;
            
            //\f\pr($countryArray);
            $i=0;
            $other=0;
            $country=array();
            foreach ($row AS $data)
            {
                if($i<7)
                {
                    $country[$i]['rows']=$data['rows'];
                    $country[$i]['columns']=$countryArray[$data['columns']]?$countryArray[$data['columns']]:'نامشخص';
                }
                else
                {
                    $other+=$data['rows'];
                }
                
                $i++;
            }
            if($i>=7)
            {
                $country[7]['rows']=$other;
                $country[7]['columns']='سایر کشورها';
            }   
           
            return $country;
        }
        else
        {
            return $row;
        }
        
       
    }
 
    public function getChartByDate ( )
    {
        $params=  $this->request->getAssocParams();
        $row=\f\ttt::dal ( 'core.visit.getChartByDate',
                             $params ) ;
        
        
       // \f\pre($params);
        foreach ($row AS $data)
        {
            $countByDate[$data['date']]=$data['num_visit'];
            $countByDate2[$data['date']]=$data['num_visitor'];
        }
        //\f\pre($countByDate);
        //$countByDate=array_count_values($array);
        for($i=($params['numDay']-1);$i>=0;$i--)
        {
            $date=date('Ymd',  strtotime('-'.$i.' Days'));
            $mainArray[]=array('columns'=>  ($i%5==0)?$this->format_date($date):'','rows'=>$countByDate[$date]?$countByDate[$date]:0);
            $mainArray2[]=array('columns'=>  ($i%5==0)?$this->format_date($date):'','rows'=>$countByDate2[$date]?$countByDate2[$date]:0);
            //echo $date.'<br>' ;
        }
        //\f\pre($mainArray);
        return array($mainArray,$mainArray2);
        
       
    }
    public function format_date($date)
    {
        $this->registerGadgets(array(
                'dateG'=>'date'));
        
        $dateJa=$this->dateG->parse_date($date);
        $formattedJaDate=  explode(' ',$this->dateG->dateGrToJa(implode ( '/', $dateJa ),2));
        
        return $formattedJaDate[0].' '.$formattedJaDate[1];
    }
    
}