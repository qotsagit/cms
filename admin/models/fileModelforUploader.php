<?php
/**
 * fileModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class fileModelforUploader extends Model
{

    public $id;
    public $id_file;
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
        return $this->id_file;
    }
    
    public function GetTitle()
    {
        return $this->name;
    }
    
   
    
    public function InsertFiles($FilesUploaded)
    {
        
        $LastIdPage = $this->LastInsertId();
        
        if (count($FilesUploaded))
        {   
            
            foreach ($FilesUploaded AS $File)
            {
                $params = array(
                ':id_lang' => Session::GetLang(),
                ':id_page' => $LastIdPage,
                ':file' => $File['file'],
                ':content_type' => NULL,
                ':name' => $File['name'],
                ':size' => $File['size'],
                ':position' => $File['position']
                );

                $this->DB->NonQuery('INSERT INTO file SET id_page=:id_page,id_lang=:id_lang,file=:file,content_type=:content_type,name=:name,size=:size,position=:position', $params);
                
                $LastIdFile = $this->LastInsertId();
                
                $params = array(
                ':id_file' => $LastIdFile,
                ':id_page' => $LastIdPage,
                ':position' => $File['position']
                );

                $this->DB->NonQuery('INSERT INTO file_to_page SET id_file=:id_file,id_page=:id_page,position=:position', $params);
                
            }
        }
    }
    
    public function UpdateFiles($IdPage, $FilesUploaded)
    {
        
        $NumberOfUpdatedFiles = 0;
        
        if (isset($_POST['id_file_update']))
        {
            $IDFilesUpdated = $_POST['id_file_update'];
            $NumberOfUpdatedFiles = count($IDFilesUpdated);
        }
        
        if($NumberOfUpdatedFiles){
            
            $FileNamesUpdated = $_POST['file_name_update'];
            $FilePositionsUpdated = $_POST['file_position_update'];
            
            for ($i=0; $i < $NumberOfUpdatedFiles; $i++){
                
                $params = array(
                ':id_file' => $IDFilesUpdated[$i],
                ':name' => $FileNamesUpdated[$i],
                ':position' => $FilePositionsUpdated[$i]
                );   
            
                $this->DB->NonQuery('UPDATE file SET name=:name,position=:position WHERE id_file=:id_file', $params);
                
                $params2 = array(
                ':id_file' => $IDFilesUpdated[$i],
                ':id_page' => $IdPage,
                ':position' => $FilePositionsUpdated[$i]
                ); 
                
                $this->DB->NonQuery('UPDATE file_to_page SET position=:position WHERE id_file=:id_file AND id_page=:id_page', $params2);
                
                
            }
        }  
        
        if ($NumberOfUpdatedFiles == 0)
        {
            
            $AllFilesToDelete = $this->GetFiles($IdPage);
            
            //$this->PrintArray($AllFilesToDelete);
            
            $this->DeleteAllFiles($AllFilesToDelete, $IdPage);
            
        }
        
        $NumberOfUploadedFiles = count($FilesUploaded);
        
        if ($NumberOfUploadedFiles)
        {
        
            foreach ($FilesUploaded AS $File)
            {
                $params = array(
                ':id_lang' => Session::GetLang(),
                ':id_page' => $IdPage,
                ':file' => $File['file'],
                ':content_type' => NULL,
                ':name' => $File['name'],
                ':size' => $File['size'],
                ':position' => $File['position']
                );

                $this->DB->NonQuery('INSERT INTO file SET id_page=:id_page,id_lang=:id_lang,file=:file,content_type=:content_type,name=:name,size=:size,position=:position', $params);
                
                $LastIdFile = $this->LastInsertId();
                
                $params = array(
                ':id_file' => $LastIdFile,
                ':id_page' => $IdPage,
                ':position' => $File['position']
                );

                $this->DB->NonQuery('INSERT INTO file_to_page SET id_file=:id_file,id_page=:id_page,position=:position', $params);
               
            }
        }
        
        if (isset($_POST['jfiler-items-exclude-file-0'])){
            
            $FilesToDelete = array();
            
            $FilesToDeleteNotFiltered = str_replace('["','', $_POST['jfiler-items-exclude-file-0']);
            
            $FilesToDeleteNotFiltered = str_replace('"]','', $FilesToDeleteNotFiltered);
            
            $FilesToDeleteNotFiltered = explode('","', $FilesToDeleteNotFiltered);
            
            foreach ($FilesToDeleteNotFiltered AS $FileToDeleteNotFIltered)
            {
                
                // input jfiler-items-exclude-file-0 zawiera taki ciąg "0://" przed nazwą pliku jeżeli jest ten plik już wgrany i 1:// jeżeli wgrywamy zdjęcie i plik nazywa się tak samo jak zdjęcie już wgrane
                
                if (strpos($FileToDeleteNotFIltered,'0://') !== FALSE)
                { 
                
                    $FilesToDelete[] = str_replace('0://','',$FileToDeleteNotFIltered);
                
                }
            }
            
            $this->DeleteFiles($FilesToDelete, $IdPage);
            
            //$this->PrintArray($FilesToDelete);
            
        }
    }
    
    
    
    public function DeleteFiles($FilesToDelete,$IdPage)
    {
        if (count($FilesToDelete))
        {
            foreach ($FilesToDelete AS $FileToDelete){
                    
                $params = array(
                ':file' => $FileToDelete,
                ':id_page' => $IdPage
                );   
            
                $this->DB->NonQuery('DELETE FROM file WHERE file=:file AND id_page=:id_page', $params);
                
                //$this->DB->NonQuery('DELETE FROM file_to_page WHERE file=:file AND id_page=:id_page', $params);
                    
                @unlink(Settings::$FilesFolder.$FileToDelete);
 
            }    
        }
    }
    
    public function DeleteAllFiles($FilesToDelete,$IdPage)
    {
        if (count($FilesToDelete))
        {
            foreach ($FilesToDelete AS $FileToDelete){
                    
                $params = array(
                ':file' => $FileToDelete['file'],
                ':id_page' => $IdPage
                );   
            
                $this->DB->NonQuery('DELETE FROM file WHERE file=:file AND id_page=:id_page', $params);
                
                //$this->DB->NonQuery('DELETE FROM file_to_page WHERE file=:file AND id_page=:id_page', $params);
                    
                @unlink(Settings::$FilesFolder.$FileToDelete);
                    
            }    
        }
    }
    
    /*public function ARCHIWUM_GetFiles($IdPage)
    {
        $params = array(':id_page' => $IdPage);
        $sql = "SELECT * FROM file_to_page WHERE id_page=:id_page ORDER BY position ASC";
        $FilesInPage = $this->DB->Query($sql, $params, PDO::FETCH_ASSOC);
        
        $FilesInPageFile = NULL;
        
        foreach ($FilesInPage AS $File){
            
            $params = array(':id_file' => $File['id_file']);

            $sql = "SELECT * FROM file WHERE id_file=:id_file ORDER BY position ASC";
            $FilesInPageFile[] = $this->DB->Row($sql,$params,PDO::FETCH_ASSOC);
            
        }
        
        if(is_array($FilesInPageFile)) $FilesInPageFile = array_reverse($FilesInPageFile);
        
        return $FilesInPageFile;
    }*/
    
   
    
    public function GetFiles($IdPage, $fetch = PDO::FETCH_ASSOC)
    {
        $params = array(':id_page' => $IdPage);
        $sql = "SELECT * FROM file WHERE id_page=:id_page ORDER BY position ASC";
        $FilesInPage = $this->DB->Query($sql, $params, $fetch);
        
        if(is_array($FilesInPage)) $FilesInPage = array_reverse($FilesInPage);
        
        return $FilesInPage;
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
            ':file' => $this->file,
            ':name' => $this->name,
            ':position' => $this->position
        );

        $this->DB->NonQuery('INSERT INTO file SET id_page=:id_page, name=:name, file=:file, position=:position', $params);
    }
    
    public function Delete()
    {
        $items = $this->Get($this->id);
        
        foreach($items as $item)
        {
            // główny obrazek
            unlink(Settings::$FilesFolder.'/'.$item->file);            
            
            //obrazki z folderów
            foreach(Settings::$FileSizes AS $ImgSizeName => $ImgSizeValues)
            {
                unlink(Settings::$FilesFolder.$ImgSizeValues['folder'].'/'.$item->file);            
            }
        }
        
        $params = array(':id' => $this->id);
        $this->DB->NonQuery('DELETE FROM file WHERE id_file=:id', $params);
        
        return;
    }
    
    // używamy przy kopiowaniu
    public function GetFilesForPage($id_page, $fetch = PDO::FETCH_ASSOC)
    {
        $params = array(':id_page' => $id_page);
        return $this->DB->Query("SELECT * FROM file WHERE id_page=:id_page", $params, $fetch);
    }
        
    public function Copy()
    {
       
        $files = $this->GetFilesForPage($this->id,PDO::FETCH_CLASS);
            
        foreach($files as $file)
        {
            $this->file = $file->file;
            $this->name = $file->name;
            $this->position = $file->position;
            $this->Insert();
        }
        
    }
    
    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM file WHERE id_file=:id";
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS);
    }

    public function CountAll()
    {
        return $this->Count();
    }

    public function Count()
    {
        return $this->DB->Count('SELECT count(*) FROM file', NULL);
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
            $sql = 'SELECT * FROM file ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
        else
            $sql = 'SELECT * FROM file ORDER BY ' . $this->OrderFieldName . ' ' . $asc;

        return $this->DB->Query($sql, NULL, PDO::FETCH_CLASS, __CLASS__);
    }

}

