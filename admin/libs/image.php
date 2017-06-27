<?php

/**
 * Image
 * 
 * @category   Tools
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2017-03-27 maxkod.pl
 * @version    1.0
 */

class Image
{

    public function __construct()
    {
    }
    
    public function NeedResize($file,$width,$height)
    {
    
        if(!list($img_w, $img_h) = @getimagesize($file))
            return false;
        
        if($img_w == $width && $img_h == $height)
            return false;
        
        return true;
    }
    
   // działa poprawnie
   public function ResizeAndCrop($src,$dest,$width,$height)
    {
        if(!list($img_w, $img_h) = @getimagesize($src))
            return false;
        
        // Load
        $source = $this->imagecreatefromfile($src);
        if (!$source)
        {
            return false;
        }

        $thumb = imagecreatetruecolor($width, $height);
        if (!$thumb)
        {
            return false;
        }
        $background = imagecolorallocate($thumb, 255, 255, 255);
        imagefill($thumb, 0, 0, $background);
                 
        /* calculate new image size with ratio */
        $ratio = max($width/$img_w, $height/$img_h);
        $h = ceil($height / $ratio);
        $x = ($img_w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
        $y = ($img_h - $height / $ratio) / 2;
   
        imagecopyresampled($thumb, $source, 0, 0, $x, $y, $width, $height, $w, $h);
        imagedestroy($source);
                
         // Output
        $type = exif_imagetype($src);
        switch ( $type )
        {
           case IMAGETYPE_JPEG:
                return imagejpeg($thumb,$dest,100);
            break;

            case IMAGETYPE_PNG:
                return imagepng($thumb,$dest);
            break;

            case IMAGETYPE_GIF:
                return imagegif($thumb,$dest);
            break;

            default:
                 return false;
            break;
        }
         
        return false;
    
    }
    

    private function imagecreatefromfile( $filename )
    {
        if (!file_exists($filename))
        {
            return false;
        }
        
        $type = exif_imagetype($filename);
        switch ($type)
        {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($filename);
            break;

            case IMAGETYPE_PNG:
                return imagecreatefrompng($filename);
            break;

            case IMAGETYPE_GIF:
                return imagecreatefromgif($filename);
            break;

            default:
                 return false;
            break;
        }
    }
    
    
//....................................................................................
//$white = imagecolorallocate($thumb, 255, 255, 255);
//$grey = imagecolorallocate($thumb, 128, 128, 128);
//$black = imagecolorallocate($thumb, 254, 191, 5);
//imagefilledrectangle($thumb, 0, 50, 60, 60, $black);


//$text = 'navsim';
// Replace path by your own font path
//$font = '../font/calibri.ttf';

// Add some shadow to the text
//imagettftext($thumb, 10, 0, 11, 21, $grey, $font, $text);

// Add the text
//imagettftext($thumb, 10, 0, 9, 58, $white, $font, $text);
//.....................................................................................


    
}
