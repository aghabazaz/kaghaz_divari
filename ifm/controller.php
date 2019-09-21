<?php

namespace f ;

abstract class controller extends component
{

    /**
     *
     * @var request 
     */
    protected $request ;

    /**
     *
     * @var string the layout name
     */
    private $layout ;
    private $pathToLayout ;

    /**
     *
     * @var string contains website template name
     */
    private $templateName ;

    /**
     *
     * @var string contains website page name
     */
    private $pageName ;

    /**
     *
     * @var string Contains target template page name for this controller output to load into
     */
    private $templatePageName ;

    public function __construct($params = '')
    {
        //\f\pr($params);

        if ( is_array($params) && ! empty($params) && isset($params[ 'componentType' ]) )
        {
            $this->templateName  = $params[ 'templateName' ] ;
            $this->componentType = $params[ 'componentType' ] ;
            $this->pageName      = $params[ 'pageName' ] ;
            $this->domainStatus  = $params[ 'domainStatus' ] ;
            $layout              = '' ;
            
            //\f\pr($params);
        }
        else
        {
            $this->componentType = 'ui.backend' ;

            $layout = '' ;
        }

        $this->setLayout($layout) ;
    }

    public function setRequest($request)
    {
        $this->request = $request ;
    }

    public function getLayout()
    {
        return array (
            'layout'       => str_replace(DS, '.', $this->layout),
            'pathToLayout' => $this->pathToLayout
                ) ;
    }

    public function setLayout($layoutCatalog)
    {

        $layoutParts = array_filter(explode('.', trim($layoutCatalog))) ;

        $endType = $this->componentType === 'ui.frontend' ? 'frontend' : 'backend' ;

        switch ( count($layoutParts) )
        {
            case 0:
                if ( $this->componentType === 'ui.frontend' )
                {
                    $layoutName = ifm::app()->defaultFrontendTemplate ;
                }
                else
                {
                    $layoutName = ifm::app()->defaultBackendTemplate ;
                }
                break ;

            case 2: # backward compatibility
                $layoutName = $layoutParts[ 1 ] ;
                break ;
        }

        if ( $this->componentType === 'ui.frontend' )
        {
            $this->pathToLayout = ifm::app()->templateDir . DS . $this->templateName ;
        }
        else
        {
            $this->layout       = $endType . DS . $layoutName . DS . "$layoutName" ;
            $this->pathToLayout = ROOT . DS . 'app' . DS . 'ui' . DS . 'templates' . DS . $this->layout . '.php' ;
        }
    }

    public function response($responseData)
    {
        $response = new response ;
        $response->setType('json') ;
        $response->setData($responseData) ;

        return $response ;
    }

    protected function render($content)
    {
        //\f\pr($this->componentType);

        if ( $this->componentType === 'ui.frontend' )
        {
            $renderResult = \f\siteLoader::load(array (
                        'templateName'     => $this->templateName,
                        'requestCatalog' => $this->pageName,
                        'domainStatus'     => $this->domainStatus,
                        'requestParams'    => array (
                            'content' => $content
                        )
                    )) ;
        }
        else
        {
            if ( ! is_array($content) )
            {
                $content = array (
                    'content' => $content
                        ) ;
            }

            $renderResult = $this->iinclude($this->pathToLayout, $content) ;
        }

        $response = new response ;
        $response->setType('layouted') ;
        $response->setData($renderResult) ;

        return $response ;
    }

    protected function renderPartial($content)
    {
        $response = new response ;
        $response->setType('partial') ;
        $response->setData($content) ;

        return $response ;
    }

    protected function checkParams($request, $params)
    {
        foreach ( $params as $param )
        {
            if ( $request->getParam($param) === false )
            {
                return false ;
            }
        }
        return true ;
    }

    /**
     * Includes a script/file and returns its output as string 
     * without printing to output.
     * @param string $pathToFile path to the file
     * @return string included file/script output
     * @throws publicException if file not exists
     */
    private function iinclude($pathToFile, $variables)
    {
        if ( ! file_exists($pathToFile) )
        {
            throw new publicException("'$pathToFile' was not found !") ;
        }

        extract($variables) ;

        ob_start() ;
        include $pathToFile ;
        $fileOutput = ob_get_contents() ;
        ob_clean() ;
        return $fileOutput ;
    }

}
