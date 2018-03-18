<?php
	$db="news";
	function insert($db){
		$id=$_POST["id"]=by_ifelse($_GET["id"],by_uniqid());
		by_db("
			insert into `$db`(`id`,`title`,`editor`,`launch_time`,`content`) 
			values(:id,:title,:editor,:launch_time,:content) on duplicate key 
			update `title`=:title,`editor`=:editor,`launch_time`=:launch_time,`content`=:content
		",$_POST);
		if($_FILES["cover"]["tmp_name"]!=""){
			$cover="attachment/$db/".$id;
			copy($_FILES["cover"]["tmp_name"],$cover);
			imagepng(by_image_resize($cover,300),$cover."_cover0");
			imagepng(by_image_resize($cover,710),$cover."_cover1");
			imagepng(by_image_resize($cover,326,217),$cover."_cover2");
			imagepng(by_image_resize($cover,300,120),$cover."_cover3");
			imagepng(by_image_resize($cover,100,100),$cover."_cover4");
			imagepng(by_image_resize($cover,210,150),$cover."_cover5");
			imagepng(by_image_resize($cover,164,150,0x7fffffff),$cover."_cover6");
			imagepng(by_image_resize($cover,50,50,0x7fffffff),$cover."_cover7");
		}
		if($_GET["id"]!=""){
			by_go(by_root_href(implode("/",array_slice($_SERVER["URL_PARAM"],0,3))."/"));
		}
	}
	function delete($db){
		by_db("delete from `$db` where `id`=:id",$_GET);
	}
	call_user_func(array_pop($_SERVER["URL_PARAM"]),$db);
	by_go(by_root_href(implode("/",array_slice($_SERVER["URL_PARAM"],0,2))."/"));
?>