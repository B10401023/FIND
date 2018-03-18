<?php
	$db="member";
	$p=by_paging_info(by_db("select count(`id`) from `$db`")->fetchColumn(0),10,$_SERVER["URL_PARAM"][2]);
	$d=by_db("select * from `$db` order by `create_time` desc limit $p[start_item],$p[page_item_num]")->fetchAll(PDO::FETCH_ASSOC);
	
	$butName="新增";
	$passwordInfo="";
	$passwordRequire=" required";
	if(isset($_SERVER["URL_PARAM"][3])==true){
		$butName="編輯";
		$passwordInfo="(不修改則留空)";
		$passwordRequire="";
		$q=by_db("select * from `$db` where `id`=:id",array("id"=>$_SERVER["URL_PARAM"][3]))->fetch(PDO::FETCH_ASSOC);
	}
?>
<div class="row">
	<div class="col-md-12">
		<h2>會員管理</h2>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#list" data-toggle="tab">管理</a></li>
			<li class=""><a href="#form" data-toggle="tab"><?php echo $butName; ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="list">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>帳號</th>
							<th>姓名</th>
							<th>註冊時間</th>
							<th>接受條款時間</th>
							<th>條款版本</th>
							<th>驗證</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["username"]; ?></td>
							<td><?php echo $v["name"]; ?></td>
							<td><?php echo $v["create_time"]; ?></td>
							<td><?php echo $v["clause_time"]; ?></td>
							<td><?php echo $v["clause_version"]; ?></td>
							<td><?php echo $v["vertify"]; ?></td>
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
						<label>帳號</label>
						<input name="username" type="text" value="<?php echo $q["username"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>密碼<?php echo $passwordInfo; ?></label>
						<input name="password" type="password"<?php echo $passwordRequire; ?> class="form-control" />
					</div>
					<div class="form-group">
						<label>確認密碼</label>
						<input name="password_check" type="password"<?php echo $passwordRequire; ?> class="form-control" />
					</div>
					<div class="form-group">
						<label>姓名</label>
						<input name="name" type="text" value="<?php echo $q["name"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>性別</label><br/>
						<input name="gender" type="radio" id="m" value="male">Male<br/>
						<input name="gender" type="radio" id="f" value="female">Female<br/>
						<script>
							$("[value='<?php echo $q["gender"]; ?>']").prop("checked", true);
						</script>
					</div>
					<div class="form-group">
						<label>生日</label>
						<input name="birthday" type="text" value="<?php echo $q["birthday"]; ?>" required class="form-control datepicker" />
					</div>
					<div class="form-group">
						<label>居住地</label>
						<select name="city" class="form-control">
							<option value="基隆市">基隆市</option>
							<option value="臺北市">臺北市</option>
							<option value="新北市">新北市</option>
							<option value="桃園市">桃園市</option>
							<option value="新竹縣">新竹縣</option>
							<option value="新竹市">新竹市</option>
							<option value="苗栗縣">苗栗縣</option>
							<option value="臺中市">臺中市</option>
							<option value="南投縣">南投縣</option>
							<option value="彰化縣">彰化縣</option>
							<option value="雲林縣">雲林縣</option>
							<option value="嘉義縣">嘉義縣</option>
							<option value="嘉義市">嘉義市</option>
							<option value="臺南市">臺南市</option>
							<option value="高雄市">高雄市</option>
							<option value="屏東縣">屏東縣</option>
							<option value="宜蘭縣">宜蘭縣</option>
							<option value="花蓮縣">花蓮縣</option>
							<option value="臺東縣">臺東縣</option>
							<option value="澎湖縣">澎湖縣</option>
							<option value="金門縣">金門縣</option>
							<option value="連江縣">連江縣</option>
						</select>
						<script type="text/javascript">
							$("[name='city']").val("<?php echo $q["city"]; ?>");
						</script>
					</div>
					<div class="form-group">
						<label>E-Mail</label>
						<input name="email" type="text" value="<?php echo $q["email"]; ?>" required class="form-control" />
					</div>
					<?php if($q!=false){ ?>
						<a href="../"><button type="button" class="btn btn-danger">結束編輯</button></a>
					<?php } ?>
					<button type="reset" class="btn btn-warning">重設</button>
					<button type="submit" class="btn btn-primary">儲存</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$("#form1").on("submit",function(){
		if($(this).find("[name='password']").val()!=$(this).find("[name='password_check']").val()){
			window.alert("密碼與確認密碼不一樣！");
			return false;
		}
	});
</script>