<?php
	$db="page";
	function edit($db){
		by_db("update `$db` set `contents`=:contents where `id`=:id",$_POST);
	}
	call_user_func(array_pop($_SERVER["URL_PARAM"]),$db);
	by_go(by_root_href(implode("/",$_SERVER["URL_PARAM"])."/"));
?>