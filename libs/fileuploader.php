<?php


class FileUploader extends Base
{

    public $IsValid = true;         // flaga czy pole zawiera poprawne dane
    
    private $NoError = TRUE;
    
    private $Images = array();         //[name] => [n], [type] => [n], [tmp_name] => [n], [error] => [n], [size]=> [n] (n - n plikow)
    private $ImageNames = NULL;
    private $ImagePositions = NULL;
    
    public $ImagesUploaded = NULL;
    
    public $OneImageUploaded = NULL;
    
    private $Files = array();
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
        
        if(isset($_FILES['image']))
            $this->Images = $_FILES['image'];
        
        if(isset($_FILES['file']))
            $this->Files = $_FILES['file'];
        
        if (isset($_POST['image_name']) AND isset($_POST['image_position'])){
            
            $this->ImageNames = array_reverse($_POST['image_name']);
            $this->ImagePositions = array_reverse($_POST['image_position']);
           
        }
                
        if (isset($_POST['file_name']) AND isset($_POST['file_position'])){
            
            $this->FileNames = array_reverse($_POST['file_name']);
            $this->FilePositions = array_reverse($_POST['file_position']);
            
        }
        
        if ($this->UploadImagesFilter())
        {
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
                    
                    $ImageInfo = getimagesize(Settings::$ImagesFolder.$ImageFileName);
                    
                    $ImageSize = filesize(Settings::$ImagesFolder.$ImageFileName);
                    
                    $ImageWidth = $ImageInfo[0];
                    $ImageHeight = $ImageInfo[1];
                    
                    $this->ImagesUploaded[$counter]['img'] = $ImageFileName;
                        
                    $this->ImagesUploaded[$counter]['name'] = ($this->ImageNames[$counter] == '' ? NULL : $this->ImageNames[$counter]);
                    
                    $this->ImagesUploaded[$counter]['position'] = ($this->ImagePositions[$counter] == (NULL OR '') ? 1000 : $this->ImageNames[$counter]);
                    
                    $this->ImagesUploaded[$counter]['width'] = $ImageWidth;
                        
                    $this->ImagesUploaded[$counter]['height'] = $ImageHeight;
                    
                    $this->ImagesUploaded[$counter]['size'] = $ImageSize;
                
                
                    /*
                    print 'OK';
                    /*
                     * jak jest duży plik ponad 3 MB to w konstruktorze tej biblioteki skrypt jest przerywany funkcją die() bez żadnego komunikatu
                     * nie używac tej biblioteki
                     * 
                     
                    //$imageResizeObj = new imageLib(Settings::$ImagesFolder.$ImageFileName);
                    
                    print 'AFTER';
                                                                                
                    foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues)
                    {
                    
                        $imageResizeObj -> resizeImage($ImgSizeValues['width'], $ImgSizeValues['height'], 'crop', true);
                        $imageResizeObj -> saveImage(Settings::$ImagesFolder.'/'.$ImgSizeValues['folder'].'/'.$ImageFileName, $ImgSizeValues['quality']);
                    
                        $imageResizeObj -> reset();
                    
                    }
                
                    */
                
                    $Image = new Image();
                    foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues)
                    {
                        //$Image->resizeImage($ImgSizeValues['width'], $ImgSizeValues['height'], 'crop', true);
                        $src = Settings::$ImagesFolder.'/'.$ImageFileName;
                        $dst = Settings::$ImagesFolder.'/'.$ImgSizeValues['folder'].'/'.$ImageFileName;
                        @mkdir(Settings::$ImagesFolder.'/'.$ImgSizeValues['folder']);
                        $Image->ResizeAndCrop($src,$dst,$ImgSizeValues['width'], $ImgSizeValues['height']);
                        //$Image->saveImage(Settings::$ImagesFolder.'/'.$ImgSizeValues['folder'].'/'.$ImageFileName, $ImgSizeValues['quality']);
                    
                        //$imageResizeObj -> reset();
            
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
                    
            $imageResizeObj -> resizeImage($ImgSizeValues['width'], $ImgSizeValues['height'], 'crop', true);
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
        
        $FilesToUpload = NULL;
        
        $counter = 0;
        foreach ($this->Files['name'] AS $counter => $value)
        { 
            
            //print $this->TransliterateStringToFile($this->Files['name'][$counter]).'=>'.$this->FileNames[$counter];
            //[name] => [n], [type] => [n], [tmp_name] => [n], [error] => [n], [size]=> [n] (n - n plikow)
            
            $FilesToUpload[$counter]['name'] = $this->Files['name'][$counter];
            $FilesToUpload[$counter]['type'] = $this->Files['type'][$counter];
            $FilesToUpload[$counter]['tmp_name'] = $this->Files['tmp_name'][$counter];
            $FilesToUpload[$counter]['error'] = $this->Files['error'][$counter];
            $FilesToUpload[$counter]['size'] = $this->Files['size'][$counter];
            
            /*$aExtraInfo = getimagesize($this->Files['tmp_name'][$counter]);
            $sFile = "data:" . $aExtraInfo["mime"] . ";base64," . base64_encode(file_get_contents($this->Files['tmp_name'][$counter]));
            echo '<p>The image has been uploaded successfully</p><p>Preview:</p><img src="' . $sFile . '" alt="Your File" />';*/
            
        }
        
        $counter = 0;
        //echo getcwd();
        if (is_array($FilesToUpload))
        {
            
            $this->FilesUploaded = array();           
            
            foreach ($FilesToUpload AS $UploadFile)
            {                      

                $UploadResult = $this->SaveUploadedFile($UploadFile,Settings::$FilesFolder);

                if ($UploadResult)
                {
                
                    $FileFileName = $UploadResult;
                    
                    $FileSize = filesize(Settings::$FilesFolder.$FileFileName);
                    
                    $this->FilesUploaded[$counter]['file'] = $FileFileName;
                        
                    $this->FilesUploaded[$counter]['name'] = ($this->FileNames[$counter] == (NULL OR '') ? NULL : $this->FileNames[$counter]);
                    
                    $this->FilesUploaded[$counter]['position'] = ($this->FilePositions[$counter] == (NULL OR '') ? 1000 : $this->FilePositions[$counter]);
                    
                    $this->FilesUploaded[$counter]['size'] = $FileSize;
	
                }
                
                ++$counter;
                
            } 
        }    
        
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
        
        while (file_exists($PathName)) {
            
            $NewFileNameChenged = $NewFileName . '_' . $counter;
            $counter++;
            $PathName = $Path.$NewFileNameChenged.'.'.$FileExtension;
            
        }
        
        $UploadResult = move_uploaded_file( $File['tmp_name'], $PathName );
        
        if ($UploadResult){
            
            return (isset($NewFileNameChenged) ? $NewFileNameChenged.'.'.$FileExtension : $NewFileName.'.'.$FileExtension );
            
        } else {
            
            return false;
            
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