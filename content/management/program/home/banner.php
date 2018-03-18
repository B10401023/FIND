<?php
	$db="banner";
	$db2="wind";
	$db3="knowledge";
	$p=by_paging_info(by_db("select count(`id`) from `$db`")->fetchColumn(0),10,$_SERVER["URL_PARAM"][2]);
	$d=by_db("select * from `$db` order by `create_time` desc limit $p[start_item],$p[page_item_num]")->fetchAll(PDO::FETCH_ASSOC);

	$w=by_db("select * from `$db2` order by `create_time` desc")->fetchAll(PDO::FETCH_ASSOC);
	$g=by_db("select * from `$db3` order by `create_time` desc")->fetchAll(PDO::FETCH_ASSOC);
	
	$butName="新增";
	$coverExists=false;
	if(isset($_SERVER["URL_PARAM"][3])==true && isset($_SERVER["URL_PARAM"][4])==false){
		$butName="編輯";
		$q=by_db("select * from `$db` where `id`=:id",array("id"=>$_SERVER["URL_PARAM"][3]))->fetch(PDO::FETCH_ASSOC);
		$q["cover"]="attachment/$db/".$q["id"];
		$coverExists=file_exists($q["cover"]);
	}
?>
<div class="row">
	<div class="col-md-12">
		<h2>Banner管理</h2>
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
							<th class="col-xs-6">Banner</th>
							<th class="col-xs-2">上傳時間</th>
							<th class="col-xs-2">描述</th>
							<th class="col-xs-2">管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><img src="<?php echo by_root_href("../attachment/$db/".$v["id"]); ?>_cover0" /></td>
							<td><?php echo $v["create_time"]; ?></td>
							<td><?php echo $v["content"]; ?></td>
							<td>
								<a href="<?php echo by_module_href($p["current_page"]."/".$v["id"]); ?>#form"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i>編輯</button></a>
								<a href="delete/?id=<?php echo $v["id"]; ?>" data-confirm="是否確定刪除？"><button type="button" class="btn btn-danger"><i class="fa fa-pencil"></i>刪除</button></a>
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
						<input name="cover" type="file" accept="image/png, image/jpeg" class="form-control" />
						<?php if($coverExists){ ?>
							<a href="<?php echo by_root_href("../".$q["cover"]); ?>" target="_blank">
								<img src="<?php echo by_root_href("../".$q["cover"]); ?>_cover0" />
							</a>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>連結來源</label>
						<input type="radio" name="link_source" data-value="<?php echo $q["link_source"]; ?>" value="wind"> 風向文章
						<input type="radio" name="link_source" data-value="<?php echo $q["link_source"]; ?>" value="knowledge"> 知識文章<br>
						<select required name="link" class="form-control" data-value="<?php echo $q["link"]; ?>">
							<optgroup label="風向文章" class="wind">
								<?php foreach ($w as $key => $value){ ?>
									<option value="<?php echo $value["id"]; ?>"><?php echo $value["title"]; ?></option>
								<?php } ?>
							</optgroup>
							<optgroup label="知識文章" class="knowledge">
								<?php foreach ($g as $key => $value){ ?>
									<option value="<?php echo $value["id"]; ?>"><?php echo $value["title"]; ?></option>
								<?php } ?>
							</optgroup>
						</select>
						<script type="text/javascript">
							$(function(){
								$("[name='link_source']").on("change",function(){
									if($(this).prop("checked")==true){
										$("[name='link'] optgroup").addClass("hidden").filter("."+$(this).val()).removeClass("hidden");
									}
								}).trigger('change');
							});
						</script>
					</div>
					<div class="form-group">
						<label>描述</label>
						<textarea name="content" style="height:200px;" class="form-control"><?php echo $q["content"]; ?></textarea>
					</div>
					<?php if($q!=false){ ?>
						<a href="../"><button type="button" class="btn btn-danger">結束編輯</button></a>
					<?php } ?>
					<button type="reset" class="btn btn-warning">重設</button>
					<button type="submit" class="btn btn-primary">儲存</button>
				</form>
				<?php echo by_inc_tpl("content/module/upload_1.php",array("p"=>$p),false); ?>
			</div>
		</div>
	</div>
</div>