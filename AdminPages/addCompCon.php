<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>non</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');

if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameAr = trim($_POST['NameAr']);
	$NameEn = $_POST['NameEn'];
	$Comp = $_POST['compList'];
	$Nation = $_POST['nation'];
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {

		include 'db_conn.php';
		$sql = "INSERT INTO competition (compNameAr, compNameEn, compSys, compCountry)
							values ('$NameAr','$NameEn', '$Comp','$Nation')";
		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\">تم اضافة المدينة بنجاح! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>الاسم  بالعربي</td>\n";
		echo "	<td>".$NameAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>الاسم  بالانجليزي</td>\n";
		echo "	<td>".$NameEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>نظام البطولة</td>\n";
		global $CompSysAr;
		echo "	<td>\n".$CompSysAr[$Comp]."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>الدولة</td>\n";
		$sqlNation = "SELECT * FROM nationality WHERE nationalityID='$Nation'";
		$queryresultNation = mysql_query($sqlNation)
		or die(mysql_error());
		while ($rowNation = mysql_fetch_assoc($queryresultNation)) {
			$NatioName = $rowNation['nationalityAdjAr'];
			$NatioFlag = $rowNation['nationalityFlag'];
			echo "	<td>$NatioName <img border=\"0\" src=\"../flags/$NatioFlag\">";
		}
		mysql_free_result($queryresultNation);
		echo "	</td></tr>\n";
		echo "</table>\n";
		//		echo "</div>\n";
		// end displaying data

		echo redirection();


		mysql_close($conn);
		// close database connection
		die("<p>You have not entered all of the required fields</p>\n");
	}
	die("<p>You have not entered all of the required fields</p>\n");
}

?>
	</body>
</html>