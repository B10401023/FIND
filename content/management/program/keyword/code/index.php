<?php
	$db="keyword";
	function insert($db){
		$_POST["id"]=by_ifelse($_GET["id"],by_uniqid());
		by_db("
			insert into `$db`(`id`,`content`) values(:id,:content) 
			on duplicate key update `content`=:content",$_POST);
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