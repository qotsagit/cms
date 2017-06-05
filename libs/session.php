<?php

/**
 * Session
 * 
 * @category   Libs
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class Session
{

    //GET
    public static function GetId()
    {
        if (isset($_SESSION['id']))
            return $_SESSION['id'];
        else
            return DEFAULT_ID;
    }

    public static function GetIdParent()
    {
        if (isset($_SESSION['id_parent']))
            return $_SESSION['id_parent'];
        else
            return DEFAULT_ID;
    }

    public static function GetCtrl()
    {
        if(isset($_SESSION['ctrl']))
            return $_SESSION['ctrl'];
        else
            return DEFAULT_CTRL;
    }

    public static function GetLang()
    {
        if(isset($_SESSION['lang']))
            return $_SESSION['lang'];
        else{
         
         //print 'no lang';
          //e/xit;
            return DEFAULT_LANG_ID;

        }
    }

    public static function GetAsc()
    {
        if(isset($_SESSION['asc']))
            return $_SESSION['asc'];
        else
            return DEFAULT_ASC;
    }

    public static function GetPage()
    {
        if(isset($_SESSION['page']))
            return $_SESSION['page'];
        else
            return DEFAULT_PAGE;
    }

    public static function GetPageTo()
    {
        if(isset($_SESSION['page_to']))
            return $_SESSION['page_to'];
        else
            return DEFAULT_PAGE;
    }

    public static function GetLimit()
    {
        if(isset($_SESSION['limit']))
            return $_SESSION['limit'];
        else
            return DEFAULT_LIMIT;
    }

    public static function GetOrderColumnId()
    {
        if(isset($_SESSION['order_column_id']))
            return $_SESSION['order_column_id'];
        else
            return DEFAULT_ORDER_COLUMN_ID;
    }
    
    public static function GetValidUser()
    {
        if(isset($_SESSION['valid_user']))
            return $_SESSION['valid_user'];
        else
            return false;
        
    }
    
    public static function GetUser()
    {
        if(isset($_SESSION['user']))
            return $_SESSION['user'];
        else
            return false;
    }
    
    public static function GetSearch()
    {
        if(isset($_SESSION['search']))
            return $_SESSION['search'];
        else
            return false;
    }
    
    public static function GetCurrentPage()
    {
        if(isset($_SESSION['current_page']))
            return $_SESSION['current_page'];
        else
            return false;
    }

    //SET
    public static function SetDefault()
    {
        $_SESSION['order_column_id'] = DEFAULT_ORDER_COLUMN_ID;
        $_SESSION['page'] = DEFAULT_PAGE;
        $_SESSION['asc'] = DEFAULT_ASC;
        $_SESSION['id'] = DEFAULT_ID;
        $_SESSION['id_parent'] = DEFAULT_ID;
    }
    
    public static function SetId($value)
    {
        $_SESSION['id'] = $value;
    }

    public static function SetIdParent($value)
    {
        $_SESSION['id_parent'] = $value;
    }

    public static function SetCtrl($value)
    {
        $_SESSION['ctrl'] = $value;
    }

    public static function SetLang($value)
    {
        $_SESSION['lang'] = $value;
    }

    public static function SetAsc($value)
    {
        $_SESSION['asc'] = $value;
    }

    public static function SetPage($value)
    {
        $_SESSION['page'] = $value;
    }

    public static function SetPageTo($value)
    {
        $_SESSION['page_to'] = $value;
    }
    
    public static function SetLimit($value)
    {
        $_SESSION['limit'] = $value;
    }

    public static function SetOrderColumnId($value)
    {
        $_SESSION['order_column_id'] = $value;
    }

    public static function SetValidUser($value)
    {
        $_SESSION['valid_user'] = $value;
    }
    
    public static function SetUser($value)
    {
        $_SESSION['user'] = $value;
    }
            
    public static function SetSearch($value)
    {
        $_SESSION['search'] = $value;
    }
    
    public static function SetCurrentPage($value)
    {
        $_SESSION['current_page'] = $value;
    }
}
