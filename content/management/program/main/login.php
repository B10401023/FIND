<h2>系統登入</h2>
<form id="form1" class="panel-body" action="<?php echo by_root_href("user/index/login/"); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>帳號</label>
        <input name="username" type="text" required class="form-control" />
    </div>
    <div class="form-group">
        <label>密碼</label>
        <input name="password" type="password" required class="form-control" />
    </div>
    <button type="reset" class="btn btn-warning">重設</button>
    <button type="submit" class="btn btn-primary">登入</button>
</form>