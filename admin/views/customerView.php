<?php

class customerView extends View
{
    
    public function __construct()
    {   
        parent::__construct();
        $this->ViewTitle = $this->Msg('_CUSTOMERS_','Customers');
        $this->CtrlName = CTRL_CUSTOMER;
          
    }

    public function SetColumns()
    {
        $this->Columns = array
            (
            new ColumnText($this->Msg('_EMPTY_STRING_',''),'id_customer',false),
            new ColumnText($this->Msg('_NAME_','Name'), 'name'),
            new ColumnText($this->Msg('_PHONE_','Phone'), 'phone'),
            new ColumnText($this->Msg('_WEBSITE_','Website'), 'website'),
            new ColumnText($this->Msg('_EMAIL_','Email'), 'email'),
            new ColumnText($this->Msg('_ADDRESS_','Address'), 'address'),
            new ColumnText($this->Msg('_CITY_','City'), 'city')
        );
    }
    
}
