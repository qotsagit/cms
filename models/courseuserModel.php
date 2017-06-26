<?php

/**
 * courseuserModel
 * 
 * @category   Model
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

class courseuserModel extends Model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function GetId()
    {
        return $this->id_course;
    }

    public function Insert()
    {
        $params = array
        (
            ':id_user'      => $this->id_user,
            ':id_course'    => $this->id_course
        );

        $this->DB->NonQuery('INSERT INTO course_to_user SET id_user=:id_user, id_course=:id_course', $params);
    }

    
}
