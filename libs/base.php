<?php

/**
 * Lang
 * 
 * @category   Libs
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class Lang
{
    public $id;     //każda klasa modelu ma to pole współne przy kasowaniu itp.
    public $id_lang;
    public $name;
    public $code;   

    public function GetId()
    {
        return $this->id_lang;
    }
    public function GetName()
    {
        return $this->name;
    }
}

/**
 * Base
 * 
 * @category   Libs
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */


class Base
{

    public $User;
    public $DB;

    public function __construct()
    {
        $this->DB = Database::getInstance();        
    }

    public function AsString()
    {
        return get_class($this);
    }

    public function Href($href,$text)
    {
        print '<a href="$controller">$text</a>';
    }
    
    //public function  
    // dla jezyków 
    public function GetLangs()
    {
        $params = array(':active' => STATUS_ACTIVE);
        return $this->DB->Query('SELECT * FROM lang WHERE active=:active', $params, PDO::FETCH_CLASS,'Lang');        
    }
    
    // znajdź jezyk po id lub code
    public function GetLang($value)
    {
        $params = array(':id_lang' => $value,'code' =>$value);
        return $this->DB->Row('SELECT * FROM lang WHERE id_lang=:id_lang OR code=:code', $params, PDO::FETCH_CLASS,'Lang');
    }
    
    public function InitStrings($force = false)
    {
        
        if($force)
        {
            $this->Strings = $this->AllValues();
            $this->DefaultStrings = $this->AllDefaultValues();
            //print_r($this->Strings);
            //print 'FORCE';
            return;
        }
        
        if (empty($this->Strings))
        {
            $this->Strings = $this->AllValues();
            //print_r($this->Strings);
        }
                   
        if (empty($this->DefaultStrings))
        {
           $this->DefaultStrings = $this->AllDefaultValues();
        }

    }
    
    public function Msg($const, $default)
    {
        $this->InitStrings();
        //print $this->AsString();
        
        //exit;

        if (array_key_exists($const, $this->Strings))
        {
            $value = $this->Strings[$const];
            if ($default == $this->DefaultStrings[$const])
            {
                return $value;
            }
            else
            { 
                $this->UpdateMsg($const,$default);
                $this->InitStrings(true);
                return $this->DefaultStrings[$const];
            }
        }
        else
        {
            $this->InsertMsg($const, $default);
            $this->InitStrings(true);
            return $default;
        }
    }

    private function InsertMsg($const, $value)
    {
        $params = array(
            ':const' => $const,
            ':user_value' => $value,
            ':default_value' => $value,
            ':id_lang' => Session::GetLang()
        );
        
        $this->DB->NonQuery('INSERT INTO msg SET const=:const,user_value=:user_value,id_lang=:id_lang,default_value=:default_value', $params);
    }
   
    private function UpdateMsg($const, $value)
    {
        $params = array(
            ':const' => $const,            
            ':default_value' => $value
        );

        $this->DB->NonQuery('UPDATE msg SET default_value=:default_value WHERE const=:const', $params);
    }     

    private function AllValues()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT const,user_value FROM msg WHERE id_lang=:id_lang', $params, PDO::FETCH_KEY_PAIR);
    }

    private function AllDefaultValues()
    {
        $params = array(':id_lang' => Session::GetLang());
        return $this->DB->Query('SELECT const,default_value FROM msg WHERE id_lang=:id_lang', $params, PDO::FETCH_KEY_PAIR);
    }
    
    public function GetUniqueVisit()
    {
        return $this->DB->Count('SELECT count(distinct remote_addr) FROM visit',NULL);
    }
    
    public function GetDiskTotalSpace($directory)
    {
        return disk_total_space($directory)/1024/1024/1024;
    }
    
    public function GetDiskFreeSpace($directory = '/home/qotsa2')
    {
        return disk_free_space($directory);
    }
    

    public static function RandomString($len)
    {
        $string_table = "qazwsxedcrfvtgbyhnujmikolpQAZWSXEDCRFVTGBHNUJMIKOLP1234567890";
        $buffer = "";
        for ($i = 0; $i < $len; $i++)
            $buffer = $buffer . $string_table[rand(0, strlen($string_table) - 1)];

        return $buffer;
    }
    
    public function PureText($text, $maxlength = FALSE, $breakCode = FALSE,$striptags = TRUE)
    {
            
        if($striptags)
            $text = strip_tags(trim($text));
        
        $IsBreak = strstr($text, $breakCode);
    
        if ($breakCode AND $IsBreak)
        {
            $textArray = explode($breakCode, $text);    
            $text = $textArray[0];
        } 
        
        if ($IsBreak == FALSE AND $maxlength)
        {     
            $text = mb_strimwidth($text, 0, $maxlength, '...');   
        }
        
        
        
        return $text;
        
    }
    
    public function DateFormat($time, $dateFormat=FALSE){
    
        $data = $time;
        
        if ($dateFormat){
        
            $mktime = strtotime($time);
            
            $data = date($dateFormat, $mktime);
        }
    
        return $data;
        
    }
    
    public function FilterTextFromEditor($text){
        
        /*
        CKEDYTOR znaki :
        
        data-plugin-options='{"items": 1, "autoHeight": true, "navigation": true, "pagination": true, "transitionStyle":"fade", "progressBar":"true"}'

        zmienia na:

        data-plugin-options="{&quot;items&quot;: 1, &quot;autoHeight&quot;: true, &quot;navigation&quot;: true, &quot;pagination&quot;: true, &quot;transitionStyle&quot;:&quot;fade&quot;, &quot;progressBar&quot;:&quot;true&quot;}" 
        
        WIĘC POPRAWIAMY...
        */
        
        $text = str_replace('"{&quot;','\'{"',$text);
        $text = str_replace('&quot;:','":',$text);
        $text = str_replace(', &quot;',', "',$text);
        $text = str_replace('&quot;}"','"}\'',$text);
        
        //zdjęcia responsywne
        $text = str_replace('class="dopasuj"','class="img-responsive"',$text);
        
        //$text = str_replace('<img class="img-responsive"','<span class="image-hover-icon image-hover-dark"><i class="fa fa-search-plus"></i></span><img class="img-responsive"',$text);
        
        //lightbox
        $text = str_replace('class="powieksz"','class="image-hover lightbox" data-plugin-options=\'{"type":"image"}\'',$text);
        
        return $text;
        
    }
    
    

    public function IsValidEmail($email)
    {
        $wholeexp = '/^(.+?)@(([a-z0-9\.-]+?)\.[a-z]{2,5})$/i';
        $userexp = "/^[a-z0-9\~\\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";

        if (preg_match($wholeexp, $email, $regs))
        {
            $username = $regs[1];
            $host = $regs[2];

            if (checkdnsrr($host, "MX"))
            {
                if (preg_match($userexp, $username))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    public function TransliterateStringToFile($string)
    {
        
        $TransliterateString = strtolower(preg_replace('/[^a-z0-9\-\_\.]/i', '', iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", transliterator_transliterate('Any-Latin; Latin-ASCII', $string))));

        return $TransliterateString;
    }
    
    
    public function TransliterateStringToUrl($string)
    {
        
        $TransliterateStringWithSpaces = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", transliterator_transliterate('Any-Latin; Latin-ASCII', $string));
        
        $TransliterateStringWithOutSpaces = str_replace(' ','-',$TransliterateStringWithSpaces);
        
        $TransliterateString = strtolower(preg_replace('/[^a-z0-9\-]/i', '', $TransliterateStringWithOutSpaces));

        return $TransliterateString;
    }

    public function PrintImageUrl($img, $folder = NULL)
    {
        
        if(!is_null($folder))
        {
            $folder = $folder.'/';   
        }
        
        print IMAGES_URL.$folder.$img;
    }
    
    public function ImageUrl($img, $folder = NULL)
    {
        
        if(!is_null($folder))
        {
            $folder = $folder.'/';   
        }
        
        return IMAGES_URL.$folder.$img;
    }
    
    
    public function FileUrl($file, $folder = NULL)
    {
        
        if(!is_null($folder))
        {
            $folder = $folder.'/';   
        }
        
        return FILES_URL.$folder.$file;
    }
    
    public function PrintArray($array)
    {
        print '<pre>';
        print_r($array);
        print '</pre>';
    }

    public function IsTemplateExists($template)
    {
        $ext = pathinfo($template, PATHINFO_EXTENSION);
        
        if($ext)
        {
            $filename = TEMPLATE_FOLDER.'/'.$template;    
        }else{
            $filename = TEMPLATE_FOLDER.'/'.$template.'.html';    
        }
        
        if (file_exists($filename))
            return true;
        else
            return false;
    }
    
    public function DirectoryExists($path)
    {
        if (!file_exists($path))
        {
            return false;
        }else{
     
        return true;
        }
    } 
 
    public function DirectoryCreate($path)
    {
        if (mkdir($path))
            return true;
        else
            return false;
    }
    
    // przydatne do newsletera wymienia znaczniki img w tekscie na img z pełnym url
    function replace_img_src($img_tag)
    {
        $doc = new DOMDocument();
        $doc->loadHTML($img_tag);
        $tags = $doc->getElementsByTagName('img');
        
        foreach ($tags as $tag)
        {
            $old_src = $tag->getAttribute('src');
            $new = str_replace(SITE_URL,'',$old_src);
            $new_src_url = SITE_URL.$new;
            $tag->setAttribute('src', $new_src_url);
        }
        
        return $doc->saveHTML();
    }
    
}
