<?php
/*******************************************************************************
* Specialised API                                                              *
*                                                                              *
* Version: 2.0                                                                 *
* Date:    2016-02-26                                                          *
* Author:  AYERAKWA Henry Gyan                                                 *
*******************************************************************************/

//require_once('tcpdf_include.php');

class PMS_LIBRARY{
  var $pms_hostname; 
  var $pms_database; 
  var $pms_dbusername; 
  var $pms_dbpassword; 
  var $pms; 
  var $xml; 
  var $path; 
  var $sk;
  
  /*******************************************************************************
  *                               Constructor                                   *
  *******************************************************************************/
  public function __construct($h='localhost', $d='', $u='', $p=''){
  	$this->pms_hostname = $h;
		$this->pms_database = $d;
		$this->pms_dbusername = $u;
		$this->pms_dbpassword = $p;
		$this->xml = 'assets/xml/'; 
		$this->path = '';
  }
  
  /*******************************************************************************
  *                               Special methods                                *
  *******************************************************************************/
  function gvar($a,$b){return (isset($_GET[$b])) ? $_GET[$b] : $a;}
  function uploadImages($file,$f='docs/',$n=''){
	$extension = explode('.',$file['name']);
	$ext = count($extension)-1;
	$name = ($n!='') ? str_replace(' ','_',$n).'.'.$extension[$ext] : str_replace(' ','_',$file["name"]);
	
	if (file_exists($f . $name)) unlink($f . $name);
		move_uploaded_file($file["tmp_name"],$f.$name);
		  return  array($name,$extension[$ext]);
  }
  function uploadMultiple($file,$f='docs/',$profile=0,$cnt = 0){
	$result = array();
	if(!is_dir($f)) mkdir($f);
	foreach($file['name'] as $k=>$v){
	  $extension = explode('.',$v);
	  $ext = count($extension)-1;
	  $fname = ($profile!=0) ? $profile.'_'.($cnt+$k).'.'.$extension[$ext] : $v;
	  if (file_exists($f . $fname)) unlink($f . $fname);
	  move_uploaded_file($file["tmp_name"][$k],$f.$fname);
	  $result[] = $fname;
	}
	return $result;
  }
  function phpCookie($n='',$v=''){
	$n = $this->gvar($n,'name');
	$v = $this->gvar($v,'value');
	$_SESSION[$n] = str_replace('_',' ',$v);
   }
  function imgSize($f='',$h=0,$w=0,$s='',$m=''){
	//posible values of m
	//IMG_FILTER_NEGATE, IMG_FILTER_GRAYSCALE, IMG_FILTER_COLORIZE, 
	//IMG_FILTER_EDGEDETECT, IMG_FILTER_EMBOSS, IMG_FILTER_GAUSSIAN_BLUR, 
	//IMG_FILTER_SELECTIVE_BLUR, IMG_FILTER_MEAN_REMOVAL, IMG_FILTER_SMOOTH, IMG_FILTER_PIXELATE
	$file_name = $this->gvar($f,'f');
	$crop_height = $this->gvar($h,'h');
	$crop_width = $this->gvar($w,'w');
	$save_path = $this->gvar($s,'s');
	$mode = $this->gvar($m,'m');
	
	$oH = $crop_height;
	$oW = $crop_width;
	$isHv = ($crop_height == 0)?true:false;
	$isWv = ($crop_width == 0)?true:false;
	
	$original_image_size = getimagesize($file_name);
	$mime = $original_image_size['mime'];
	
	$original_width = $original_image_size[0];
	$original_height = $original_image_size[1];
	
	$crop_height = ($crop_height == 0)?($crop_width /$original_width)*$original_height:$crop_height;
	$crop_width = ($crop_width == 0)?($crop_height /$original_height)*$original_width:$crop_width;
	
	if($mime=='image/gif'){$original_image_gd = imagecreatefromgif($file_name);}	
	elseif($mime=='image/png'){$original_image_gd = imagecreatefrompng($file_name);}
	elseif($mime=='image/bmp'){$original_image_gd = imagecreatefromwbmp($file_name);}
	elseif($mime=='image/jpeg' ){$original_image_gd = imagecreatefromjpeg($file_name);}
	else{$original_image_gd = imagecreatefromgd($file_name);}
	

	$w_ratio = $original_width;
	$h_ratio = $original_height;
	$isWidth = false;$isHeight = false;
	
	if($original_width>$original_height ){
	  	$w_ratio = ($crop_height /$original_height)*$original_width;
		$h_ratio = $crop_height;
		$isWidth =($original_width>=$original_height)?true:false;
	}
	
	$new_canvas = imagecreatetruecolor($w_ratio,$h_ratio);
	
	imagecopyresampled($new_canvas , $original_image_gd ,0,0,0,0, $w_ratio, $h_ratio, $original_width , $original_height );
	
	$cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
	$white = imagecolorallocate($cropped_image_gd, 255, 255, 255);
	imagefill($cropped_image_gd, 0, 0, $white);
	$wm = $w_ratio /$crop_width;$hm = $h_ratio /$crop_height;
	$h_height = $crop_height/2;
	$w_height = $crop_width/2;
	
	if($isWidth && $w_ratio>$crop_width){ 
	  $adjusted_width =$w_ratio / $hm;$half_width = $adjusted_width / 2;$int_width = $w_height - $half_width;
	  imagecopyresampled($cropped_image_gd ,$new_canvas ,$int_width,0,0,0, $adjusted_width, $crop_height, $w_ratio , $h_ratio ); 
	}else{
	  $adjusted_height = $h_ratio / $wm;$half_height = $adjusted_height / 2;$int_height = $half_height - $h_height;
	  imagecopyresampled($cropped_image_gd , $new_canvas ,0,0,0,0, $crop_width, $adjusted_height, $w_ratio , $h_ratio );
	}
	
	if($mode == 2){
	  $opic = 'images/watermark.png';
	  $opicSize = getimagesize($opic);
	  $overlay_gd = imagecreatefrompng($opic);
	  $newImg[0] = $crop_width/2;
	  $newImg[1] = ceil(($newImg[0]/250)*75);
	  imagecopyresampled($cropped_image_gd ,$overlay_gd , ($crop_width)/3,($crop_height)/3,0,0, $newImg[0], $newImg[1], $opicSize[0], $opicSize[1] );
	}

	//IMG_FILTER_SMOOTH
	imagefilter($cropped_image_gd,IMG_FILTER_CONTRAST,-5);
	imagefilter($cropped_image_gd,IMG_FILTER_BRIGHTNESS,2);
	//imagefilter($cropped_image_gd,IMG_FILTER_COLORIZE,0,0,10);
	//imagefilter($cropped_image_gd,IMG_FILTER_SMOOTH,3);
	if($mode==1) imagefilter($cropped_image_gd,IMG_FILTER_GRAYSCALE);
	//echo 'success';
	if($save_path == ""){
	  header ("Content-type: image/jpeg");
	  imagejpeg($cropped_image_gd,NULL,100);
	}else{
	  header ("Content-type: image/jpeg");
	  imagejpeg($cropped_image_gd,$save_path,100);
	}
  }
  function imgBlob($f = ''){
  $f = $this->gvar($f,'f');
  header("Content-type: image/jpeg");
  echo $f;
  }
	function quote_image($dt, $file = ''){
		$quality = 100; 
		$i = 40; $size = $dt['size']; 
		$width = $dt['width'];
		$ht = $dt['height'];
		$margin = 20;
		$fontname = $dt['font'];
		$fontauth = $dt['font_author'];
		$fontweb = 'assets/fonts/opensans_regular/OpenSans-Regular-webfont.ttf';
		$fontref = 'assets/fonts/tangerine_bold/tangerine_bold-webfont.ttf';
		$seed = rand(1,date('Y')) * rand(1,date('dm')) * rand(1,date('B'));
		$file = ($file == '') ? 'assets/docs/quote/'.$dt['id'].'.jpg' : $file;

		// if the file already exists dont create it again just serve up the original
		if (!file_exists($file)) {
			$im = imagecreatetruecolor($width,$ht);
			$dst_image = imagecreatefromjpeg($dt['img']);
			$ois = getimagesize($dt['img']);
			imagecopyresized($im, $dst_image, 0, 0, 0, 0, $width, $ht, $ois[0],$ois[1]);

			$color = imagecolorallocate($im, $dt['color'][0], $dt['color'][1], $dt['color'][2]);
			$acolor = imagecolorallocate($im, $dt['color_author'][0], $dt['color_author'][1], $dt['color_author'][2]);
			
			$text_a = explode(' ', $dt['quote']);
			$text_new = '';
			foreach($text_a as $word){
					$box = imagettfbbox($size, 0, $fontname, $text_new.' '.$word);
					if($box[2] > $width - $margin*2)
						$text_new .= "\n".$word;
					else
						$text_new .= " ".$word;
			}
			$tnew = explode('<br>',str_replace('<br />','<br>',nl2br(trim($text_new))));
			$height = $box[1] + $size + $margin * 2;

			$y = (imagesy($im)-($height/2)-(2*$i))/2;
			foreach($tnew as $k=>$tn){
				$x = $this->center_text(trim($tn), $size, $fontname,$dt['width']);
				imagettftext($im, $size, 0, $x, $y, $color, $fontname,trim($tn));
				$y += $i*1.5;
			}
			
			
			$xx = $this->center_text($dt['ref'], 20, $fontref,$dt['width']);
			imagettftext($im, 20, 0, $xx, $y, $color, $fontref,$dt['ref']);
			
			imagettftext($im, 20, 0, 10, $ht-$i, $color, $fontweb,'allchristianquotes.org');
			
			$box = imagettfbbox(20, 0, $fontname, $dt['author']);
			imagettftext($im, 20, 0, $width-$box[2]-15, $ht-$i, $acolor, $fontauth,$dt['author']);
			
			imagejpeg($im, $file, $quality);
		}

		return $file;
	}
	function center_text($str, $size, $fontname,$image_width){
		//$image_width = 1200;
		$dimensions = imagettfbbox($size, 0, $fontname, $str);
		return ceil(($image_width - $dimensions[4]) / 2);
	}
	function get_qi($pid='', $size = '', $qt = ''){
		$pid = $this->gvar($pid,'pid');
		$sz = explode('x',$this->gvar($size,'size'));
		$qt = $this->gvar($qt,'qt');
		$preset = $this->getData('SELECT * FROM mopq WHERE id='.$pid);
		$dt = $preset[0];
		$quote = $this->getData('SELECT * FROM portal WHERE id='.$qt);
		
		$quality = 100; 
		$width = (int)$sz[0];
		$height = (int)$sz[1];
		$ht = (int)$sz[1];		
		$i = 10; $size = 9; 
		$margin = 5;
		
		$fnt = $this->fetch('menu','[@id=12]/model[@id='.$dt['font'].']/name');
		$afnt = $this->fetch('menu','[@id=12]/model[@id='.$dt['author_font'].']/name');
		$fontname = 'assets/fonts/quote_font/'.$fnt[0];
		$fontauth = 'assets/fonts/quote_font/'.$afnt[0];
		$fontweb = 'assets/fonts/opensans_regular/OpenSans-Regular-webfont.ttf';
		$fontref = 'assets/fonts/tangerine_bold/tangerine_bold-webfont.ttf';
		$text = $quote[0]['content'];
		$author = 'Authors name';
		list($r, $g, $b) = sscanf($dt['txt_color'], "#%02x%02x%02x");
		list($a, $b, $c) = sscanf($dt['author_color'], "#%02x%02x%02x");
		$rsize = 5;
		$asize = 5;
		
		if($dt['bg_image']==''){
			$im =  @imagecreate($width, $height);
		}
		else{
			$im = imagecreatetruecolor($width,$height);
			$dst_image = imagecreatefromjpeg('assets/docs/mopq/bg/'.$dt['bg_image']);
			$ois = getimagesize('assets/docs/mopq/bg/'.$dt['bg_image']);
			imagecopyresized($im, $dst_image, 0, 0, 0, 0, $width, $height, $ois[0],$ois[1]);
		}
		$color = imagecolorallocate($im, $r, $g, $b);
		$acolor = imagecolorallocate($im, $a, $b, $c);

		$text_a = explode(' ', $text);
		$text_new = '';
		foreach($text_a as $word){
				$box = imagettfbbox($size, 0, $fontname, $text_new.' '.$word);
				if($box[2] > $width - $margin*2)
					$text_new .= "\n".$word;
				else
					$text_new .= " ".$word;
		}
		
			$tnew = explode('<br>',str_replace('<br />','<br>',nl2br(trim($text_new))));
			$height = $box[1] + $size + $margin * 2;

			$y = (imagesy($im)-($height/2)-(2*$i))/2;
			foreach($tnew as $k=>$tn){
				$x = $this->center_text(trim($tn), $size, $fontname,$width);
				imagettftext($im, $size, 0, $x, $y, $color, $fontname,trim($tn));
				$y += $i*1.5;
			}
			
			
			$xx = $this->center_text($quote[0]['reference'], $rsize, $fontref,$width);
			imagettftext($im, $rsize, 0, $xx, $y, $color, $fontref,$quote[0]['reference']);
			
			imagettftext($im, $asize, 0, 5, $ht-$i, $color, $fontweb,'allchristianquotes.org');
			
			$box = imagettfbbox($asize, 0, $fontname, $author);
			imagettftext($im, $asize, 0, $width-$box[2], $ht-$i, $acolor, $fontauth,$author);
			
			header ("Content-type: image/jpeg");
			imagejpeg($im, NULL, $quality);
	}
  
  function _oneCellPdf($html='', $title=''){
  $title = ucwords(str_replace('_',' ',$this->gvar($title,'t')));
  $html = urldecode($this->gvar($html,'dt'));
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  //$pdf->SetAuthor('Nicola Asuni');
  $pdf->SetTitle($title.' '.date('d_m_Y'));
  $pdf->SetSubject('TCPDF Tutorial');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
  
  // set default header data
  //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title.' AS AT '.$this->fb(date('Y-m-d'),5), PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
  $pdf->setPrintHeader(false);
  $pdf->setFooterData(array(0,64,0), array(0,64,128));
  
  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  
  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  
  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  
  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  
  // set some language-dependent strings (optional)
  if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	  require_once(dirname(__FILE__).'/lang/eng.php');
	  $pdf->setLanguageArray($l);
  }
  
  // ---------------------------------------------------------
  
  // set default font subsetting mode
  $pdf->setFontSubsetting(true);
  
  $pdf->SetFont('dejavusans', '', 14, '', true);
  
  $pdf->AddPage();
  
  // set text shadow effect
  $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
  
  
  
  // Print text using writeHTMLCell()
  $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
  
  // ---------------------------------------------------------
  
  // Close and output PDF document
  // This method has several options, check the source code documentation for more information.
  $pdf->Output('example_001.pdf', 'I');
  }
  
  /*******************************************************************************
  *                         DB Connecting methods                         *
  *******************************************************************************/ 
  function _connect(){
		if(class_exists('pms')) $this->pms->close();
	  $this->pms = new mysqli($this->pms_hostname, $this->pms_dbusername, $this->pms_dbpassword, $this->pms_database); 
	  if ($this->pms->connect_error) echo "Failed to connect to MySQL: " . $this->pms->connect_error;
  }
  function display($p){
	//if(!$this->sk) $this->_specialCheck();
	$kc = $this->fetch('config','[@id="error"]/original');
	$page = (isset($_GET['v']))? $_GET['v']:'home';
	if($page == 'home'){$page = (isset($_GET['p']))? $_GET['p']:'home';}
	$reach = (isset($_GET['cat']))? $page.'_'.$_GET['cat']:$page;
	
	ob_start();
	  if(method_exists($p,$page)){ call_user_func(array($p,$page));}
	  elseif(isset($_GET['p'])&& !isset($_GET['v'])){call_user_func(array($p,'anotherHub'));}
	  else{call_user_func(array($p,'home'));}
	  $result = ob_get_contents();
	ob_end_clean();

	//echo ($this->sk) ? $result : $kc[0] ; 
	echo  $result ;
  }
  function get_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
  
  /*******************************************************************************
  *                            Data Retrieval methods                            *
  *******************************************************************************/
  function fetch($t,$a='',$p='xml'){
	$result = '';
	$p = ($p == 'xml') ? $this->xml : $p;
	if(file_exists($p.$t.'.xml')){
	  $sxe = simplexml_load_file($p.$t.'.xml');
  
		$c = ''; $d='';
	  if($a != ''){
		$aa = explode('&',$a);
		foreach($aa as $aaa){
		  $b = explode('=',$aaa);
		  if(substr($b[0],0,1)=='@') $c .= '['.$b[0].'="'.urldecode($b[1]).'"]'; 
		  else $d .= $a;
		}
	  }
	  $result = ($d=='')?$sxe->xpath('item'.$c):$sxe->xpath('item'.$d);
	}
	return $result;
  }
  function fetcha($t,$a='',$p='xml'){
		$result = array(); $cnt = 0;
		$xmlresult = $this->fetch($t, $a, $p);
		foreach($xmlresult as $xr){
			$result[$cnt]['id'] = $xr->attributes()->id;
			$result[$cnt]['name'] = $xr->name;
			$result[$cnt]['type'] = ($result[$cnt]['id']<100) ? 'Bible' : 'Normal' ;
			$cnt++;
		}
		return $result;
  }
  function fetchb($t,$a='',$p='xml'){
	$result = ''; $cnt = 0;
	$xmlResult = $this->fetch($t, $a, $p);
	
	foreach($xmlResult as $xr){
	  if(isset($xr->attributes()->id)) $result[$cnt]['id'] = (string)$xr->attributes()->id;
	  foreach($xr->field as $y)
		$result[$cnt][(string)$y->attributes()->id] = (string)$y->data;
	  $cnt++;
	}
	return $result;
  }
	function fetchc($t,$a='',$p='xml'){
		$result = array(); $cnt = 0;
		$xmlresult = $this->fetch($t, $a, $p);
		foreach($xmlresult as $xr){
			$result[$cnt]['id'] = $xr->attributes()->id;
			$result[$cnt]['name'] = $xr->name;
			$result[$cnt]['type'] = '';
			$cnt++;
		}
		return $result;
  }
  function fetchId($t,$id=''){
  	$result = '';
	if(file_exists($this->xml.$t.'.xml')){
	  $sxe = simplexml_load_file($this->xml.$t.'.xml');
	  $result = $sxe->xpath('item'.$c.'/'.$d);
	}
	return $result;
  }
  
  function getDataOpen($q,$link,$s=true){
	$p = mysqli_query($link,$q);
	
	if($s && $p){
	  $cnt = 0;$d=array();
	  
	  while($r = mysqli_fetch_assoc($p)){ 
		$d[$cnt] = $r; 
		$cnt++;
	  }
	  
	  return $d;
	}
	
	if($p) return true; else echo("Error description: " . mysqli_error($link));
  }
  function getData($q,$s=true){
	$result = false;
	$this->_connect();
	if($stmt = $this->pms->query($q)){
	  if($s) $result = $this->getResult($stmt,1);
	  else $result = true;
	}else $result = ($s) ? array() : false;

	$this->pms->close();
	
	return $result;
  }
  function getID($q,$m=false){
	$this->_connect();
	$result = '';
	
	if($stmt = $this->pms->query($q)){
	  $d = $this->getResult($stmt,2);
	  $result = substr($d,0,strlen($d)-1);
	}
	
	if($m) $this->pms->close();
	
	return $result;
  }
  
  function xml( $t = 'portal', $ids = '0', $s = '' ) {
  	$this->_connect();
  	$result = array();
  	$sort = ( $s == '' ) ? ' ORDER BY id DESC' : ' ORDER BY ' . $s;
  	$q = 'SELECT * FROM ' . $t . ' WHERE id IN(' . $ids . ') ' . $sort;
  	if ( $stmt = $this->pms->query( $q ) )
  		$result = $this->getResult( $stmt, 3 );

  	$this->pms->close();

  	return $result;
  }
  function fetch_news($t="portal",$oo='',$y=true){
	$o = explode("&",$oo);
	$b = array();
	if(strlen($oo)!=''){foreach($o as $p){$a = explode('=',$p);$b[$a[0]]=$a[1];}}
	
	//Setting allowable parameters for options
	$f = "SELECT id FROM ".$t;
	$x = "";
	foreach($b as $k=>$v){
	  if(!in_array($k,array("sort","limit"))){
	  $x .= (is_numeric($v))?$k."=".$v:$k."='".$v."'";
	  $x .= " AND ";}
	 }
	$x = substr($x,0,strlen($x)-5);
	$l = (isset($b['limit']))?$b['limit']:'';
	$s = (isset($b['sort'])) ? $b['sort']:'id DESC';
	
	$f .= (strlen($x)>0) ? " WHERE ".$x : '';
	$f .= ($l != '') ? ' LIMIT '.$l : '' ;
	
	return $this->xml($t,$this->getID($f),$s); 
  }
  function getResult($stmt, $t=1){
	$result = ($t == 1) ? array() : '' ;
	
	if($t == 1)
	  while($r = $stmt->fetch_assoc())
		$result[] = $r;
		 
	else if($t == 2)
	  while($r = $stmt->fetch_assoc())
		$result .= $r['id'].','; 
	
	else if($t == 3){
	  $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\t<data>\n";
	  while($r = $stmt->fetch_assoc()){
		$xml .= "\t<row>\n";
		foreach($r as $k=>$v)
		  $xml .= "\t<$k>\n<![CDATA[".$v."]]>\t</$k>\n";
		$xml .= "\t</row>\n";
	   }
	  $xml .= "\t</data>\n";
	  $result = simplexml_load_string($xml);
	}
	
	return $result;
  }
  
  /*******************************************************************************
  *                                XPath methods                                 *
  *******************************************************************************/ 
  function _updateXML($d = ''){
	$d = json_decode($this->gvar($d,'d'),true);
	
	$xml = simplexml_load_file('xml/'.$d['fn'].'.xml');  
	
	$itemsList = $xml->xpath($d['path']);             
	if($d['node'] == 'cat')
	  $itemsList[0]->cat = $d['val'];
	else
	  $itemsList[0]->name = $d['val'];
	
	//$xml->asXml($d['fn'].'.xml');
	if($xml->asXml('xml/'.$d['fn'].'.xml')) return true;
	else return false;
  }
	
	function _addXmlData($d = ''){
		$dt = json_decode($this->gvar($d,'d'),true);

		$att = (is_numeric($dt['vl'][1])) ? $dt['vl'][1] : '"'.$dt['vl'][1].'"' ;
		$qr ='//item[@'.$dt['vl'][0].'='.$att.']' ;

		$dom = new DOMDocument();
    $dom->load($this->xml.$dt['fl'].'.xml');
	
		$library = $dom->documentElement;
		$xpath = new DOMXPath($dom);
		$result = $xpath->query($qr);
	
		$main = $dom->createElement($dt['item'][0]);
		if(isset($dt['item'][1])) $main->setAttribute($dt['item'][1],$dt['item'][2]);
		if(isset($dt['item']['extra']) && is_array($dt['item']['extra'])):
			foreach($dt['item']['extra'] as $ex){
				$extra = (isset($ex['v'])) ? $dom->createElement($ex['fn'],$ex['v']) : $dom->createElement($ex['fn']);
				if(isset($ex['at']))$extra->setAttribute($ex['at'],$ex['atv']);
				$main->appendChild($extra);

				if(isset($ex[0])){
					$sub = $dom->createElement($ex[0]['fn'],$ex[0]['v']);
					$extra->appendChild($sub);
				}
			}
		endif;

		$library->childNodes->item($dt['num'])->insertBefore($main,$result->item(0));

		if($dom->save($this->xml.$dt['fl'].'.xml')) return true;
		return false;
  }
  function _editXmlData($d = ''){
		$d = json_decode($this->gvar($d,'d'),true);

		$xml = simplexml_load_file($this->xml.$d['fl'].'.xml');  

		$itemsList = $xml->xpath($d['path']);             
		$itemsList[0]->name = $d['val'];

		if($xml->asXml($this->xml.$d['fl'].'.xml')) return true;
		else return false;
  }
	
  function _addXML($d = ''){
	//How d is passed
	/*$data = json_encode(array(
	  'type'=>'','node'=>'id','fn'=>'trial',
	  'cat'=>array('node'=>'name','val'=>'Agrimac'),
	  'sub'=>array('node'=>'model','id'=>'1','val'=>'Any Model','lev'=>'name')
	));*/
	$data = json_decode($this->gvar($d,'d'),true);
	
	$dom = new DOMDocument();
    $dom->load($this->xml.$data['fn'].'.xml');
    $library = $dom->documentElement;
     
	$item = $dom->createElement('item');
	$item->setAttribute($data['node'],$data['type']);
	
	if(isset($data['cat'])){
	  $first = $dom->createElement($data['cat']['node']);
	  $text = $dom->createTextNode($data['cat']['val']);
	  $first->appendChild($text);
	  $item->appendChild($first);
	  
	  if(isset($data['sub'])){
		$first = $dom->createElement($data['sub']['node']);
		$second = $dom->createElement($data['sub']['lev']);
		$first->setAttribute('id',$data['sub']['id']);
		$stext = $dom->createTextNode($data['sub']['val']);
		$second->appendChild($stext);
		$first->appendChild($second);
		$item->appendChild($first);
	  }
	}
          
    $library->appendChild($item);
	
    if($dom->save($this->xml.$data['fn'].'.xml')) return true;
	return false;
  }
  function _newXML($d = ''){
	//data parsed
	/*$data = json_encode(array(
	  ''fn'=>'trial','path'=>'//item[@id=100]',
	  'itm'=>array('tag'=>'model','at'=>'id',atv'=>10,lev=>array('val'=>'Origon','tag'=>'name'))
	));*/
	
	$d = json_decode($this->gvar($d,'d'),true);
	
	$xml = simplexml_load_file($this->xml.$d['fn'].'.xml');  
	$itemsList = $xml->xpath($d['path']);
	
	$child = $itemsList[0]->addChild($d['itm']['tag']);
	if(isset($d['itm']['at'])) $child->addAttribute($d['itm']['at'],$d['itm']['atv']);
	
	if(isset($d['itm']['lev'])){
		$subchild = $child->addChild($d['itm']['lev']['tag'],$d['itm']['lev']['val']);
	}
	
	if($xml->asXml($this->xml.$d['fn'].".xml")) return true;
	return false;
  }
  function _delXML($d = ''){
	//data parsed
	//$data = json_encode(array('fn'=>'trial','path'=>'[@id=100]/model[@id=10]'));
	
	$d = json_decode($this->gvar($d,'d'),true);
	
	$xml = simplexml_load_file('xml/'.$d['fn'].'.xml');  
	$itemsList = $xml->xpath('item'.$d['path']);
	
	$parent = $itemsList[0];
	unset($parent[0]);
	
	$xml->asXml('xml/'.$d['fn'].'.xml');
  }
 
  /*******************************************************************************
  *                                 Text methods                                 *
  *******************************************************************************/
  function sentence($t,$l=''){
	$p =''; $x = array('.','!','?'); $cnt = 0;
	$t = $this->removePar($t);
	do{
	  $f = strlen(trim($t));
	  foreach($x as $n){
		$pos = strpos($t,$n);
		if($pos !=false){if(substr($t,$pos+1,1) == '"') $pos++;$f = ($pos < $f)? $pos : $f;}
	  }
	  $p .=substr($t,0,$f+1); $t = substr($t,$f+1); $cnt++;
	  if($l != '' && $cnt == $l) break; 
	}while(strlen(trim($t))>0);
	return $p;
  }
  function word($t,$l=''){
	$p =''; $x = array(' '); $cnt = 0;
	$t = $this->removePar($t);
	do{
	  $f = strlen(trim($t));
	  foreach($x as $n){
		$pos = strpos($t,$n);
		if($pos !=false){if(substr($t,$pos+1,1) == '"') $pos++;$f = ($pos < $f)? $pos : $f;}
	  }
	  $p .=substr($t,0,$f+1); $t = substr($t,$f+1); $cnt++;
	  if($l != '' && $cnt == $l) break; 
	}while(strlen(trim($t))>0);
	return $p;
  }
  function removePar($t){
	$x = array('<p>','</p>','<br />','<div>','</div>');
	$t = str_replace($x,'',$t);
	return $t;
  }
  function truncate($t,$no,$l="min",$d=""){
	$t = $this->removePar(stripslashes($t));
	if(trim($t) !="" && strlen(trim($t)) >= $no):
	  if($l == "min"){while(substr($t,$no,1) != " ") $no--;}
	  elseif($l == "min"){while(substr($t,$no,1) != " ") $no++;}
	  return substr($t,0,$no).$d;
	else:
	  return trim($t);
	endif;
  }
  
  function autopass(){
	$l = 8;$c = '';$set = '123456789ABCDEFGHLMNPQRSTUVWXYZabdefghmnqrtyz';
	for($i=0; $i < $l; $i++) {$c = $c . substr($set, mt_rand(0, strlen($set) - 1), 1);}
	return $c;
  }
  
  /*******************************************************************************
  *                              Security methods                                *
  *******************************************************************************/ 
  function isAuthorized($g, $ug){
	$v = false; 
	if (!empty($ug)) { 
	  $ag = Explode(",", $g); 
	  if (in_array($ug, $ag)) $v = true; 
	} 
	return $v;
   }
  function securePage($authorize_users='',$success = ''){
	//Securing page and ensuring only authorized users can view it
	$MM_authorizedUsers = $authorize_users; $MM_donotCheckaccess = "false";
	$MM_restrictGoTo = $this->path.$success;
	
	if (!isset($_SESSION['fcl_ug']) || trim($_SESSION['fcl_ug']<=0) || !$this->sk || !($this->isAuthorized($MM_authorizedUsers,$_SESSION['fcl_ug']))){   
	  //$MM_qsChar = '?';
	  //$MM_referrer = ($success == '') ? $_SERVER['PHP_SELF'] : $success;
	  //$_SESSION['prvURL'] = $this->path.$MM_referrer;
	  header('Location: '. $MM_restrictGoTo); 
	  exit;
	 }
  }
  function securePages($authorize_users=""){
	//Securing page and ensuring only authorized users can view it
	$MM_authorizedUsers = $authorize_users; $MM_donotCheckaccess = "false";
	$MM_restrictGoTo = $this->path."index.php";
	
	if (!isset($_SESSION['fcl_ug']) || trim($_SESSION['fcl_ug']<=0) || !$this->sk || !($this->isAuthorized($MM_authorizedUsers,$_SESSION['fcl_ug']))){     
	  $MM_qsChar = "?";
	  $MM_referrer = $_SERVER["PHP_SELF"];
	  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	  if (isset($_SERVER["QUERY_STRING"]) && strlen($_SERVER["QUERY_STRING"]) > 0) 
	  $MM_referrer .= "?" . $_SERVER["QUERY_STRING"];
	  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	  header("Location: ". $MM_restrictGoTo); 
	  exit;
	 }
  }
  function _specialCheck(){
	$fc = array(' ','.','\'','-',',','&amp;','&');$cut = 0;$icode = '';$v = 0;
	$cp = $this->fetch('config','[@id="1"]');
	$item = str_replace($fc,'',strtoupper($cp[0]->name));
	$len = strlen($item);
	$let = str_split($item);
	$char = array(
	  'A'=>'1','B'=>'2','C'=>'3','D'=>'4','E'=>'5','F'=>'6','G'=>'7','H'=>'8','I'=>'9','J'=>'0',
	  'K'=>'1','L'=>'2','M'=>'3','N'=>'4','O'=>'5','P'=>'6','Q'=>'7','R'=>'8','S'=>'9','T'=>'0',
	  'U'=>'1','V'=>'2','W'=>'3','X'=>'4','Y'=>'5','Z'=>'6'
	);
	foreach($let as $l){ $v += $char[$l];$icode .=$char[$l];$cut++;$icode .= ($cut % 5 == 0)?'-':'';}
	$limit = $v % $len;
	$this->sk = (password_verify($icode.'-'.$limit,$cp[0]->valid)) ? true : false ;
  }
  
  /*******************************************************************************
  *                                Date methods                                 *
  *******************************************************************************/ 
  function fb($f,$s=0){
	date_default_timezone_set('Africa/Accra');
	$f = $this->gvar($f,'f');
	if(isset($f) && $f != ''){
	  $a = explode(' ',$f); 
	  $d = (stripos($a[0],'/')) ? explode('/',$a[0]) : explode('-',$a[0]);
	  if(isset($a[1])){$t = explode(':',$a[1]);}else{$t = array(0,0,0);}
	 
	  if($s == 0) return date("F jS, Y", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0]))); 
	  if($s == 1) return date("l d M, Y | H:s", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 2) return date("d / m / Y", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 3) return date("g:ia", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 4) return date("d M, Y @ g:ia", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 5) return date("d M, Y", mktime(0,0,0,trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 6) return date("M d", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 7) return date("D d, F Y", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 8) return date("F jS, Y @ g:ia", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 9) return date("Y", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
	  if($s == 10){
	  	$x = date("d", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
		$y = date("M", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
		$z = date("Y", mktime(trim($t[0]),trim($t[1]),trim($t[2]),trim($d[1]),trim($d[2]),trim($d[0])));
		return array('day'=>$x,'month'=>$y,'year'=>$z);
	  }
	  if($s == 99){
		$d1=date_create(date('Y-m-d'));$d2=date_create($f);$diff=date_diff($d1,$d2);
		$r = $diff->format("%a");
		if($r == 0) $result = 'Today';
		else if($r == 1) $result = 'Yesterday';
		else if($r < 30) $result = $r.' days ago';
		else $result = $this->fb($f,5);
		return $result;
	  }
	}
  }
  function parseWord($userDoc) {
	$fileHandle = fopen($userDoc, "r");
	$line = @fread($fileHandle, filesize($userDoc));   
	$lines = explode(chr(0x0D),$line);
	$outtext = "";
	foreach($lines as $thisline)
	  {
		$pos = strpos($thisline, chr(0x00));
		if (($pos !== FALSE)||(strlen($thisline)==0))
		  {
		  } else {
			$outtext .= $thisline." ";
		  }
	  }
	 $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
	return $outtext;
  } 
  function is_date( $str ){ 
    $stamp = strtotime( $str ); 
    if (!is_numeric($stamp)) 
        return FALSE; 
    $month = date( 'm', $stamp ); 
    $day   = date( 'd', $stamp ); 
    $year  = date( 'Y', $stamp ); 
    if (checkdate($month, $day, $year)) 
        return TRUE; 
    return FALSE; 
  }
  function age($s= '',$e='2015-08-25 11:11:00', $a=false){
	$s = ($s == '') ? date_diff(date_create(), date_create($e)) : date_diff(date_create($s), date_create($e)) ;
	$o = $s->format("Years:%Y,Months:%M,Days:%d,Hours:%H,Minutes:%i,Seconds:%s");
	if(!$a) return $o;
	$ao = array();
	foreach(explode(',',$o) as $v){ $b=explode(':',$v); $ao[$b[0]] = $b[1]; }
	return $ao;
  }
  
  function _gl($type = '',$id = 1){
	$id = ($id < 1) ? 1 : $id ;
	$data = $this->fetch('lists','[@type="'.$type.'"]/listing[@id='.$id.']/cat');
	return (isset($data[0])) ? $data[0] : 'Not Specified';
  }
} 
?>
