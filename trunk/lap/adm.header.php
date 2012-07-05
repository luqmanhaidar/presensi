<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistem Presensi Online Universitas Negeri Yogyakarta | Admin</title>
<link href="css/reset.css"  rel="stylesheet" type="text/css" media="all" />
<link href="css/text.css"  rel="stylesheet" type="text/css" media="all" />
<link href="css/960.css"  rel="stylesheet" type="text/css" media="all" />
<link href="css/green.css"  rel="stylesheet" type="text/css" media="all" />
<link href="ui/css/sleek/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/ui.datepicker.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
<script src="ui/jquery-1.3.2.min.js"  type="text/javascript"></script>
<script src="ui/jquery-ui-1.7.1.custom.js"  type="text/javascript"></script>
<script src="js/ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.simpletip-1.3.1.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<script src="js/components.js"  type="text/javascript"></script>
<script src="js/effects.js"  type="text/javascript"></script>
<script src="js/jquery.marque.js"  type="text/javascript"></script>
<script src="jscss/validation.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
jQuery(function($){
$(".dateinput").datepicker({dateFormat: 'yy-mm-dd'});
});
</script>

<!--[if IE 6]>
<style type="text/css" >
p.error span, p.info span, p.notice span, p.success span { 
	postion:static;
    margin-right:15px;
}
p.todoitem a.close {
	margin-right:10px;
}
button.green, button.brown {
	padding:0px !important;
}
</style>
<![endif]-->

</head>
<body>
<!-- start .grid_12 - the container -->
<div class="container_12">
	<!-- end .grid_7 - HEADER -->
	<div class="clear"></div>
   <!-- end .grid_12 - MENU -->
  <div class="grid_12" id="submenu">
	<ul>
		<li>Sistem Presensi Online Universitas Negeri Yogyakarta</li>
	</ul>	
  </div>
  <!-- end .grid_12 - SUBMENU -->
  <div class="clear"></div>
 <?php include("func_date.php"); ?>