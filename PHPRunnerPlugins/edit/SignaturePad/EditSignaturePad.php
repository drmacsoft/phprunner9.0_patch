<?php 
class EditSignaturePad extends UserControl
{
	protected $height;
	protected $width;
	protected $bgcolor;
	protected $requried;
	protected $folder;

	public function initUserControl()
	{	
		$this->required = false;
		$this->width = 198;
		$this->height =55;
		$this->bgcolor = array(0xff, 0xff, 0xff);
		$this->folder = "files";
		
		if (isset($this->settings["width"]))
			$this->width = $this->settings["width"];
		if (isset($this->settings["height"]))
			$this->height = $this->settings["height"];
		if (isset($this->settings["bgcolor"]))
			$this->bgcolor = $this->settings["bgcolor"];			
		if (isset($this->settings["required"]))
			$this->required = $this->settings["required"];		
		if (isset($this->settings["folder"]))
			$this->folder = $this->settings["folder"];	

		$this->addJSSetting("required", $this->required);
		$this->addJSSetting("bgColor", '#' . dechex($this->bgcolor[0]) . dechex($this->bgcolor[1]) . dechex($this->bgcolor[2]));
	}
	
	public function buildUserControl($value, $mode, $fieldNum = 0, $validate, $additionalCtrlParams, $data)
	{
		echo '<div class="sigPad" style="width: '.($this->width+2).'px;">
			<ul class="sigNav">
				<li class="clearButton"><a href="#clear">Clear</a></li>
			</ul>
			<div class="sig sigWrapper">
				<div class="typed"></div>
				<canvas class="pad" width="'.$this->width.'" height="'.$this->height.'"></canvas>
				<input id="'.$this->cfield.'" type="hidden" '.'name="'.$this->cfield.'" class="output">
			</div>
		</div>';	
	}
	
	function getUserSearchOptions()
	{
		return array(EQUALS, STARTS_WITH, NOT_EMPTY, NOT_EQUALS);		
	}

	/**
	 * addJSFiles
	 * Add control JS files to page object
	 */
	function addJSFiles()
	{
		$this->pageObject->AddJSFile("json2.min.js");
		$this->pageObject->AddJSFile("jquery.signaturepad.js", "json2.min.js");
	}

	/**
	 * addCSSFiles
	 * Add control CSS files to page object
	 */ 
	function addCSSFiles()
	{
		$this->pageObject->AddCSSFile("jquery.signaturepad.css");
	}
	
	function readWebValue(&$avalues, &$blobfields, $legacy1, $legacy2, &$filename_values)
	{
		$this->getPostValueAndType();
		if( FieldSubmitted($this->goodFieldName."_".$this->id) )
			$this->webValue = prepare_for_db($this->field, $this->webValue, $this->webType);
		else
			$this->webValue = false;

		if( $this->webValue ) 
		{
			// save signature to file			
			require_once 'signature-to-image.php';
			$img = sigJsonToImage($this->webValue, array(
									'imageSize' => array($this->width, $this->height)
									,'bgColour' => $this->bgcolor
				));
			makeSurePathExists($this->folder);
			$filename= $this->folder."/".generatePassword(15).".png";
			imagepng($img, $filename);
			$filesize = filesize($filename);

			// prepare image info to be saved in db
			$result[] = array("name" => $filename,
				"usrName" => 'signature.png', "size" => $filesize, "type" => "image/png",
				"searchStr" => 'signature.png'.":sStrEnd");
				
			$this->webValue = my_json_encode($result);
		}
				
		if( !($this->webValue === false) )
		{
			$avalues[ $this->field ] = $this->webValue;
		}
	} 	
}
?>