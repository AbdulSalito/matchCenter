<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Competition");
// insert the navigation
echo makeMenu();

$type = $_GET['Type'];

// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addCity\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
if ($type == "edit") {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM competition WHERE compID='$idGet'";
	$queryresult = mysql_query($sql)
				or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$NameAr = $row['compNameAr'];
	$NameEn = $row['compNameEn'];
	$compSys = $row['compSys'];
	$country = $row['compCountry'];
	echo "	<td colspan=\"2\">  ⁄œÌ· »ÿÊ·… </td>\n";
}
elseif ($type == "add") {
	$NameAr = "";
	$NameEn = "";
	$compSys = "";
	$country = "";
	echo "	<td colspan=\"2\"> ≈÷«›… »ÿÊ·… </td>\n";
}

echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·⁄—»Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameAr\" id=\"NameAr\" value=\"$NameAr\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·«‰Ã·Ì“Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameEn\" id=\"NameEn\" value=\"$NameEn\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>‰Ÿ«„ «·»ÿÊ·…</td>\n";
echo "	<td>\n";
echo makeCompSys($compSys);
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td>«·œÊ·…</td>\n";
echo "	<td>\n";
echo makeNationList("Name",$country);
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";


if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameAr = trim($_POST['NameAr']);
	$NameEn = $_POST['NameEn'];
	$Comp = $_POST['compList'];
	$Nation = $_POST['nation'];
	include 'db_conn.php';
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {
		$outPut = "<table  class=\"mcenter\">\n";
		$outPut .= "	<tr class=\"mcenter\">\n";
		$outPut .= "	<td colspan=\"2\"> „  ⁄œÌ· «·»ÿÊ·… »‰Ã«Õ! </td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		$outPut .= "	<td>".$NameAr."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		$outPut .= "	<td>".$NameEn."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>‰Ÿ«„ «·»ÿÊ·…</td>\n";
		global $CompSysAr;
		$outPut .= "	<td>\n".$CompSysAr[$Comp]."";
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·œÊ·…</td>\n<td>";
		$outPut .= NationalityAdj($Nation,"ar");
		$outPut .= "	</td></tr>\n";
		$outPut .= "</table>\n";
		$outPut .= redirection();

		if (isset($_GET['ID'])) {
			$idGet = $_GET['ID'];
			$sql = "UPDATE competition SET compNameAr='$NameAr',compNameEn='$NameEn',compSys='$Comp',compCountry='$Nation' WHERE compID='$idGet'";
			mysql_query($sql) or die (mysql_error());
			echo $outPut;
		}
		else {
			$sqlM = "SELECT * FROM competition WHERE compNameAr='$NameAr' OR compNameEn='$NameEn'";
			$queryresultM = mysql_query($sqlM)
				or die(mysql_error());
			$rowNum = mysql_num_rows($queryresultM);
			if ($rowNum == 0) {
				$sql = "INSERT INTO competition (compNameAr, compNameEn, compSys, compCountry)
							values ('$NameAr','$NameEn', '$Comp','$Nation')";
				mysql_query($sql) or die (mysql_error());
				echo $outPut;
			} else {
				echo "<script type=\"text/javascript\">";
				echo "alert('Â–Â «·»ÿÊ·… „ÊÃÊœ… „”»ﬁ«');</script>";
			}
		}
		// displaying the inserted data as a confirmation
		mysql_close($conn);
		// close database connection
	}
}
echo "</div>";

// making footer
echo makeFooter();

?>