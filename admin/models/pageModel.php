<?php

/**
 * pageModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class pageModel extends Model
{
    public $id;
    public $id_page;
    public $id_user;
    public $id_category;
    public $id_lang;
    public $id_parent = 0;
    public $content_type;
    public $title;
    public $description;
    public $img;
    public $price;
    public $price_type;
    public $meta_title;
    public $meta_description;
    public $url;
    public $added_time;
    public $active;
    public $items = array();

    public function __construct()
    {
        parent::__construct();    
    }

    public function GetId()
    {
        return $this->id_page;
    }

    public function GetName()
    {
        return $this->title;
    }

    public function GetActive()
    {
        return $this->active;
    }

    public function Insert()
    {
        $params = array
        (
            ':id_user'          => $this->id_user,
            ':title'            => $this->title,
            ':id_lang'          => $this->id_lang,
            ':id_parent'        => $this->id_parent,
            ':id_category'      => $this->id_category,
            ':text'             => $this->FilterTextFromEditor($this->text),
            ':img'              => $this->img,
            ':url'              => $this->url,
            ':url_address'      => $this->url_address,
            ':template'         => $this->template,
            ':status_extra'     => $this->status_extra,
            ':active'           => $this->active,
            ':content_type'     => $this->content_type,
            ':price'            => $this->price,
            ':meta_title'       => $this->meta_title,
            ':meta_description' => $this->meta_description,
            ':position'         => $this->position
        );

        $this->DB->NonQuery('INSERT INTO page SET id_user=:id_user, id_parent=:id_parent, id_category=:id_category, id_lang=:id_lang, title=:title, img=:img, text=:text, content_type=:content_type, url=:url, url_address=:url_address, template=:template, status_extra=:status_extra, price=:price, meta_title=:meta_title, meta_description=:meta_description,position=:position, active=:active', $params);
    }

    public function Update()
    {
        $params = array
        (
            ':id_user'          => $this->id_user,
            ':id_page'          => $this->id_page,
            ':id_parent'        => $this->id_parent,
            ':id_category'      => $this->id_category,
            ':title'            => $this->title,
            ':id_lang'          => $this->id_lang,
            ':text'             => $this->FilterTextFromEditor($this->text),
            ':url'              => $this->url,
            ':url_address'      => $this->url_address,
            ':template'         => $this->template,
            ':status_extra'     => $this->status_extra,
            ':active'           => $this->active,
            ':content_type'     => $this->content_type,
            ':price'            => $this->price,
            ':meta_title'       => $this->meta_title,
            ':meta_description' => $this->meta_description,
            ':position'         => $this->position
        );
        
        $this->DB->NonQuery('UPDATE page SET id_user=:id_user, id_parent=:id_parent, id_category=:id_category, title=:title, id_lang=:id_lang, text=:text, content_type=:content_type, url=:url, url_address=:url_address, template=:template, status_extra=:status_extra, price=:price, meta_title=:meta_title, meta_description=:meta_description, position=:position, active=:active WHERE id_page=:id_page', $params);
        return;
    }
     
    public function Copy()
    {
        
        $item = $this->Get($this->id);
        $page = $this->Get($this->id_parent);
        
        if($page)
            $this->content_type = $page->content_type;
        else
            $this->content_type = $item->content_type;
        
        $this->id_user          = $item->id_user;
        $this->id_page          = $item->id_page;
        //$this->id_parent        = $item->id_parent;
        $this->id_category      = $item->id_category;
        $this->title            = $item->title.' - '.$this->Msg('_COPY_','Copy');
        $this->text             = $item->text;
        $this->url              = $item->url;
        $this->url_address      = $item->url_address;
        $this->template         = $item->template;
        $this->status_extra     = $item->status_extra;
        $this->active           = $item->active;
        $this->price            = $item->price;
        $this->img              = $item->img;
        $this->meta_title       = $item->meta_title;
        $this->meta_description = $item->meta_description;
        $this->position         = $item->position;
       
        $this->Insert();
    }

    public function Delete()
    {
        
        $ImageModel = new imageModel();
        
        $OneImage =  $ImageModel->GetOneImage($this->id);
        
        $ImageModel->DeleteOneImage($OneImage);
        
        $AllImagesToDelete = $ImageModel->GetImages($this->id);
        $ImageModel->DeleteAllImages($AllImagesToDelete, $this->id);
        
        $params = array(':id' => $this->id);
        $this->DB->NonQuery('DELETE FROM page WHERE id_page=:id', $params);
        
        return;
    }

    public function Get($id)
    {
        $params = array(':id' => $id);
        $sql = "SELECT * FROM page WHERE id_page=:id";
        return $this->DB->Row($sql, $params,PDO::FETCH_CLASS,__CLASS__);
    }
    
    public function GetParentId($id)
	{
		$params = array(':id' => $id);
		$sql = "SELECT id_page as id, id_parent FROM page WHERE id_page=:id";
		return $this->DB->Row($sql, $params);
	}
    
    public function All()
    {
        $params = array(':id_lang' => Session::GetLang());
        $sql = 'SELECT * FROM page WHERE id_lang=:id_lang ORDER BY title';
        return $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);
    }

    public function Count()
    {
        //if($this->id_lang == 0)
        //{
          //  $params = array(':id_parent' => $this->id_parent);
           // return $this->DB->Count('SELECT count(*) FROM page WHERE id_parent=:id_parent', $params);
        
        //}else{
            
        $params = array(':id_lang' => Session::GetLang(),':id_parent' => $this->id_parent,':content_type' => $this->content_type);
        return $this->DB->Count('SELECT count(*) FROM page WHERE id_lang=:id_lang AND id_parent=:id_parent AND content_type=:content_type', $params);
            
        //}
    }

    public function CountAll()
    {
        //if($this->id_lang == 0)
        //{
          //  return $this->DB->Count('SELECT count(*) FROM page' , NULL);
        //}else{
        $params = array(':id_lang' => Session::GetLang(),':content_type' => $this->content_type);
        return $this->DB->Count('SELECT count(*) FROM page WHERE id_lang=:id_lang AND content_type=:content_type', $params);
        //}
        
    }
    
    public function RowCount()
    {
        return $this->DB->RowCount();
    }

    public function AddParent($name,&$items)
    {
        $item = new pageModel();
        $item->id_page = 0;
        $item->title = $name;
        array_unshift($items,$item);
    }
    
    // używa formularz w <select>
    // przez referencję wypełniamy zmienną
    public function Tree($id,$id_page,$id_lang,&$items)
    {
        // nie wyświetlamy item aktualnie wybranego do edycji
        $params = array(':id_parent' => $id,':id_lang' => $id_lang,':id_page' => $id_page);
        $sql = 'SELECT * FROM page WHERE id_parent=:id_parent AND id_lang=:id_lang AND id_page<>:id_page ORDER BY title';
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
        
        foreach($items as $item)
        {
            $this->Tree($item->id_page,$id_page,$id_lang,$item->items);
        }
    
    }
    
    public function Breadcrumb($id, $level = 0)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM page WHERE id_page=:id';
                   
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);       
        
        foreach($items as $item)
        {
            array_unshift($this->breadcrumb,$item);
        }
        
        foreach($items as $item)
        {
            $this->Breadcrumb($item->id_parent, $item,$level);
        }
		
    }

    public function Url($id, &$url)
    {
        $params = array(':id' => $id);
        $sql = 'SELECT * FROM page WHERE id_page=:id';
                   
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS,__CLASS__);
             
        foreach($items as $item)
        {
            if($url == NULL)
                $url.= $item->GetName();
            else
                $url = $item->GetName().' '.$url;
        }
        
        foreach($items as $item)
        {
            $this->Url($item->id_parent, $url);
        }
		
    }

    public function Lists()
    {
        
        $this->id_lang = Session::GetLang();
		if ($this->Asc == SORT_ASC)
		    $asc = 'ASC';
		else
		    $asc = 'DESC';
		
        //język nie wybrany
        if($this->id_lang == 0)
        {
            $params = array(':id_parent' => $this->id_parent,':content_type' => $this->content_type);
            if ($this->Limit > 0)
                $sql = 'SELECT * FROM page WHERE id_parent=:id_parent AND content_type=:content_type ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
            else
                $sql = 'SELECT * FROM page WHERE id_parent=:id_parent AND content_type=:content_type ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
        
        }else{
            
            $params = array(':id_lang' => $this->id_lang,':id_parent' => $this->id_parent,':content_type' => $this->content_type, ':search' => '%'.Session::GetSearch().'%');
            if ($this->Limit > 0)
                $sql = 'SELECT * FROM page WHERE id_lang=:id_lang AND id_parent=:id_parent AND content_type=:content_type AND (title LIKE :search OR text LIKE :search) ORDER BY ' . $this->OrderFieldName . ' ' . $asc . ' LIMIT ' . $this->LimitFrom . ',' . $this->Limit . '';
            else
                $sql = 'SELECT * FROM page WHERE id_lang=:id_lang AND id_parent=:id_parent AND content_type=:content_type AND (title LIKE :search OR text LIKE :search) ORDER BY ' . $this->OrderFieldName . ' ' . $asc;
        }
                
        $items = $this->DB->Query($sql, $params, PDO::FETCH_CLASS, __CLASS__);
        
        return $items;
    }

}
