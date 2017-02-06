<?php
/**
 * newsletterModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class newsletterModel extends Model
{

    public $email;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_user;
    }

	public function Activate($value)
	{
		$params = array
		(
			':id_newsletter'=> $this->id_newsletter,	
			':active'		=> $value
		);
			
		print_r($params);		
		$this->DB->NonQuery('UPDATE newsletter SET active=:active WHERE id_newsletter=:id_newsletter', $params);
	}
	
	
    public function Insert()
    {
        $params = array(':email' => $this->email, ':newsletter' => true);

        $row = $this->Exists($this->email);
        
        if($this->Exists($this->email))
        {
            $params = array(':email' => $this->email, ':newsletter' => true, ':id_user' => $row->id_user);
            $this->DB->NonQuery('UPDATE user SET email=:email, newsletter=:newsletter WHERE id_user=:id_user', $params);
        }
        else
        {
            $this->DB->NonQuery('INSERT INTO user SET email=:email, newsletter=:newsletter', $params);
        }
    }

    public function Exists($email)
    {
        $params = array(':email' => $email);
        return $this->DB->Row('SELECT * FROM user WHERE email=:email',$params);
    }

    public function Delete()
    {
        //$params = array(':id_user' => $this->id);
        //$this->DB->NonQuery('DELETE  FROM user WHERE id_user=:id_user', $params);
        return;
    }

	// all active newsletters
    public function All()
    {
		$params = array(':active' => STATUS_ACTIVE);
        return $this->DB->Query("SELECT * FROM newsletter WHERE active=:active AND start_date < now()", $params, PDO::FETCH_CLASS,__CLASS__);
    }

}
