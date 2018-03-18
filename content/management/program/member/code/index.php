<?php
	$db="member";
	function insert($db){
		if($_POST["password"]==$_POST["password_check"]){
			unset($_POST["password_check"]);
			$id=$_POST["id"]=by_ifelse($_GET["id"],by_uniqid());
			by_db("
				insert into `$db`(`id`,`username`,`password`,`name`,`gender`,`birthday`,`city`,`email`) 
				values(:id,:username,md5(:password),:name,:gender,:birthday,:city,:email) on duplicate key 
				update `username`=:username,`password`=if(:password='',`password`,md5(:password)),`name`=:name,`gender`=:gender,`birthday`=:birthday,`city`=:city,`email`=:email
			",$_POST);
			if($_GET["id"]!=""){
				by_go(by_root_href(implode("/",array_slice($_SERVER["URL_PARAM"],0,3))."/"));
			}
		}
	}
	function delete($db){
		by_db("delete from `$db` where `id`=:id",$_GET);
	}
	call_user_func(array_pop($_SERVER["URL_PARAM"]),$db);
	by_go(by_root_href(implode("/",array_slice($_SERVER["URL_PARAM"],0,2))."/"));
?>