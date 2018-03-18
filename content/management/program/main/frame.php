<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="expires" content="Mon, 22 Jul 2002 11:12:01 GMT">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Find</title>
	<link href="<?php echo by_root_href("resource/css/bootstrap.css"); ?>" rel="stylesheet" />
	<link href="<?php echo by_root_href("resource/css/font-awesome.css"); ?>" rel="stylesheet" />
	<link href="<?php echo by_root_href("resource/css/custom.css"); ?>" rel="stylesheet" />
	<link href="<?php echo by_root_href("resource/css/chosen.css"); ?>" rel="stylesheet" />
	<link href="<?php echo by_root_href("resource/jquery-ui-1.12.1.custom/jquery-ui.min.css"); ?>" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<script src="<?php echo by_root_href("resource/js/jquery-1.10.2.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/js/bootstrap.min.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/js/tinymce/tinymce.min.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/js/base.js"); ?>" id="baseJS"></script>
	<script src="<?php echo by_root_href("resource/js/chosen.jquery.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/highcharts/highcharts.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/highcharts/modules/exporting.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/jquery-ui-1.12.1.custom/jquery-ui.min.js"); ?>"></script>
	<script src="<?php echo by_root_href("resource/jquery-ui-1.12.1.custom/jquery-ui-timepicker-addon.js"); ?>"></script>
	<?php if ($_SESSION["info"]){ ?>
		<script type="text/javascript">
		window.alert("<?php
			echo $_SESSION["info"];
			unset($_SESSION["info"]);
		?>");
		</script>
	<?php } ?>
</head>
<body>
<div id="wrapper">
	<?php if ($_SESSION["user"]){ ?>
		<?php echo $header; ?>
		<?php echo $nav; ?>
		<div id="page-wrapper">
			<div id="page-inner">
				<?php echo $content; ?>
			</div>
		</div>
	<?php }else{ ?>
		<div id="page-wrapper col-xs-12">
			<div id="page-inner">
				<?php echo $login; ?>
			</div>
		</div>
	<?php } ?>
</div>
<!--
<script src="<?php echo by_root_href("resource/js/jquery.metisMenu.js"); ?>"></script>
<script src="<?php echo by_root_href("resource/js/dataTables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo by_root_href("resource/js/dataTables/dataTables.bootstrap.js"); ?>"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
</script>
<script src="<?php echo by_root_href("resource/js/custom.js"); ?>"></script>
-->
</body>
</html>