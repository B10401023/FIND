<?php
	$db="enews";
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
		<h2>電子報管理</h2>
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
							<th>電子報期數</th>
							<th>發布日期</th>
							<th>標題</th>
							<th>類別</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["period"]; ?></td>
							<td><?php echo $v["create_time"]; ?></td>
							<td><?php echo $v["title"]; ?></td>
							<td><?php echo $v["classify"]; ?></td>
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
						<label>期數</label>
						<input name="period" type="text" value="<?php echo $q["period"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>標題</label>
						<input name="title" type="text" value="<?php echo $q["title"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>副標題</label>
						<input name="subtitle" type="text" value="<?php echo $q["subtitle"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>編輯者</label>
						<input name="editor" type="text" value="<?php echo $q["editor"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>內容</label>
						<textarea name="content" style="height:200px;" class="form-control editor"><?php echo $q["content"]; ?></textarea>
					</div>
					<div class="form-group">
						<label>類別</label><br/>
						<input name="classify" type="radio" value="例行">例行<br/>
						<input name="classify" type="radio" value="活動">活動<br/>
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
					<div class="panel-heading">標題</div>
					<div class="panel-body"><?php echo $q["title"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">副標題</div>
					<div class="panel-body"><?php echo $q["subtitle"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">編輯者</div>
					<div class="panel-body"><?php echo $q["editor"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">內容</div>
					<div class="panel-body"><?php echo $q["content"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>