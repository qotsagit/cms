<?php

class Install
{
    
    private function step1()
    {
        $file = "install.tar.gz";
        if(file_exists($file))
        {
                $phar = new PharData($file);
                //$phar->decompress(); 
                if($phar->extractTo('full/path'))
                    print 'ok';
                else
                    print 'error';
        
        }else{
        
            print 'file not exists:'.$file;
        } 
    }
          //  } catch (Exception $e)
           // {
           //     print $e
            //}
        
    
    private function step2()
    {
        print 'step 2';
    }
    
    public function Run($step)
    {
        
        if(method_exists($this, $step))
        {
            $this->$step();
        
        }else{
           
           print 'not exists error';   
        }
       
    }
   
};


    ini_set("display_errors","on");
    error_reporting(E_ALL);
   
    $name = 'step1';
    $name = $_GET['step'];
    $install = new Install();
    $install->Run($name);
      
    
    
    //$install->Run($step);
    
    //print system("./install");
?>
