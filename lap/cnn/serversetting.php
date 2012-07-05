<?php
if(isset($_POST['submit'])){
	$filename = 'config.php';
	$somecontent = "";
	if (!$handle = fopen($filename, 'w+')) {
		$msg = "Cannot open file ($filename)";
	}	
	$str="<?php\n\$servhost=\"".$_POST['servhost']."\";\n\$servport=".$_POST['servport'].";\n\$servusernm=\"".$_POST['servusernm']."\";\n\$servpasswd=\"".$_POST['servpasswd']."\";\n?>";
	if (fwrite($handle, $str) === FALSE) {
		$msg = "Cannot write to file ($filename)";
	}
	$msg= "Configuration Updated!";
	fclose($handle);
}

// Let's make sure the file exists and is writable first.
include "config.php";
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>Server Setting</title>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1  || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min  || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } 
document.MM_returnValue = (errors == '');
}
//-->
</script>
</head><body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="application/x-www-form-urlencoded" method="post" name="serversetting" onSubmit="MM_validateForm('servhost','','R','servport','','RisNum','servusernm','','R','servpasswd','','R');return document.MM_returnValue">
<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">
<tbody>
<?php if($msg != ""){ ?>
      <tr>
        <td colspan="3" rowspan="1"><?php echo $msg; ?></td>
      </tr>
<?php } ?>
<tr>
<td colspan="3" rowspan="1" style="width: 657px;">Mail
Server Configuration</td>
</tr>
<tr>
<td style="width: 222px;">Mail Server Host</td>
<td style="width: 9px;">:</td>
<td style="width: 657px;">
<input name="servhost" type="text" value="<?php echo $servhost;?>"></td>
</tr>
<tr>
<td style="width: 222px;">Mail Server Port</td>
<td style="width: 9px;">:</td>
<td style="width: 657px;">
<input name="servport" type="text" value="<?php echo $servport;?>"></td>
</tr>
<td style="width: 222px;">Mail Server Username</td>
<td style="width: 9px;">:</td>
<td style="width: 657px;"><input type="text" name="servusernm" value="<?php echo $servusernm;?>"></td>
</tr>
<tr>
<td style="width: 222px;">Mail Server password</td>
<td style="width: 9px;">:</td>
<td style="width: 657px;"><input type="text" name="servpasswd" value="<?php echo $servpasswd;?>"></td>
</tr><tr><td colspan="2" rowspan="1"></td><td style="width: 657px;"><input value="Reset" name="reset" type="reset" /><input value="Save" name="submit" type="Submit" /></td></tr>
</tbody>
</table></form>
<br>
</body></html>