<?php
	$db="wind";
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
		<h2>風向文章</h2>
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
							<th>標題</th>
							<th>作者</th>
							<th>產業分類</th>
							<th>文章分類</th>
							<th>發布日期</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["title"]; ?></td>
							<td><?php echo $v["author"]; ?></td>
							<td><?php echo $v["industry"]; ?></td>
							<td><?php echo $v["article"]; ?></td>
							<td><?php echo $v["create_time"]; ?></td>
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
						<label>標題</label>
						<input name="title" type="text" value="<?php echo $q["title"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>作者</label>
						<input name="author" type="text" value="<?php echo $q["author"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>產業分類</label><br/>
						<label><input type="checkbox" name="industry[]" value="聯網商務" class="form-control">聯網商務</label>
						<label><input type="checkbox" name="industry[]" value="數位媒體" class="form-control">數位媒體</label>
						<label><input type="checkbox" name="industry[]" value="數位行銷" class="form-control">數位行銷</label>
						<label><input type="checkbox" name="industry[]" value="行動商務" class="form-control">行動商務</label>
						<script type="text/javascript">
							var industryArray="<?php echo $q["industry"]; ?>".split(",");
							$("[name='industry[]']").each(function(index, el) {
								if(industryArray.indexOf($(this).val())!=-1){
									$(this).attr("checked","checked");
								}
							});
						</script>
					</div>
					<div class="form-group">
						<label>文章分類</label><br/>
						<label><input type="checkbox" name="article[]" value="產業動態" class="form-control">產業動態</label>
						<label><input type="checkbox" name="article[]" value="技能觀測" class="form-control">技能觀測</label>
						<label><input type="checkbox" name="article[]" value="數據解析" class="form-control">數據解析</label>
						<label><input type="checkbox" name="article[]" value="焦點企劃" class="form-control">焦點企劃</label>
						<label><input type="checkbox" name="article[]" value="新創團隊" class="form-control">新創團隊</label>
						<script type="text/javascript">
							var articleArray="<?php echo $q["article"]; ?>".split(",");
							$("[name='article[]']").each(function(index, el) {
								if(articleArray.indexOf($(this).val())!=-1){
									$(this).attr("checked","checked");
								}
							});
						</script>
					</div>
					<div class="form-group">
						<label>內文</label>
						<textarea name="content" style="height:200px;" class="form-control editor"><?php echo $q["content"]; ?></textarea>
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
					<div class="panel-heading">內文</div>
					<div class="panel-body"><?php echo $q["content"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>
