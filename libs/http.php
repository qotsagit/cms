<?php

class Http
{

    private $curl = NULL;    

	public function __construct()
    {
    
    }
	
    public function Init()
    {
		$this->curl = curl_init();
		
		curl_setopt($this->curl, CURLOPT_BUFFERSIZE,8);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_PROGRESSFUNCTION, 'Http::Progress');
		curl_setopt($this->curl, CURLOPT_NOPROGRESS, false); // needed to make progress function work
		curl_setopt($this->curl, CURLOPT_HEADER, 0);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		//curl_close($ch);
    }
	
	public function Download($url)
	{
		curl_setopt($this->curl, CURLOPT_URL, $url);
		return curl_exec($this->curl);
	}

	private function Progress($resource,$download_size, $downloaded, $upload_size, $uploaded)
	{
	    if($download_size > 0)
	    {
		//echo $downloaded;
		//echo "\n";
		//echo $download_size;
		//echo "\n";
			echo $downloaded / $download_size  * 100;
			echo "\n";
	    }
	    //ob_flush();
	    //flush();
	    //sleep(1); // just to see effect
	}

}

