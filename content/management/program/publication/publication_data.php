<?php
	$db="publication_data";
	$dbCategory="publication_category";
	$p=by_paging_info(by_db("select count(`id`) from `$db`")->fetchColumn(0),10,$_SERVER["URL_PARAM"][2]);
	$d=by_db("select * from `$db` order by `create_time` desc limit $p[start_item],$p[page_item_num]")->fetchAll(PDO::FETCH_ASSOC);
	
	$g=by_db("select * from `$dbCategory` order by `create_time` desc")->fetchAll(PDO::FETCH_ASSOC);
	
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
		<h2>出版品管理</h2>
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
							<th>書名</th>
							<th>書籍分類</th>
							<th>書籍編碼</th>
							<th>總編輯</th>
							<th>作者</th>
							<th>出版單位</th>
							<th>出版日期</th>
							<th>定價</th>
							<th>特價</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["title"]; ?></td>
							<td><?php echo $v["category"]; ?></td>
							<td><?php echo $v["code"]; ?></td>
							<td><?php echo $v["editor"]; ?></td>
							<td><?php echo $v["author"]; ?></td>
							<td><?php echo $v["publisher"]; ?></td>
							<td><?php echo $v["publish_date"]; ?></td>
							<td><?php echo $v["price"]; ?></td>
							<td><?php echo $v["special_price"]; ?></td>
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
						<label>書名</label>
						<input name="title" type="text" value="<?php echo $q["title"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>書籍分類</label>
						<select name="category" class="form-control">
							<?php foreach($g as $k=>$c){ ?>
							<option value="<?php echo $c["id"]; ?>"><?php echo $c["category"]; ?></option>
							<?php } ?>
						</select>
						<script type="text/javascript">
							$("[name='category']").val("<?php echo $q["category"]; ?>");
						</script>
					</div>
					<div class="form-group">
						<label>書籍編碼</label>
						<input name="code" type="text" value="<?php echo $q["code"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>總編輯</label>
						<select name="editor" class="form-control">
							<option value="總編輯1">總編輯1</option>
							<option value="總編輯2">總編輯2</option>
							<option value="總編輯3">總編輯3</option>
							<option value="總編輯4">總編輯4</option>
						</select>
						<script type="text/javascript">
							$("[name='editor']").val("<?php echo $q["editor"]; ?>");
						</script>
					</div>
					<div class="form-group">
						<label>作者</label>
						<input name="author" type="text" value="<?php echo $q["author"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>出版單位</label>
						<input name="publisher" type="text" value="<?php echo $q["publisher"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>出版日期</label>
						<input name="publish_date" type="date" value="<?php echo $q["publish_date"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>定價</label>
						<input name="price" type="text" value="<?php echo $q["price"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>特價</label>
						<input name="special_price" type="text" value="<?php echo $q["special_price"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>ISBN</label>
						<input name="ISBN" type="text" value="<?php echo $q["ISBN"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>頁數</label>
						<input name="page" type="text" value="<?php echo $q["page"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>規格</label>
						<input name="format" type="text" value="<?php echo $q["format"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>出版地</label>
						<input name="place" type="text" value="<?php echo $q["place"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>書籍簡介</label>
						<textarea name="introduction" style="height:200px;" class="form-control editor"><?php echo $q["introduction"]; ?></textarea>
					</div>
					<div class="form-group">
						<label>本書目錄</label>
						<textarea name="menu" style="height:200px;" class="form-control editor"><?php echo $q["menu"]; ?></textarea>
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
					<div class="panel-heading">ISBN</div>
					<div class="panel-body"><?php echo $q["ISBN"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">頁數</div>
					<div class="panel-body"><?php echo $q["page"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">規格</div>
					<div class="panel-body"><?php echo $q["format"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">出版地</div>
					<div class="panel-body"><?php echo $q["place"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">書籍簡介</div>
					<div class="panel-body"><?php echo $q["introduction"]; ?></div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">本書目錄</div>
					<div class="panel-body"><?php echo $q["menu"]; ?></div>
				</div>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>