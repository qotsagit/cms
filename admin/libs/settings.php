<?php

class Settings
{   
    public static $Limits = array(2,5, 30, 60, 90);
    public static $Style = 'default';
    public static $CKEditorUse = false;  
    public static $JqueryFileUploader = false;
    
    public static $FilesFolder = '../filemanager/files/files/';
    public static $ImagesFolder = '../filemanager/files/images/';
    public static $ImagesUploadOriginal = TRUE;
   
    //public static $Templates = 
    
    public static $ImageSizes = array
    (
        
        'mini' => array
        (
            'folder'=>'mini',
            'width'=>280, 
            'height'=>180, 
            'crop_w'=>NULL, 
            'crop_h'=>180, 
            'quality'=>93
            #'type'=>'scale' //scale|crop|scale&crop
        ),
        
        'midi' => array
        (
            'folder'=>'midi',
            'width'=>320, 
            'height'=>240, 
            'crop_w'=>NULL, 
            'crop_h'=>380, 
            'quality'=>96 
        ),
        
        'content' => array
        (
            'folder'=>'content',
            'width'=>745, 
            'height'=>560,
            'crop_w'=>NULL, 
            'crop_h'=>360, 
            'quality'=>93
        ),
        
        'full' => array
        (
            'folder'=>'full',
            'width'=>1140, 
            'height'=>820, 
            'crop_w'=>NULL, 
            'crop_h'=>475, 
            'quality'=>93
        )    
    );
}