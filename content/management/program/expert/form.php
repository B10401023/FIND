<?php
	$db="expert_form";
	$db2="expert";
	$p=by_paging_info(by_db("select count(`id`) from `$db`")->fetchColumn(0),10,$_SERVER["URL_PARAM"][2]);
	$d=by_db("select * from `$db` order by `create_time` desc limit $p[start_item],$p[page_item_num]")->fetchAll(PDO::FETCH_ASSOC);
	
	$butName="新增";
	$coverExists=false;
	if(isset($_SERVER["URL_PARAM"][3])==true && isset($_SERVER["URL_PARAM"][4])==false){
		$butName="編輯";
		$q=by_db("select * from `$db` where `id`=:id",array("id"=>$_SERVER["URL_PARAM"][3]))->fetch(PDO::FETCH_ASSOC);
		$q["cover"]="attachment/$db/".$q["id"];
		$coverExists=file_exists($q["cover"]);
	}
	if(isset($_SERVER["URL_PARAM"][4])==true){
		$butName2="詳細資料";
		$q=by_db("select * from `$db` where `id`=:id",array("id"=>$_SERVER["URL_PARAM"][4]))->fetch(PDO::FETCH_ASSOC);
	}
?>
<div class="row">
	<div class="col-md-12">
		<h2>顧問服務洽詢單</h2>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#list" data-toggle="tab">管理</a></li>
			<li class="hidden"><a href="#detail" data-toggle="tab"><?php echo $butName2; ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="list">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>洽詢的顧問</th>
							<th>姓名</th>
							<th>Email</th>
							<th>聯絡電話</th>
							<th>詢問主題</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo by_db("select `name` from `$db2` where `id`=?",$v["expert_id"])->fetchColumn(0); ?></td>
							<td><?php echo $v["name"]; ?></td>
							<td><?php echo $v["email"]; ?></td>
							<td><?php echo $v["phone"]; ?></td>
							<td><?php echo $v["theme"]; ?></td>
							<td>
								<a href="delete/?id=<?php echo $v["id"]; ?>" data-confirm="是否確定刪除？"><button type="button" class="btn btn-danger"><i class="fa fa-pencil"></i>刪除</button></a>
								<a href="<?php echo by_module_href($p["current_page"]."/detail/".$v["id"]); ?>#detail"><button type="button" class="btn btn-success"><i class="fa fa-info-circle"></i>詳細資料</button></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php echo by_inc_tpl("content/module/paging_1.php",array("p"=>$p),false); ?>
			</div>
			<div class="tab-pane fade panel panel-default" id="detail">
				<div class="panel panel-default">
					<div class="panel-heading">洽詢的顧問</div>
					<div class="panel-body"><?php echo by_db("select `name` from `$db2` where `id`=?",$v["expert_id"])->fetchColumn(0); ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">姓名</div>
					<div class="panel-body"><?php echo $q["name"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Email</div>
					<div class="panel-body"><?php echo $q["email"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">聯絡電話</div>
					<div class="panel-body"><?php echo $q["phone"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">詢問主題</div>
					<div class="panel-body"><?php echo $q["theme"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">內容描述</div>
					<div class="panel-body"><?php echo $q["content"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>
