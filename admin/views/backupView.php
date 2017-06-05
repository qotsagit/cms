<?php

class backupView extends View
{
    
    public function __construct()
    {    
        parent::__construct();
        $this->ViewTitle = $this->Msg('_BACKUP_', 'Backup');
        $this->CtrlName = CTRL_BACKUP;
    }
        
}
