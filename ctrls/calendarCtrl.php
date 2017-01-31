<?php
/**
 * calendarCtrl
 * 
 * @category   Controller
 * @package    CMS
 * @author     Rafał Żygadło <rafal@maxkod.pl>
 
 * @copyright  2016 maxkod.pl
 * @version    1.0
 */

include 'models/calendarModel.php';
include 'views/calendarView.php';

class calendarCtrl extends Ctrl
{

    public function __construct()
    {
        parent::__construct(false);

        $this->View = new calendarView();
        $this->View->ViewTitle = $this->Msg('_CALENDAR_', 'Calendar');
        $this->View->CtrlName = CTRL_CALENDAR;
        $this->View->SetColumns();

        $this->Model = new calendarModel();

    }
    
    public function JSON()
    {
        /*
        $i = 123456789;
        while($i--)
        {
            $this->Model->name = $i;
            $this->Model->text = $i;
            $this->Model->start_date = date("Y-m-d",mktime(0,0,$i,date("m"),date("d"),date("Y")));
            $this->Model->end_date = date("Y-m-d",mktime(0,0,$i+36000,date("m"),date("d"),date("Y")));
            $this->Model->Insert();
        }
        print '[{"id":"1","title":"New Event","start":"2016-12-14T00:01:00+05:30","end":"2016-12-18T00:01:00+05:30","allDay":false}]';
        */
        header("Access-Control-Allow-Origin: *");
        print json_encode($this->Model->JSON());
        
        //print '[{ "title":"All Day Event", "start":"2016-12-01" },{ "title":"Long Event", "start":"2016-12-07", "end":"2016-12-10" }]';
        
        exit;        
    }
    
      
    public function Listing()
    {
         $this->View->Render('calendar/index');    
    }

   
    
}
