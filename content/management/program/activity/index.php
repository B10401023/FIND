<?php
	$db="activity";
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
		<h2>活動資訊管理</h2>
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
							<th>活動分類</th>
							<th>活動名稱</th>
							<th>主辦單位</th>
							<th>發布單位</th>
							<th>活動期間-開始</th>
							<th>活動期間-結束</th>
							<th>活動狀態</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["category"]; ?></td>
							<td><?php echo $v["title"]; ?></td>
							<td><?php echo $v["host"]; ?></td>
							<td><?php echo $v["unit"]; ?></td>
							<td><?php echo $v["start_time"]; ?></td>
							<td><?php echo $v["end_time"]; ?></td>
							<td><?php echo $v["stage"]; ?></td>
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
								<img src="<?php echo by_root_href("../".$q["cover"]."_cover0"); ?>" />
							</a>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>活動編碼</label>
						<input name="code" type="text" value="<?php echo $q["code"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>活動分類</label>
						<select name="category" data-value="<?php echo $q["category"]; ?>" required class="form-control">
							<option value="活動">活動</option>
							<option value="研討會">研討會</option>
							<option value="課程">課程</option>
						</select>
					</div>
					<div class="form-group">
						<label>活動名稱</label>
						<input name="title" type="text" value="<?php echo $q["title"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>主辦單位</label>
						<input name="host" type="text" value="<?php echo $q["host"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>活動聯絡人</label>
						<input name="contact" type="text" value="<?php echo $q["contact"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>發布單位</label>
						<input name="unit" type="text" value="<?php echo $q["unit"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>活動期間-開始</label>
						<input name="start_time" type="text" value="<?php echo $q["start_time"]; ?>" required class="form-control datetimepicker" />
					</div>
					<div class="form-group">
						<label>活動期間-結束</label>
						<input name="end_time" type="text" value="<?php echo $q["end_time"]; ?>" required class="form-control datetimepicker" />
					</div>
					<div class="form-group">
						<label>報名連結</label>
						<input name="link" type="text" value="<?php echo $q["link"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>活動介紹</label>
						<textarea name="introduction" style="height:200px;" class="form-control editor"><?php echo $q["introduction"]; ?></textarea>
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
					<div class="panel-heading">活動介紹</div>
					<div class="panel-body"><?php echo $q["introduction"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">活動期間-開始</div>
					<div class="panel-body"><?php echo $q["start_time"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">活動期間-結束</div>
					<div class="panel-body"><?php echo $q["end_time"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">報名連結</div>
					<div class="panel-body"><?php echo $q["link"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>