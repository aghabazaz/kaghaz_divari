<?php

namespace f\g ;

class resizeg
{

// *** Class variables
    private $image ;
    private $editedImage ;
    private $width ;
    private $height ;

    function __construct($fileName)
    {
// *** Open up the file
        $this->image = $this->openImage($fileName) ;

// *** Get width and height
        $this->width  = imagesx($this->image) ;
        $this->height = imagesy($this->image) ;
    }

    private function openImage($file)
    {
// *** Get extension
        $extension = strtolower(strrchr($file, '.')) ;

        switch ( $extension )
        {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($file) ;
                break ;
            case '.gif':
                $img = @imagecreatefromgif($file) ;
                break ;
            case '.png':
                $img = @imagecreatefrompng($file) ;
                break ;
            default:
                $img = false ;
                break ;
        }

        return $img ;
    }

    public function resizeImage($newWidth, $newHeight, $option = "auto")
    {

// *** Get optimal width and height - based on $option
        $optionArray = $this->getDimensions($newWidth, $newHeight,
                                            strtolower($option)) ;

        $optimalWidth  = $optionArray[ 'optimalWidth' ] ;
        $optimalHeight = $optionArray[ 'optimalHeight' ] ;

// *** Resample - create image canvas of x, y size
        $this->editedImage = imagecreatetruecolor($optimalWidth, $optimalHeight) ;
        imagecopyresampled($this->editedImage, $this->image, 0, 0, 0, 0,
                           $optimalWidth, $optimalHeight, $this->width,
                           $this->height) ;

// *** if option is 'crop', then crop too
//        if ( $option == 'crop' )
//        {
//            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) ;
//        }
    }

    private function getDimensions($newWidth, $newHeight, $option)
    {

        switch ( $option )
        {
            case 'exact':
                $optimalWidth  = $newWidth ;
                $optimalHeight = $newHeight ;
                break ;
            case 'portrait':
                $optimalWidth  = $this->getSizeByFixedHeight($newHeight) ;
                $optimalHeight = $newHeight ;
                break ;
            case 'landscape':
                $optimalWidth  = $newWidth ;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth) ;
                break ;
            case 'auto':
                $optionArray   = $this->getSizeByAuto($newWidth, $newHeight) ;
                $optimalWidth  = $optionArray[ 'optimalWidth' ] ;
                $optimalHeight = $optionArray[ 'optimalHeight' ] ;
                break ;
            case 'crop':
                $optionArray   = $this->getOptimalCrop($newWidth, $newHeight) ;
                $optimalWidth  = $optionArray[ 'optimalWidth' ] ;
                $optimalHeight = $optionArray[ 'optimalHeight' ] ;
                break ;
        }
        return array ( 'optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight ) ;
    }

    private function getSizeByFixedHeight($newHeight)
    {
        $ratio    = $this->width / $this->height ;
        $newWidth = $newHeight * $ratio ;
        return $newWidth ;
    }

    private function getSizeByFixedWidth($newWidth)
    {
        $ratio     = $this->height / $this->width ;
        $newHeight = $newWidth * $ratio ;
        return $newHeight ;
    }

    private function getSizeByAuto($newWidth, $newHeight)
    {
        if ( $this->height < $this->width )
// *** Image to be resized is wider (landscape)
        {
            $optimalWidth  = $newWidth ;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth) ;
        }
        elseif ( $this->height > $this->width )
// *** Image to be resized is taller (portrait)
        {
            $optimalWidth  = $this->getSizeByFixedHeight($newHeight) ;
            $optimalHeight = $newHeight ;
        }
        else
// *** Image to be resizerd is a square
        {
            if ( $newHeight < $newWidth )
            {
                $optimalWidth  = $newWidth ;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth) ;
            }
            else if ( $newHeight > $newWidth )
            {
                $optimalWidth  = $this->getSizeByFixedHeight($newHeight) ;
                $optimalHeight = $newHeight ;
            }
            else
            {
// *** Sqaure being resized to a square
                $optimalWidth  = $newWidth ;
                $optimalHeight = $newHeight ;
            }
        }

        return array ( 'optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight ) ;
    }

    private function getOptimalCrop($newWidth, $newHeight)
    {

        $heightRatio = $this->height / $newHeight ;
        $widthRatio  = $this->width / $newWidth ;

        if ( $heightRatio < $widthRatio )
        {
            $optimalRatio = $heightRatio ;
        }
        else
        {
            $optimalRatio = $widthRatio ;
        }

        $optimalHeight = $this->height / $optimalRatio ;
        $optimalWidth  = $this->width / $optimalRatio ;

        return array ( 'optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight ) ;
    }

    public function crop($newWidth, $newHeight, $option = "auto")
    {
        $oXCenter = $this->width / 2 ;
        $oYCenter = $this->height / 2 ;

        $h = $this->height ;
        $w = $this->width ;

        if ( $this->width <= $newWidth )
        {
            $cStartX = 0 ;
            $cEndX   = $this->width ;
            $w       = $this->width ;
        }
        else
        {
            $cStartX = $oXCenter - ($newWidth / 2) ;
            $cEndX   = $oXCenter + ($newHeight / 2) ;
            $w       = $newWidth ;
        }

        if ( $this->height <= $newHeight )
        {
            $cStartY = 0 ;
            $cEndY   = $this->height ;
            $h       = $this->height ;
        }
        else
        {
            $cStartY = $oYCenter - ($newWidth / 2) ;
            $cEndY   = $oYCenter + ($newHeight / 2) ;
            $h       = $newHeight ;
        }

//        \f\pr(" w : " . $w . ' - h : ' . $h . ' - cEndX : ' . $cEndX . ' -  cEndY : ' . $cEndY . ' - cStartX : ' . $cStartX . ' - cStartY : ' . $cStartY . ' - width : ' . $this->width . ' - height : ' . $this->height) ;
        // *** Now crop from center to exact requested size
        $this->editedImage = imagecreatetruecolor($w, $h) ;

        imagecopyresampled($this->editedImage, $this->image, 0, 0, $cStartX,
                           $cStartY, $w, $h, $w, $h) ;
    }

    public function saveImage($savePath, $imageQuality = "100")
    {
        // *** Get extension
        $extension = strrchr($savePath, '.') ;
        $extension = strtolower($extension) ;

        switch ( $extension )
        {
            case '.jpg':
            case '.jpeg':
                if ( imagetypes() & IMG_JPG )
                {
                    imagejpeg($this->editedImage, $savePath, $imageQuality) ;
                }
                break ;

            case '.gif':
                if ( imagetypes() & IMG_GIF )
                {
                    imagegif($this->editedImage, $savePath) ;
                }
                break ;

            case '.png':
// *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality / 100) * 9) ;

// *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality ;

                if ( imagetypes() & IMG_PNG )
                {
                    imagepng($this->editedImage, $savePath, $invertScaleQuality) ;
                }
                break ;

// ... etc

            default:
// *** No extension - No save.
                break ;
        }

        imagedestroy($this->editedImage) ;
    }

    public function addWaterMark($waterMarkPath)
    {
// Load the stamp and the photo to apply the watermark to
        $stamp = $this->openImage($waterMarkPath) ;

// Set the margins for the stamp and get the height/width of the stamp image
        $marge_right  = 5 ;
        $marge_bottom = 5 ;
        $sx           = imagesx($stamp) ;
        $sy           = imagesy($stamp) ;
        
        //\f\pre('ok');

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
        $this->editedImage = $this->image ;
        imagecopy($this->editedImage, $stamp,
                  imagesx($this->editedImage) - $sx - $marge_right,
                          imagesy($this->editedImage) - $sy - $marge_bottom, 0,
                                  0, imagesx($stamp), imagesy($stamp)) ;

// Output and free memory
    }

}

class imageEdit
{

    public function resize($params)
    {
        $sourcePath = $params[ 'sourcePath' ] ;
        $destPath   = $params[ 'destPath' ] ;

        $newWidth  = $params[ 'newWidth' ] ;
        $newHeight = $params[ 'newHeight' ] ;

        $resizer = new resizeg($sourcePath) ;

        $resizer->resizeImage($newWidth, $newHeight, 'auto') ;

        $resizer->saveImage($destPath, 100) ;
        unset($resizer) ;
    }

    public function addWatermark($params)
    {
        $sourcePath = $params[ 'sourcePath' ] ;
        $destPath   = $params[ 'destPath' ] ;

        $waterMarkPath = $params[ 'waterMarkPath' ] ;

        $resizer = new resizeg($sourcePath) ;

        $resizer->addWaterMark($waterMarkPath) ;

        $resizer->saveImage($destPath, 100) ;

        unset($resizer) ;
    }

    public function cropImage($params)
    {
        $sourcePath = $params[ 'sourcePath' ] ;
        $destPath   = $params[ 'destPath' ] ;

        $newWidth  = $params[ 'newWidth' ] ;
        $newHeight = $params[ 'newHeight' ] ;

        $resizer = new resizeg($sourcePath) ;

        $resizer->crop($newWidth, $newHeight) ;

        $resizer->saveImage($destPath, 100) ;

        unset($resizer) ;
    }

}
