<?php
	$db="contact_us";
	$p=by_paging_info(by_db("select count(`id`) from `$db`")->fetchColumn(0),10,$_SERVER["URL_PARAM"][2]);
	$d=by_db("select * from `$db` order by `create_time` desc limit $p[start_item],$p[page_item_num]")->fetchAll(PDO::FETCH_ASSOC);
	
	$butName="新增";
	if(isset($_SERVER["URL_PARAM"][3])==true && isset($_SERVER["URL_PARAM"][4])==false){
		$butName="編輯";
		$q=by_db("select * from `$db` where `id`=:id",array("id"=>$_SERVER["URL_PARAM"][3]))->fetch(PDO::FETCH_ASSOC);
	}
	if(isset($_SERVER["URL_PARAM"][4])==true){
		$butName2="詳細資料";
		$q=by_db("select * from `$db` where `id`=:id",array("id"=>$_SERVER["URL_PARAM"][4]))->fetch(PDO::FETCH_ASSOC);
	}
?>
<div class="row">
	<div class="col-md-12">
		<h2>聯絡單管理</h2>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#list" data-toggle="tab">管理</a></li>
			<li class=""><a href="#form" data-toggle="tab"><?php echo $butName; ?></a></li>
			<li class="hidden"><a href="#detail" data-toggle="tab"><?php echo $butName2; ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="list">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>收件日</th>
							<th>姓名</th>
							<th>E-Mail</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["create_time"]; ?></td>
							<td><?php echo $v["name"]; ?></td>
							<td><?php echo $v["email"]; ?></td>
							<td>
								<a href="<?php echo by_module_href($p["current_page"]."/".$v["id"]); ?>#form"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i>編輯</button></a>
								<a href="delete/?id=<?php echo $v["id"]; ?>" data-confirm="是否確定刪除？"><button type="button" class="btn btn-danger"><i class="fa fa-pencil"></i>刪除</button></a>
								<a href="<?php echo by_module_href($p["current_page"]."/detail/".$v["id"]); ?>#detail"><button type="button" class="btn btn-success"><i class="fa fa-info-circle"></i>詳細資料</button></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php echo by_inc_tpl("content/module/paging_1.php",array("p"=>$p),false); ?>
			</div>
			<div class="tab-pane fade panel panel-default" id="form">
				<form id="form1" class="panel-body" action="insert/?id=<?php echo $_SERVER["URL_PARAM"][3]; ?>" method="post" enctype="multipart/form-data">
					<?php if(isset($_SERVER["URL_PARAM"][3])!=true){ ?>
					<div class="form-group">
						<label>聯絡單內容</label>
						<textarea name="content" style="height:200px;" class="form-control editor"><?php echo $q["content"]; ?></textarea>
					</div>
					<?php }else{ ?>
					<div class="form-group">
						<input name="content" type="hidden" value="<?php echo $q["content"]; ?>" />
					</div>
					<?php } ?>
					<div class="form-group">
						<label>處理結果</label>
						<input name="result" type="text" value="<?php echo $q["result"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>狀態</label>
						<input name="status" type="text" value="<?php echo $q["status"]; ?>" required class="form-control" />
					</div>
					<?php if($q!=false){ ?>
						<a href="../"><button type="button" class="btn btn-danger">結束編輯</button></a>
					<?php } ?>
					<button type="reset" class="btn btn-warning">重設</button>
					<button type="submit" class="btn btn-primary">儲存</button>
				</form>
				<?php echo by_inc_tpl("content/module/upload_1.php",array("p"=>$p),false); ?>
			</div>
			<div class="tab-pane fade panel panel-default" id="detail">
				<div class="panel panel-default">
					<div class="panel-heading">姓名</div>
					<div class="panel-body"><?php echo $q["name"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">E-Mail</div>
					<div class="panel-body"><?php echo $q["email"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">聯絡單內容</div>
					<div class="panel-body"><?php echo $q["content"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>