<?php
	$db="page";
	$q=by_db("select * from `$db` where `id`=:id and `type`='1'",array("id"=>$_SERVER["URL_PARAM"][2]))->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
	<div class="col-md-12">
		<h2><?php echo $q["title"]; ?></h2>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">
		<form id="form1" class="panel-body" action="edit/" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $_SERVER["URL_PARAM"][2]; ?>">
			<div class="form-group">
				<label>內容</label>
				<textarea name="contents" style="height:200px;" class="form-control editor"><?php echo $q["contents"]; ?></textarea>
			</div>
			<button type="reset" class="btn btn-warning">重設</button>
			<button type="submit" class="btn btn-primary">儲存</button>
		</form>
	</div>
</div>