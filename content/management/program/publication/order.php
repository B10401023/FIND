<?php
	$db="order_detail";
	$db2="publication_data";
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
		<h2>訂單管理</h2>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#list" data-toggle="tab">管理</a></li>
			<li class="hidden"><a href="#form" data-toggle="tab"><?php echo $butName; ?></a></li>
			<li class="hidden"><a href="#detail" data-toggle="tab"><?php echo $butName2; ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="list">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>訂購人</th>
							<th>收件人</th>
							<th>信箱</th>
							<th>管理</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($d as $k=>$v){ ?>
						<tr>
							<td><?php echo $v["order_name"]; ?></td>
							<td><?php echo $v["receive_name"]; ?></td>
							<td><?php echo $v["phone"]; ?></td>
							<td>
								<a class="hidden" href="<?php echo by_module_href($p["current_page"]."/".$v["id"]); ?>#form"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i>編輯</button></a>
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
						<label>訂單編號</label>
						<input name="order_id" type="text" value="<?php echo $q["order_id"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>訂購人</label>
						<input name="subscriber" type="text" value="<?php echo $q["subscriber"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>電話</label>
						<input name="phone" type="text" value="<?php echo $q["phone"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>信箱</label>
						<input name="email" type="text" value="<?php echo $q["email"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>金額</label>
						<input name="price" type="text" value="<?php echo $q["price"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>訂購日期</label>
						<input name="order_time" type="text" value="<?php echo $q["order_time"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>訂購方式</label>
						<input name="order_way" type="text" value="<?php echo $q["order_way"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>狀態</label>
						<input name="stage" type="text" value="<?php echo $q["stage"]; ?>" required class="form-control" />
					</div>
					<div class="form-group">
						<label>通知時間</label>
						<input name="notice" type="text" value="<?php echo $q["notice"]; ?>" required class="form-control" />
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
				<div style="padding: 10px;">
					<div class="form-group">
						<label>訂購人姓名：</label>
						<?php echo $q["order_name"]; ?><br>
						<label>收件人姓名：</label>
						<?php echo $q["receive_name"]; ?><br>
						<label>Email：</label>
						<?php echo $q["email"]; ?><br>
						<label>聯絡電話：</label>
						<?php echo $q["phone"]; ?><br>
						<label>收件地址：</label>
						<?php echo $q["address"]; ?><br>
						<label>發票抬頭：</label>
						<?php echo $q["invoice"]; ?><br>
						<label>統一編號：</label>
						<?php echo $q["ein_number"]; ?><br>
						<label>付款方式：</label>
						<?php if ($q["pay_way"]=="post"){ ?>
							郵局、銀行轉帳
						<?php }else{ ?>
							ATM轉帳
						<?php } ?><br>
						<label>帳號：</label><?php echo $q["last_5"]; ?>
					</div>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">品名</th>
							<th scope="col">單價</th>
							<th scope="col">數量</th>
							<th scope="col">小計</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$total=0;
							foreach (json_decode($q["list"]) as $key => $value){
								$d=by_db("select * from `$db2` where `id`=?",$key)->fetch();
								$price=$d["special_price"]?$d["special_price"]:$d["price"];
								$total+=$price*$value;
						?>
						<tr class="order_item">
							<th scope="row"><?php echo $key+1; ?></th>
							<td><?php echo $d["title"]; ?></td>
							<td class="price"><?php echo $price; ?></td>
							<td><?php echo $value; ?></td>
							<td class="subtotal"><?php echo $price*$value; ?></td>
						</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4">總計</th>
							<td class="order_total"><?php echo $total; ?></td>
						</tr>
					</tfoot>
				</table>
				<input name="Back" type="button" class="btn btn-primary" id="Back" onClick="javascript:history.back(1)" value="返回" />
			</div>
		</div>
	</div>
</div>