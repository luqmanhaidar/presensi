<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>
<body>


<?
include "koneksi.php";
$sql= "SELECT distinct(login) FROM presensi";
$query1 = mysql_query ($sql);
$sqlrow= "SELECT distinct(Tanggal) FROM presensi";
$queryrow= mysql_query($sqlrow);
$numrow = mysql_num_rows($queryrow);
echo $numrow;

?>
<table border="1px">
	<tr>
    	<td>Nama</td>
        <?
		for ($i=1;$i<=30;$i++) {
		echo "<td>tgl".$i."</td>";
		}
		?>
    <tr>
<?
$j=0;
$index=array();
$x=0;
$arrays = array();
while ($data = mysql_fetch_array($query1,MYSQL_ASSOC)) {
	$j++;
	?>
    <tr>
    	<td><?=$data['login']?></td>
    <?
	for ($day=1;$day<=30;$day++) {
		$dhari="2009-12-".$day;
		$index[$j] = "SELECT abs FROM presensi WHERE login='".$data['login']."' AND Tanggal = '$dhari' ";
		$query_abs = mysql_query($index[$j]);
		$row = mysql_num_rows($query_abs);
		if($row == 0) {
			?><td style="background-color:#000000;"> </td><?
		} else {
			$hasil = mysql_fetch_array($query_abs,MYSQL_ASSOC);
			$hasil['abs'] == 0 ? $bg="#000000" : $bg="#FFFFFF";
			?>
			<td style="background-color:<?=$bg?>;"><?=$hasil['abs']?></td>
			<?
		}
	} //end FOR
	?></tr><?
}

?>
</table>
</body>
</html>
