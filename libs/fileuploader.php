<?php


class FileUploader extends Base
{

    public $IsValid = true;         // flaga czy pole zawiera poprawne dane
    
    private $NoError = TRUE;
    
    private $Images = NULL;         //[name] => [n], [type] => [n], [tmp_name] => [n], [error] => [n], [size]=> [n] (n - n plikow)
    private $ImageNames = NULL;
    private $ImagePositions = NULL;
    
    public $ImagesUploaded = NULL;
    
    public $OneImageUploaded = NULL;
    
    private $Files = NULL;
    private $FileNames = NULL;
    private $FilePositions = NULL;
    
    public $FilesUploaded = NULL;
    
    private $ImagesCount = 0;
    private $FilesCount = 0;
    
    private $UploadMaxSize;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->GetUploadMaxSize();
        
        $this->Images = $_FILES['image'];
        $this->Files = $_FILES['file'];
        
        if (isset($_POST['image_name']) AND isset($_POST['image_position'])){
            
            $this->ImageNames = array_reverse($_POST['image_name']);
            $this->ImagePositions = array_reverse($_POST['image_position']);
           
        }
                
        if (isset($_POST['file_name']) AND isset($_POST['file_position'])){
            
            $this->FileNames = array_reverse($_POST['file_name']);
            $this->FilePositions = array_reverse($_POST['file_position']);
            
        }
        
        if ($this->UploadImagesFilter()){
            
            $this->UploadImages();
            
        }
        
        if ($this->UploadFilesFilter()){
            
            $this->UploadFiles();
            
        }
        
    
    }

       
    public function NoError()
    {
        
        return $this->NoError;
        
    }
    
    
    
    private function UploadImagesFilter(){
        
        $PreValidate = FALSE;
        
        $this->ImagesCount = count($this->Images['name']);
        $FirstImageSize = end($this->Images['size']);
        
        if ($this->ImagesCount > 1 && $FirstImageSize == 0) {
        
            $this->NoError = $this->NoError .'plik pierwszy nie wgrany';
            
            $PreValidate = FALSE;
            
        } else if ($FirstImageSize > 0) {
            
            $PreValidate = TRUE;
            
        }
        
        return $PreValidate;
        
    }
    
    private function UploadFilesFilter(){
        
        $PreValidate = FALSE;
        
        $this->FilesCount = count($this->Files['name']);
        $FirstFileSize = end($this->Files['size']);
        
        if ($this->FilesCount > 1 && $FirstFileSize == 0) {
        
            $this->NoError = $this->NoError .'plik pierwszy nie wgrany';
            
            $PreValidate = FALSE;
            
        } else if ($FirstFileSize > 0) {
            
            $PreValidate = TRUE;
            
        }
        
        return $PreValidate;
        
    }
    
    
    private function UploadImages(){
              
        $ImagesToUpload = NULL;
        
        $counter = 0;
        foreach ($this->Images['name'] AS $counter => $value)
        { 
            
            //print $this->TransliterateStringToFile($this->Images['name'][$counter]).'=>'.$this->ImageNames[$counter];
            //[name] => [n], [type] => [n], [tmp_name] => [n], [error] => [n], [size]=> [n] (n - n plikow)
            
            $ImagesToUpload[$counter]['name'] = $this->Images['name'][$counter];
            $ImagesToUpload[$counter]['type'] = $this->Images['type'][$counter];
            $ImagesToUpload[$counter]['tmp_name'] = $this->Images['tmp_name'][$counter];
            $ImagesToUpload[$counter]['error'] = $this->Images['error'][$counter];
            $ImagesToUpload[$counter]['size'] = $this->Images['size'][$counter];
            
            /*$aExtraInfo = getimagesize($this->Images['tmp_name'][$counter]);
            $sImage = "data:" . $aExtraInfo["mime"] . ";base64," . base64_encode(file_get_contents($this->Images['tmp_name'][$counter]));
            echo '<p>The image has been uploaded successfully</p><p>Preview:</p><img src="' . $sImage . '" alt="Your Image" />';*/
            
        }
        
        $counter = 0;
        //echo getcwd();
        if (is_array($ImagesToUpload))
        {
            
            $this->ImagesUploaded = array();           
            
            foreach ($ImagesToUpload AS $UploadImage)
            {                      

                $UploadResult = $this->SaveUploadedFile($UploadImage,Settings::$ImagesFolder);

                if ($UploadResult)
                {
                
                    /* Example of $ImageInfo
                    Array
                    (
                    [0] => 1110
                    [1] => 1717
                    [2] => 2
                    [3] => width="1110" height="1717"
                    [bits] => 8
                    [channels] => 3
                    [mime] => image/jpeg
                    )
                    */ 
                
                    /*$ImageInfo = getimagesize(Settings::$ImagesFolder.$UploadResult);
                
                    $ImageWidth = $ImageInfo[0];
                    $ImageHeight = $ImageInfo[1];
  				
                    if ($ImageWidth > $ImageHeight)
                    {
			  
				        $ImageOrientation = 'landscape';
			  
                    } 
                    else 
                    {   
				
                        $ImageOrientation = 'portret';
			
                    }*/
                       
                    $ImageFileName = $UploadResult;
                    
                    $this->ImagesUploaded[$counter]['img'] = $ImageFileName;
                        
                    $this->ImagesUploaded[$counter]['name'] = ($this->ImageNames[$counter] == '' ? NULL : $this->ImageNames[$counter]);
                        
                    $this->ImagesUploaded[$counter]['position'] = $this->ImagePositions[$counter];
                
                
                    $imageResizeObj = new imageLib(Settings::$ImagesFolder.$ImageFileName);
                
                
                    foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues)
                    {
                    
                        $imageResizeObj -> resizeImage($ImgSizeValues['width'], $ImgSizeValues['height'], 'crop-t', true);
                        $imageResizeObj -> saveImage(Settings::$ImagesFolder.'/'.$ImgSizeValues['folder'].'/'.$ImageFileName, $ImgSizeValues['quality']);
                    
                        $imageResizeObj -> reset();
                    
                    }
	
                }
                
                ++$counter;
                
            } 
        }    
    }       
    
    public function CreateNewImageSizes($Images=NULL)
    {
        
        $sql = "SELECT * FROM image WHERE position=1 /*OR position=1*/";
        $Images = $this->DB->Query($sql, NULL, PDO::FETCH_ASSOC);
        
        foreach ($Images AS $Image){
        
        $ImageFileName = $Image['img'];
        //print Settings::$ImagesFolder.$ImageFileName;
        $imageResizeObj = new imageLib(Settings::$ImagesFolder.$ImageFileName);
                
        foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues)
        {
                    
            $imageResizeObj -> resizeImage($ImgSizeValues['width'], $ImgSizeValues['height'], 'crop-t', true);
            $imageResizeObj -> saveImage(Settings::$ImagesFolder.'/'.$ImgSizeValues['folder'].'/'.$ImageFileName, $ImgSizeValues['quality']);
                
            $imageResizeObj -> reset();
            
        }
        }
    }
    
    
    public function UploadOneImage($Image)
    {
        if (!empty($Image['name']))
        {
        
            $UploadResult = $this->SaveUploadedFile($Image,Settings::$ImagesFolder);
        	
            if ($UploadResult) 
            {
                   
                $this->OneImageUploaded['img'] = $UploadResult;
   
            }
        }
    }
    
    private function UploadFiles(){
        
        //print '<br /><br /><br /><br />UPLOADOWNIA PLIKÓW';
        
    }
    
    
    public function SaveUploadedFile($File, $Path)
    {
        /*Example Of  $File
        (
        [name] => dakota1.png
        [type] => image/png
        [tmp_name] => /tmp/php1nQpGm
        [error] => 0
        [size] => 2404336
        )*/
        
        /*  Example Of  pathinfo()
        (
        [dirname] => .
        [basename] => dakota1.png
        [extension] => png
        [filename] => dakota1
        )
        */
        
        $FileInfo = pathinfo($File['name']);
        //$this->PrintArray($FileInfo);
        $FileExtension = $FileInfo['extension']; // get the extension of the file
        
        $NewFileName = $this->TransliterateStringToFile($FileInfo['filename']);
        
        $PathName = $Path.$NewFileName.'.'.$FileExtension;
        
        $counter = 1;
        
        while (@file_exists($PathName)) {
            
            $NewFileNameChenged = $NewFileName . '_' . $counter;
            $counter++;
            $PathName = $Path.$NewFileNameChenged.'.'.$FileExtension;
            
        }
        
        $UploadResult = move_uploaded_file( $File['tmp_name'], $PathName );
        
        if ($UploadResult){
            
            return (isset($NewFileNameChenged) ? $NewFileNameChenged.'.'.$FileExtension : $NewFileName.'.'.$FileExtension );
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    private function CheckFileSize($File, $Size){
        
        
    }
    
       
    private function GetUploadMaxSize(){
       
        $SYSTEM_UploadMaxSize =  chop(ini_get('upload_max_filesize'), 'M');
        $Kilobytes = 1024;
        
        $this->UploadMaxSize = $SYSTEM_UploadMaxSize * $Kilobytes;
        
    }
    
    private function UploadPlik($pole, $plik, $konfiguracja){
	
	}   
}