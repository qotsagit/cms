<?php

class contactView extends View
{
    
    public function __construct()
    {
        parent::__construct();
    }

    // nadpisany styl
    public function RenderValidationError($list)
    {
        foreach($list as $item)
        {
            print '<label class="error" for="subject">'.$item.'</label>';
        }

    }
    
}

