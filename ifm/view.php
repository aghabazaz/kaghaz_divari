<?php

namespace f ;

abstract class view extends component
{

    /**
     *
     * @var \f\w\form
     */
    public $formW ;

    /**
     *
     * @var \f\w\box
     */
    public $boxW ;

    /**
     *
     * @var \f\w\pageTitle
     */
    public $pageTitleW ;

    /**
     *
     * @var \f\w\table
     */
    public $tableW ;

    /**
     *
     * @var \f\w\breadcrumb
     */
    public $breadcrumbW ;
    
    protected $viewRoot ;
    protected $layoutRoot ;
    protected $layout ;

    /**
     * Includes a script/file and returns its output as string 
     * without printing to output.
     * @param string $pathToFile path to the file
     * @return string included file/script output
     * @throws publicException if file not exists
     */
    protected function iinclude($pathToFile, $params = array ())
    {
        if ( ! file_exists($pathToFile) )
        {
            throw new publicException("'$pathToFile' was not found !") ;
        }
        
        ob_start() ;
        extract($params) ;
        include $pathToFile ;
        $fileOutput = ob_get_contents() ;
        //\f\pre($fileOutput);
        ob_end_clean() ;
        return $fileOutput ;
    }

    protected function render($file, $params = array ())
    {
        $pathToViewFile = \f\ifm::app()->componentBaseDir . \f\DS . 'view' . \f\DS . $file . '.php' ;
        
        
        return $this->iinclude($pathToViewFile, $params) ;
    }

}
