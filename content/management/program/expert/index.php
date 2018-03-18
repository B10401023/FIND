<?php
	$db="expert";
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
		<h2>FIND專家庫</h2>
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
							<th class="col-sm-3">照片</th>
							<th class="col-sm-2">姓名</th>
							<th class="col-sm-3">專長領域</th>
							<th class="col-sm-4">管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><img src="<?php echo by_root_href("../attachment/$db/".$v["id"]."_cover6"); ?>" /></td>
							<td><?php echo $v["name"]; ?></td>
							<td><?php echo $v["expertise"]; ?></td>
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
					<div class="form-group">
						<label>封面圖</label>
						<input name="cover" type="file" accept="image/png, image/jpeg" class="form-control"<?php echo $coverExists?"":" required"; ?> />
						<?php if($coverExists){ ?>
							<a href="<?php echo by_root_href("../".$q["cover"]); ?>" target="_blank">
								<img src="<?php echo by_root_href("../".$q["cover"]."_cover6"); ?>" />
							</a>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>姓名</label>
						<input name="name" type="text" value="<?php echo $q["name"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>專長領域</label>
						<input name="expertise" type="text" value="<?php echo $q["expertise"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>經歷</label>
						<textarea name="experience" style="height:200px;" class="form-control editor"><?php echo $q["experience"]; ?></textarea>
					</div>
					<div class="form-group">
						<label>簡介</label>
						<textarea name="intro" style="height:200px;" class="form-control editor"><?php echo $q["intro"]; ?></textarea>
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
					<div class="panel-heading">專長領域</div>
					<div class="panel-body"><?php echo $q["expertise"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">經歷</div>
					<div class="panel-body"><?php echo $q["experience"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">簡介</div>
					<div class="panel-body"><?php echo $q["intro"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>