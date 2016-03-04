<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Edit Competition");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addCity\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\">  ⁄œÌ· »ÿÊ·… </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM competition WHERE compID='$idGet'";
	$queryresult = mysql_query($sql)
				or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$NameAr = $row['compNameAr'];
	$NameEn = $row['compNameEn'];
	$compSys = $row['compSys'];
	$country = $row['compCountry'];
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
}

if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameAr = trim($_POST['NameAr']);
	$NameEn = $_POST['NameEn'];
	$Comp = $_POST['compList'];
	$Nation = $_POST['nation'];
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {
		include 'db_conn.php';
		$sql = "UPDATE competition SET compNameAr='$NameAr',teamNameEn='$NameEn',compSys='$Comp',compCountry='$Nation' WHERE compID='$idGet'";
		mysql_query($sql) or die (mysql_error());
		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «·»ÿÊ·… »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		echo "	<td>".$NameAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		echo "	<td>".$NameEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>‰Ÿ«„ «·»ÿÊ·…</td>\n";
		global $CompSysAr;
		echo "	<td>\n".$CompSysAr[$Comp]."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·œÊ·…</td>\n";
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
		echo "</div>\n";
		// end displaying data

		echo redirection();


		mysql_close($conn);
		// close database connection
		die("<p>You have not entered all of the required fields</p>\n");
	}
	die("<p>You have not entered all of the required fields</p>\n");
}
echo "</div>";

// making footer
echo makeFooter();

?>