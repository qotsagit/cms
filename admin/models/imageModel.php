<?php
/**
 * imageModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class imageModel extends Model
{

    public $id;
    public $id_image;
    public $id_lang;
    public $id_page = 0;    
    public $name;
    public $position = 1;


    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_image;
    }
    
    public function GetTitle()
    {
        return $this->name;
    }
    
   
    
    public function InsertImages($ImagesUploaded, $OneImageUploaded)
    {
        
        $LastIdPage = $this->LastInsertId();
        
        if (count($ImagesUploaded))
        {   
            
            foreach ($ImagesUploaded AS $Image)
            {
                $params = array(
                ':id_lang' => Session::GetLang(),
                ':id_page' => $LastIdPage,
                ':img' => $Image['img'],
                ':content_type' => NULL,
                ':name' => $Image['name'],
                ':size' => $Image['size'],
                ':width' => $Image['width'],
                ':height' => $Image['height'],
                ':position' => $Image['position']
                );

                $this->DB->NonQuery('INSERT INTO image SET id_page=:id_page,id_lang=:id_lang,img=:img,content_type=:content_type,name=:name,size=:size,width=:width,height=:height,position=:position', $params);
                
                $LastIdImage = $this->LastInsertId();
                
                $params = array(
                ':id_image' => $LastIdImage,
                ':id_page' => $LastIdPage,
                ':position' => $Image['position']
                );

                $this->DB->NonQuery('INSERT INTO image_to_page SET id_image=:id_image,id_page=:id_page,position=:position', $params);
                
            }
        }
        
        if (count($OneImageUploaded))
        {

            $params = array(
            ':id_page' => $LastIdPage,
            ':img' => $OneImageUploaded['img']
            );

            $this->DB->NonQuery('UPDATE page SET img=:img WHERE id_page=:id_page', $params);
                    
        }
    }
    
    public function UpdateImages($IdPage, $ImagesUploaded)
    {
        
        $NumberOfUpdatedImages = 0;
        
        if (isset($_POST['id_image_update']))
        {
            $IDImagesUpdated = $_POST['id_image_update'];
            $NumberOfUpdatedImages = count($IDImagesUpdated);
        }
        
        if($NumberOfUpdatedImages){
            
            $ImageNamesUpdated = $_POST['image_name_update'];
            $ImagePositionsUpdated = $_POST['image_position_update'];
            
            for ($i=0; $i < $NumberOfUpdatedImages; $i++){
                
                $params = array(
                ':id_image' => $IDImagesUpdated[$i],
                ':name' => $ImageNamesUpdated[$i],
                ':position' => $ImagePositionsUpdated[$i]
                );   
            
                $this->DB->NonQuery('UPDATE image SET name=:name,position=:position WHERE id_image=:id_image', $params);
                
                $params2 = array(
                ':id_image' => $IDImagesUpdated[$i],
                ':id_page' => $IdPage,
                ':position' => $ImagePositionsUpdated[$i]
                ); 
                
                $this->DB->NonQuery('UPDATE image_to_page SET position=:position WHERE id_image=:id_image AND id_page=:id_page', $params2);
                
                
            }
        }  
        
        if ($NumberOfUpdatedImages == 0)
        {
            
            $AllImagesToDelete = $this->GetImages($IdPage);
            
            //$this->PrintArray($AllImagesToDelete);
            
            $this->DeleteAllImages($AllImagesToDelete, $IdPage);
            
        }
        
        $NumberOfUploadedImages = count($ImagesUploaded);
        
        if ($NumberOfUploadedImages)
        {
        
            foreach ($ImagesUploaded AS $Image)
            {
                $params = array(
                ':id_lang' => Session::GetLang(),
                ':id_page' => $IdPage,
                ':img' => $Image['img'],
                ':content_type' => NULL,
                ':name' => $Image['name'],
                ':size' => $Image['size'],
                ':width' => $Image['width'],
                ':height' => $Image['height'],
                ':position' => $Image['position']
                );

                $this->DB->NonQuery('INSERT INTO image SET id_page=:id_page,id_lang=:id_lang,img=:img,content_type=:content_type,name=:name,size=:size,width=:width,height=:height,position=:position', $params);
                
                $LastIdImage = $this->LastInsertId();
                
                $params = array(
                ':id_image' => $LastIdImage,
                ':id_page' => $IdPage,
                ':position' => $Image['position']
                );

                $this->DB->NonQuery('INSERT INTO image_to_page SET id_image=:id_image,id_page=:id_page,position=:position', $params);
               
            }
        }
        
        if (isset($_POST['jfiler-items-exclude-image-0'])){
            
            $ImagesToDelete = array();
            
            $ImagesToDeleteNotFiltered = str_replace('["','', $_POST['jfiler-items-exclude-image-0']);
            
            $ImagesToDeleteNotFiltered = str_replace('"]','', $ImagesToDeleteNotFiltered);
            
            $ImagesToDeleteNotFiltered = explode('","', $ImagesToDeleteNotFiltered);
            
            foreach ($ImagesToDeleteNotFiltered AS $ImageToDeleteNotFIltered)
            {
                
                // input jfiler-items-exclude-image-0 zawiera taki ciąg "0://" przed nazwą zdjęcia jeżeli jest to zdjęcie już wgrane i 1:// jeżeli wgrywamy zdjęcie i plik nazywa się tak samo jak zdjęcie już wgrane
                
                if (strpos($ImageToDeleteNotFIltered,'0://') !== FALSE)
                { 
                
                    $ImagesToDelete[] = str_replace('0://','',$ImageToDeleteNotFIltered);
                
                }
            }
            
            $this->DeleteImages($ImagesToDelete, $IdPage);
            
            //$this->PrintArray($ImagesToDelete);
            
        }
    }
    
    public function UpdateOneImage($IdPage, $Image)
    {
        
        if (count($Image))
        {
            
            $ImageFromPage = $this->GetOneImage($IdPage);
            $this->DeleteOneImage($ImageFromPage);
            
            $params = array(
            ':img' =>$Image['img'],
            ':id_page' => $IdPage
            );   
            
            $this->DB->NonQuery('UPDATE page SET img=:img WHERE id_page=:id_page', $params);
            
        }
    }
    
    
    public function DeleteImages($ImagesToDelete,$IdPage)
    {
        if (count($ImagesToDelete))
        {
            foreach ($ImagesToDelete AS $ImageToDelete){
                    
                $params = array(
                ':img' => $ImageToDelete,
                ':id_page' => $IdPage
                );   
            
                $this->DB->NonQuery('DELETE FROM image WHERE img=:img AND id_page=:id_page', $params);
                    
                //@unlink(Settings::$ImagesFolder.$ImageToDelete);
                    
                foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues){
                    
                    //@unlink(Settings::$ImagesFolder.$ImgSizeValues['folder'].'/'.$ImageToDelete);
                        
                }       
            }    
        }
    }
    
    public function DeleteOneImage($ImageToDelete)
    {
        if (count($ImageToDelete))
        {
    
            //@unlink(Settings::$ImagesFolder.$ImageToDelete['img']);
                    
        }
    }
    
    
    public function DeleteAllImages($ImagesToDelete,$IdPage)
    {
        if (count($ImagesToDelete))
        {
            foreach ($ImagesToDelete AS $ImageToDelete){
                    
                $params = array(
                ':img' => $ImageToDelete['img'],
                ':id_page' => $IdPage
                );   
            
                $this->DB->NonQuery('DELETE FROM image WHERE img=:img AND id_page=:id_page', $params);
                    
                //@unlink(Settings::$ImagesFolder.$ImageToDelete);
                    
                foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues){
                    
                    //@unlink(Settings::$ImagesFolder.$ImgSizeValues['folder'].'/'.$ImageToDelete);
                        
                }       
            }    
        }
    }
    
    /*public function ARCHIWUM_GetImages($IdPage)
    {
        $params = array(':id_page' => $IdPage);
        $sql = "SELECT * FROM image_to_page WHERE id_page=:id_page ORDER BY position ASC";
        $ImagesInPage = $this->DB->Query($sql, $params, PDO::FETCH_ASSOC);
        
        $ImagesInPageImage = NULL;
        
        foreach ($ImagesInPage AS $Image){
            
            $params = array(':id_image' => $Image['id_image']);

            $sql = "SELECT * FROM image WHERE id_image=:id_image ORDER BY position ASC";
            $ImagesInPageImage[] = $this->DB->Row($sql,$params,PDO::FETCH_ASSOC);
            
        }
        
        if(is_array($ImagesInPageImage)) $ImagesInPageImage = array_reverse($ImagesInPageImage);
        
        return $ImagesInPageImage;
    }*/
    
   
    
    public function GetImages($IdPage, $fetch = PDO::FETCH_ASSOC)
    {
        $params = array(':id_page' => $IdPage);
        $sql = "SELECT * FROM image WHERE id_page=:id_page ORDER BY position ASC";
        $ImagesInPage = $this->DB->Query($sql, $params, $fetch);
        
        if(is_array($ImagesInPage)) $ImagesInPage = array_reverse($ImagesInPage);
        
        return $ImagesInPage;
    }
    
    public function GetOneImage($IdPage, $WithUrl = FALSE)
    {
        $params = array(':id_page' => $IdPage);
        $sql = "SELECT img FROM page WHERE id_page=:id_page";
        $OneImage = $this->DB->Row($sql, $params, PDO::FETCH_ASSOC);
        
        if(empty($OneImage['img']))
            $OneImage['img'] = DEFAULT_IMAGE;
        
        $image = IMAGE_DIR.'/'.$OneImage['img'];
        if(!file_exists($image))
        {
            $OneImage['img'] = DEFAULT_IMAGE;
        }
        
        if ($WithUrl===TRUE)
        {
            return IMAGES_URL.$OneImage['img'];
            
        } else {
        
            return $OneImage;
        }
    }
    
    //................................................................................................................................
    // moje [R] funkcje w modelu
    // tylko te narazie są używane
    //................................................................................................................................
    
    public function Insert()
    {
        $params = array
        (
            ':id_page' => $this->id_page,   //troche bezsens ale narazie tak jest
            ':img' => $this->img,
            ':name' => $this->name,
            ':position' => $this->position
        );

        $this->DB->NonQuery('INSERT INTO image SET id_page=:id_page, name=:name, img=:img, position=:position', $params);
    }
    
    public function Delete()
    {
        $items = $this->Get($this->id);
        
        foreach($items as $item)
        {
            // główny obrazek
            unlink(Settings::$ImagesFolder.'/'.$item->img);            
            
            //obrazki z folderów
            foreach(Settings::$ImageSizes AS $ImgSizeName => $ImgSizeValues)
            {
                unlink(Settings::$ImagesFolder.$ImgSizeValues['folder'].'/'.$item->img);            
            }
        }
        
        $params = array(':id' => $this->id);
        $this->DB->NonQuery('DELETE FROM image WHERE id_image=:id', $params);
        
        return;
    }
    
    // używamy przy kopiowaniu
    public function GetImagesForPage($id_page, $fetch = PDO::FETCH_ASSOC)
    {
        $params = array(':id_page' => $id_page);
        return $this->DB->Query("SELECT * FROM image WHERE id_page=:id_page", $params, $fetch);
    }
        
    public function Copy()
    {
       
        $images = $this->GetImagesForPage($this->id,PDO::FETCH_CLASS);
            
        foreach($images as $image)
        {
            $this->img = $image->img;
            $this->name = $image->name;
            $this->position = $image->position;
            $this->Insert();
        }
        
    }
    
    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM image WHERE id_image=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }

    public function CountAll()
    {
        return $this->Count();
    }

    public function Count()
    {
        return $this->DB->Count('SELECT count(*) FROM image', NULL);
    }

    public function All()
    {
        $sql = 'SELECT * FROM user';
        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Lists()
    {
        if ($this->Asc == SORT_ASC)
            $asc = 'ASC';
        else
            $asc = 'DESC';

        //$this->Limit = 0;    
        if ($this->Limit > 0)
            $sql = 'SELECT * FROM image ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM image ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
    }

}

