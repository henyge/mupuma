<?php
require_once('inc.quotes.php');
ini_set('display_errors',1); 

//Initialize Library API
$lib = new QUOTES();

//print_r($_POST); echo 'testing'; 

if(isset($_POST['MM_topic']) && $_POST['MM_topic'] == 'topic'){
  $dt = $_POST['topic'];

	if($dt['id'] > 0){
		$json = json_encode(array(
			'fl'=>'menu', 'val'=>$dt['name'],
			'path'=>'//item[@id=4]/model[@id='.$dt['catsub'].']/series[@id='.$dt['id'].']'
		));
		if($lib->_editXmlData($json)) echo 'Topic updated successfully...';
		else echo 'There was a problem updating topic, please try again later...';
	}
	else{
		$last = $lib->fetch('menu','[@id=4]/model[@id='.$dt['catsub'].']/series/@id[not(. < ../../series/@id)][1]');
		$new = (isset($last[0]->id)) ? (int)$last[0]->id + 1 : 1;
		
		$json = json_encode(array(
	  	'fn'=>'menu','path'=>'//item[@id=4]/model[@id='.$dt['catsub'].']',
	  	'itm'=>array('tag'=>'series','at'=>'id','atv'=>$new,
				'lev'=>array('val'=>preg_replace('#[^A-Za-z0-9-_ ]#','',$dt['name']),'tag'=>'name')
			)
		));

		if($lib->_newXML($json)) echo 'Topic created successfully...';
		else echo 'There was a problem saving topic, please try again later...';
	}
}

if(isset($_POST['MM_country']) && $_POST['MM_country'] == 'country'){
  $dt = $_POST['country'];
	//print_r($dt);
	//Array ( [id] => 1 [name] => Ghana ) 

	if($dt['id'] > 0){
		$json = json_encode(array(
			'fl'=>'menu', 'val'=>$dt['name'],
			'path'=>'//item[@id=11]/model[@id='.$dt['id'].']'
		));
		if($lib->_editXmlData($json)) echo 'Country updated successfully...';
		else echo 'There was a problem updating country, please try again later...';
	}
	else{
		$last = $lib->fetch('menu','[@id=11]/model/@id[not(. < ../../model/@id)][1]');
		$new = (isset($last[0]->id)) ? (int)$last[0]->id + 1 : 1;
		
		$json = json_encode(array(
	  	'fn'=>'menu','path'=>'//item[@id=11]',
	  	'itm'=>array('tag'=>'model','at'=>'id','atv'=>$new,
				'lev'=>array('val'=>preg_replace('#[^A-Za-z0-9-_ ]#','',$dt['name']),'tag'=>'name')
			)
		));

		if($lib->_newXML($json)) echo 'Country created successfully...';
		else echo 'There was a problem saving country, please try again later...';
	}
}

if(isset($_POST['MM_quote']) && $_POST['MM_quote'] == 'quote'){
  try{
		$lib->_connect();
		$lib->pms->begin_transaction();
		
		$dt = $_POST['quote'];
		$ref = '';
		if(isset($dt['feature']))
			foreach($dt['feature'] as $rf)
				$ref .= $rf;
		
		$query = ($dt['id']>0) ? 'UPDATE portal SET content=?, creation_date=?, reference=?, author=?, status=? WHERE id=?' : 'INSERT INTO portal(page, content, creation_date, reference, author, status, post_by, category) VALUES(3, ?, ?, ?, ?, ?, ?, ?)' ;
		$stmt = $lib->pms->prepare($query);
		if(isset($dt['id']) && $dt['id']>0)
			$stmt->bind_param("sssssi", $dt['message'], $dt['sdate'], $dt['reference'], $dt['author'][0], $ref, $sid);
		else
			$stmt->bind_param("sssssii", $dt['message'], $dt['sdate'], $dt['reference'], $dt['author'][0], $ref, $_SESSION['qts_ui'], $sid);
		$sid = ($dt['id']>0) ? $dt['id'] : $dt['type'];

	  
	  if($stmt->execute()){
			$itm = ($dt['id']>0) ? $dt['id'] : $lib->pms->insert_id ;
			
			$fold = 'assets/docs/audio/';
			$seed = rand(1,date('Y')) * rand(1,date('dm'));
			$image = (isset($_FILES['attach'])) ? $lib->uploadImages($_FILES['attach'],$fold,$seed) : array();
			
			if(count($image)>0){
				$audid = $lib->getDataOpen('SELECT id FROM multimedia WHERE owner="portal" AND owner_id='.$itm,$lib->pms);
				$aquery = (isset($audid[0]['id'])) ? 'UPDATE multimedia SET filename=? WHERE id=?' : 'INSERT INTO multimedia(media_type, owner, filename, owner_id) VALUES(3, "portal", ?, ?)' ;
				$atmt = $lib->pms->prepare($aquery);
				$atmt->bind_param("si", $image[0],$aid);
				$aid = (isset($audid[0]['id'])) ? $audid[0]['id'] : $itm ;
				$atmt->execute();
			}
			
			$tagid = $lib->getDataOpen('SELECT id FROM quote_tags WHERE portal='.$itm,$lib->pms);
			$ti = array('', '', '', '');
			$tquery = (isset($tagid[0]['id'])) ? 'UPDATE quote_tags SET tag_1=?, tag_2=?, tag_3=?, tag_4=? WHERE id=?' : 'INSERT INTO quote_tags(tag_1, tag_2, tag_3, tag_4, portal) VALUES(?, ?, ?, ?, ?)' ;
			$tmt = $lib->pms->prepare($tquery);
			$tmt->bind_param("iiiii", $ti[0], $ti[1], $ti[2], $ti[3], $tid);
			$tid = (isset($tagid[0]['id'])) ? $tagid[0]['id'] : $itm ;
			
			$cnt = 0;
			foreach($dt['tags'] as $tg){$ti[$cnt] = $tg; $cnt++;}
			
			$tmt->execute();
		}else{
			echo(mysqli_stmt_error($stmt)) ;
		}
		
		$lib->pms->commit();
		echo 'Quote saved successfully...';
	}
	catch(Exception $e){
		$lib->pms->rollBack();
		die("There was a problem saving Quote, please try again later");
	}
	
	$lib->pms->close();
}

if(isset($_POST['MM_page']) && $_POST['MM_page'] == 'page'){
	try{
		$lib->_connect();
		$lib->pms->begin_transaction();
		
		$dt = $_POST['page'];
		$auth = $dt['author'][0];
		
		$query = ($dt['id']>0) ? 'UPDATE portal SET title=?, content=?, author=? WHERE id=?' : 'INSERT INTO portal(page, category, title, content, author) VALUES(?, ?, ?, ?, ?)' ;
		$stmt = $lib->pms->prepare($query);
		if($dt['id']>0) $stmt->bind_param("sssi", $dt['title'], $dt['content'], $auth, $dt['id']);else $stmt->bind_param("iisss", $dt['cat'], $dt['catsub'], $dt['title'], $dt['content'], $auth);
		
		if($stmt->execute()){
			$itm = ($dt['id']>0) ? $dt['id'] : $lib->pms->insert_id ;
			
			$fold = 'assets/docs/image/';
			$seed = rand(1,date('Y')) * rand(1,date('dm'));
			$image = (isset($_FILES['attach'])) ? $lib->uploadImages($_FILES['attach'],$fold,$seed) : array();
			
			if(count($image)>0){
				$audid = $lib->getDataOpen('SELECT id FROM multimedia WHERE owner="portal" AND owner_id='.$itm,$lib->pms);
				$aquery = (isset($audid[0]['id'])) ? 'UPDATE multimedia SET filename=? WHERE id=?' : 'INSERT INTO multimedia(media_type, owner, filename, owner_id) VALUES(1, "portal", ?, ?)' ;
				$atmt = $lib->pms->prepare($aquery);
				$atmt->bind_param("si", $image[0],$aid);
				$aid = (isset($audid[0]['id'])) ? $audid[0]['id'] : $itm ;
				$atmt->execute();
			}
			
		}else echo(mysqli_stmt_error($stmt)) ;
		
		$lib->pms->commit();
		echo 'Page saved successfully...';
	}
	catch(Exception $e){
		$lib->pms->rollBack();
		die("There was a problem saving Page, please try again later");
	}
	
	$lib->pms->close();
}

if(isset($_POST['MM_author']) && $_POST['MM_author'] == 'author'){
	//print_r($_POST['author']);
	try{
		$lib->_connect();
		$lib->pms->begin_transaction();
		
		$dt = $_POST['author'];
		$bd = (!isset($dt['birth']) || $dt['birth'] == '') ? NULL : $dt['birth'] ;
		$dd = (!isset($dt['death']) || $dt['death'] == '') ? NULL : $dt['death'] ;
		$em = (!isset($dt['email']) || $dt['email'] == '') ? NULL : $dt['email'] ;
		$ph = (!isset($dt['phone']) || $dt['phone'] == '') ? NULL : $dt['phone'] ;
		$cty = 0;
		if(isset($dt['country']) && !is_numeric($dt['country'])){
			$getCountry = $lib->fetch('menu','[@id=11]/model[name="'.$dt['country'].'"]/@id');
			$cty = $getCountry[0];
		}
		else if(is_numeric($dt['country'])){
			$cty = $dt['country'] ;
		}
		
		
		$query = ($dt['id']>0) ? 'UPDATE profile SET auth=?, fname=?, mname=?, lname=?, occupation=?, birth_date=?, death_date=?, email=?, phone=?, country=?, notes=? WHERE id=?' : 'INSERT INTO profile(auth, fname, mname, lname, occupation, birth_date, death_date, email, phone, country, notes) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)' ;
		$stmt = $lib->pms->prepare($query);
		if($dt['id']>0) $stmt->bind_param("issssssssisi", $dt['type'], $dt['fname'], $dt['mname'], $dt['lname'], $dt['occupation'], $bd, $dd, $em, $ph, $cty, $dt['note'], $dt['id']);else $stmt->bind_param("isssssssiss", $dt['type'], $dt['fname'], $dt['mname'], $dt['lname'], $dt['occupation'], $bd, $dd, $em, $ph, $cty, $dt['note']);
		
		if($stmt->execute()){
			$itm = ($dt['id']>0) ? $dt['id'] : $lib->pms->insert_id ;
			
			$fold = 'assets/docs/image/';
			$seed = rand(1,date('Y')) * rand(1,date('dm'));
			$image = (isset($_FILES['attach'])) ? $lib->uploadImages($_FILES['attach'],$fold,$seed) : array();
			
			if(count($image)>0){
				$audid = $lib->getDataOpen('SELECT id FROM multimedia WHERE owner="profile" AND owner_id='.$itm,$lib->pms);
				$aquery = (isset($audid[0]['id'])) ? 'UPDATE multimedia SET filename=? WHERE id=?' : 'INSERT INTO multimedia(media_type, owner, filename, owner_id) VALUES(1, "profile", ?, ?)' ;
				$atmt = $lib->pms->prepare($aquery);
				$atmt->bind_param("si", $image[0],$aid);
				$aid = (isset($audid[0]['id'])) ? $audid[0]['id'] : $itm ;
				$atmt->execute();
			}
			
			if(isset($dt['pass'])){
				$pass = password_hash($dt['pass'], PASSWORD_BCRYPT);
				$pquery = 'UPDATE profile SET password=? WHERE id=?';
				$ptmt = $lib->pms->prepare($pquery);
				$ptmt->bind_param("si", $pass, $itm);
				$ptmt->execute();
			}
			
		}else echo(mysqli_stmt_error($stmt)) ;
		
		$lib->pms->commit();
		echo 'Profile/Author saved successfully...';
	}
	catch(Exception $e){
		$lib->pms->rollBack();
		die("There was a problem saving Profile/Author, please try again later");
	}
	
	$lib->pms->close();
}

if(isset($_POST['MM_password']) && $_POST['MM_password'] == 'password'){
	$dt = $_POST['password'];
	$user = $lib->getData('SELECT password FROM profile WHERE id='.$dt['id']);
	//echo 'This is UG: '.$_SESSION['qts_ug'];
	if(!isset($user[0]['password']) || $_SESSION['qts_ug']==1 || password_verify($dt['old'],$user[0]['password'])){
		$pass = password_hash($dt['new'], PASSWORD_BCRYPT);
		$query = 'UPDATE profile SET password="'.$pass.'" WHERE id='.$dt['id'];
		if($lib->getData($query,false)) echo 'Password changed successfully...';
		
	}else echo 'Your old password is not correct...';
}

if(isset($_POST['MM_quote']) && $_POST['MM_quote'] == 'create'){
	try{
		$lib->_connect();
		$lib->pms->begin_transaction();
		
		$dt = $_POST;
		$ref = '';
		$tagnum[0] = (isset($dt['tag1'])) ? $dt['tag1'] : 0 ;
		$tagnum[1] = (isset($dt['tag2'])) ? $dt['tag2'] : 0 ;
		$tagnum[2] = (isset($dt['tag3'])) ? $dt['tag3'] : 0 ;
		$tagnum[3] = (isset($dt['tag4'])) ? $dt['tag4'] : 0 ;
		
		$author = (isset($dt['isOwner']) && $dt['isOwner']!=0) ? $_SESSION["qts_ui"] : $dt['author'] ;
		$date = date('Y-m-d');
		
		$query = (isset($dt['id']) && $dt['id']>0) ? 'UPDATE portal SET content=?, creation_date=?, reference=?, author=?, status=? WHERE id=?' : 'INSERT INTO portal(page, content, creation_date, reference, author, status, category, post_by) VALUES(3, ?, ?, ?, ?, ?, ?, ?)' ;
		$stmt = $lib->pms->prepare($query);
		if(isset($dt['id']) && $dt['id']>0)
			$stmt->bind_param("sssssi", $dt['quote'], $date, $dt['reference'], $author, $ref, $sid);
		else
			$stmt->bind_param("sssssii", $dt['quote'], $date, $dt['reference'], $author, $ref, $sid, $_SESSION["qts_ui"]);
		$sid = (isset($dt['id']) && $dt['id']>0) ? $dt['id'] : 1;

	  
	  if($stmt->execute()){
			$itm = (isset($dt['id']) && $dt['id']>0) ? $dt['id'] : $lib->pms->insert_id ;
			
			$tagid = $lib->getDataOpen('SELECT id FROM qtags WHERE portal='.$itm,$lib->pms);
			
			foreach($tagnum as $k=>$tn){
				$tquery = (isset($tagid[$k]['id'])) ? 'UPDATE qtags SET tagnum=? WHERE id=?' : 'INSERT INTO qtags(tagnum, portal) VALUES(?, ?)' ;
				$tmt = $lib->pms->prepare($tquery);
				$tmt->bind_param("ii", $tn, $tid);
				$tid = (isset($tagid[$k]['id'])) ? $tagid[$k]['id'] : $itm ;

				$tmt->execute();
			}
			
		}else{
			echo(mysqli_stmt_error($stmt)) ;
		}
		
		$lib->pms->commit();
		echo 'Quote saved successfully...';
	}
	catch(Exception $e){
		$lib->pms->rollBack();
		die("There was a problem saving Quote, please try again later");
	}
	
	$lib->pms->close();
	
}

if(isset($_POST['MM_subscribe']) && $_POST['MM_subscribe'] == 'subscribe'){
	$dt = $_POST['sub'];
	
	$check = $lib->getData('SELECT id FROM subscribe WHERE email="'.$dt['email'].'"');
	if(!isset($check[0]['id'])){
		if($lib->getData('INSERT INTO subscribe(email) VALUES("'.$dt['email'].'")', false)) echo 'Subscription successful...';
		else echo 'There was a problem placing your subscription, please try again later...';
	}else{
		echo 'Email already exist...';
	}
}

if(isset($_POST['MM_favourite']) && $_POST['MM_favourite'] == 'favourite'){
	$dt = $_POST;
	if($lib->getData('INSERT INTO savedquotes(profile, portal) VALUES('.$_SESSION['qts_ui'].', '.$dt['id'].')',false))
	echo 'yes';
	else echo 'There was a problem saving quote, please try again later...';
}

if(isset($_POST['MM_meta']) && $_POST['MM_meta'] == 'meta'){
	$dt = $_POST['meta'];
	
	$query = ($dt['id']>0) ? 'UPDATE quote_meta_tags SET url="'.$dt['url'].'", title="'.$dt['title'].'", image="'.$dt['image'].'", keywords="'.$dt['keywords'].'", description="'.$dt['desc'].'" WHERE id='.$dt['id'] : 'INSERT INTO quote_meta_tags(url, title, image, keywords, description) VALUES("'.$dt['url'].'", "'.$dt['title'].'", "'.$dt['image'].'", "'.$dt['keywords'].'", "'.$dt['desc'].'")';
	
	if($lib->getData($query, false)) echo 'Meta tag saved successfully...';
	else echo 'There was a problem saving Meta tag, please try again later...';
}

if(isset($_POST['MM_contact']) && $_POST['MM_contact'] == 'contact'){
	$dt = $_POST['contact'];
	
	$query = 'INSERT INTO contacts(fullname, subject, email, phone, country, message) VALUES("'.$dt['name'].'", "'.$dt['subject'].'", "'.$dt['email'].'", "'.$dt['phone'].'", '.$dt['country'].', "'.preg_replace('#[^A-Za-z0-9 ,.\'"?!@%*&-+=;:]#','',$dt['message']).'")';
	
	if($lib->getData($query,false)) echo 'Your message was submitted successfully, Thank you...';
	else echo 'There was a problem submitting your message, please try again later...';
}

if(isset($_POST['MM_myop']) && $_POST['MM_myop'] == 'preset'){
	$dt = $_POST['myop'];

	try{
		$lib->_connect();
		$lib->pms->begin_transaction();
		
		$fold = 'assets/docs/mopq/bg/';
		$seed = rand(1,date('Y')) * rand(1,date('dm'));
		$image = (isset($_FILES['attach'])) ? $lib->uploadImages($_FILES['attach'],$fold,$seed) : array();
		if(count($image)>0 || $dt['exist'] != ''){
			$img = ($dt['exist'] != '') ? $dt['exist'] : '';
			if($dt['exist'] == ''){
				$img = $image[0];
				$last = $lib->fetch('menu','[@id=13]/model/@id[not(. < ../../model/@id)][1]');
				$new = (isset($last[0]->id)) ? (int)$last[0]->id + 1 : 1;

				$json = json_encode(array(
					'fn'=>'menu','path'=>'//item[@id=13]',
					'itm'=>array('tag'=>'model','at'=>'id','atv'=>$new,
						'lev'=>array('val'=>preg_replace('#[^A-Za-z0-9-_. ]#','',$img),'tag'=>'name')
					)
				));

				$lib->_newXML($json);
			}
			
			
			$query = 'INSERT INTO mopq(portal, bg_image, txt_color, author_color, font, author_font, font_size, author_font_size) VALUES(?, ?, ?, ?, ?, ?, ?, ?)' ;
			$stmt = $lib->pms->prepare($query);
			$stmt->bind_param("ssssiiss", $dt['title'], $img, $dt['color'], $dt['acolor'], $dt['font'], $dt['afont'], $dt['size'], $dt['asize']);
		}else{
			$query = 'INSERT INTO mopq(portal, bg_color, txt_color, author_color, font, author_font, font_size, author_font_size) VALUES(?, ?, ?, ?, ?, ?, ?, ?)' ;
			$stmt = $lib->pms->prepare($query);
			$stmt->bind_param("ssssiiss", $dt['title'], $dt['bg_color'], $dt['color'], $dt['acolor'], $dt['font'], $dt['afont'], $dt['size'], $dt['asize']);
		}
		
		if(!$stmt->execute()){
			echo(mysqli_stmt_error($stmt)) ;
		}
		
		$lib->pms->commit();
		echo 'Preset saved successfully...';
	}
	catch(Exception $e){
		$lib->pms->rollBack();
		die("There was a problem saving Preset, please try again later");
	}
	
	$lib->pms->close();
}

if(isset($_POST['MM_backgrounds']) && $_POST['MM_backgrounds'] == 'backgrounds'){
	$fold = 'assets/docs/mopq/bg/';
	$seed = rand(1,date('Y')) * rand(1,date('dm'));
	$image = (isset($_FILES['attach'])) ? $lib->uploadImages($_FILES['attach'],$fold,$seed) : array();
	
	if(count($image)>0){
		$last = $lib->fetch('menu','[@id=13]/model/@id[not(. < ../../model/@id)][1]');
		$new = (isset($last[0]->id)) ? (int)$last[0]->id + 1 : 1;

		$json = json_encode(array(
			'fn'=>'menu','path'=>'//item[@id=13]',
			'itm'=>array('tag'=>'model','at'=>'id','atv'=>$new,
				'lev'=>array('val'=>preg_replace('#[^A-Za-z0-9-_. ]#','',$image[0]),'tag'=>'name')
			)
		));

		if($lib->_newXML($json)) echo 'Background Image added successfully...';
			else echo 'There was a problem adding Image, please try again later...';
	}
}

if(isset($_POST['MM_fonts']) && $_POST['MM_fonts'] == 'font'){
	$fold = 'assets/fonts/quote_font/';
	$image = (isset($_FILES['attach'])) ? $lib->uploadImages($_FILES['attach'],$fold) : array();
	
	if(count($image)>0){
		$ftype = substr($image[0],-3);
		if($ftype == 'ttf'){
			$last = $lib->fetch('menu','[@id=12]/model/@id[not(. < ../../model/@id)][1]');
			$new = (isset($last[0]->id)) ? (int)$last[0]->id + 1 : 1;

			$json = json_encode(array(
				'fn'=>'menu','path'=>'//item[@id=12]',
				'itm'=>array('tag'=>'model','at'=>'id','atv'=>$new,
					'lev'=>array('val'=>preg_replace('#[^A-Za-z0-9-_. ]#','',$image[0]),'tag'=>'name')
				)
			));

			if($lib->_newXML($json)) echo 'Font added successfully...';
			else echo 'There was a problem adding font, please try again later...';
		}else{
			unlink($fold.$image[0]);
			echo 'The file loaded is not a TrueType Font...';
		}
	}
}
?>