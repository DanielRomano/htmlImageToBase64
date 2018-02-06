<?php

class emails {
	public $file = "";
	public function __construct($file) {
		$this->file = $file;
	}
	public function replaces()
	{
		$file = file_get_contents($this->file);
		$doc = new DOMDocument();
		$doc->loadHTML($file);
		//TODO error
		$imageTags = $doc->getElementsByTagName('img');
		foreach($imageTags as $tag) {
			$toBase64 = $this->imgToBase64($tag->getAttribute('src'));
			if(!$toBase64) {
				return "Error Opening Files";
			}
			$file = str_replace($tag->getAttribute('src'), $toBase64, $file);
		}
		return $file;
		
		
	}

	
	private function imgToBase64($path) {
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = @file_get_contents($path);
			if($data === FALSE)
			{
				$url = $url = explode('/',$this->file);
				array_pop($url);
				$url = implode('/', $url); 
				$data = @file_get_contents($url."/".$path);
				if($data === FALSE)
					return false;


			}

		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}

	
	public function tables()
	{
		$file = file_get_contents($this->file);
		$doc = new DOMDocument();
		$doc->loadHTML($file);
		//TODO error
		$imageTags = $doc->getElementsByTagName('table');
		foreach($imageTags as $table)
		{
		 	foreach($table->childNodes as $tr)
			{
				foreach($tr->childNodes as $td)
				{
					var_dump(strlen(html_entity_decode($td->textContent, ENT_QUOTES, 'UTF-8')));
				}
			}
		}
		
	}
	
}


$sf = new emails("test/test.html");
//echo $sf->replaces();
$sf->tables();

?>
