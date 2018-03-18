<?php
	$db="orders";
	function insert($db){
		$_POST["id"]=by_ifelse($_GET["id"],by_uniqid());
		by_db("insert into `$db`(`id`,`order_id`,`subscriber`,`phone`,`email`,`price`,`order_time`,`order_way`,`stage`,`notice`) values(:id,:order_id,:subscriber,:phone,:email,:price,:order_time,:order_way,:stage,:notice) on duplicate key update `order_id`=:order_id,`subscriber`=:subscriber,`phone`=:phone,`email`=:email,`price`=:price,`order_time`=:order_time,`order_way`=:order_way,`stage`=:stage,`notice`=:notice",$_POST);
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