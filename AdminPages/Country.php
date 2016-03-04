<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Country");
// insert the navigation
echo makeMenu();

$type = $_GET['Type'];
// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addCountry\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
if ($type == "edit") {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM nationality WHERE nationalityID='$idGet'";
	$queryresult = mysql_query($sql)
				or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$NameEn = $row['nationalityNameEn'];
	$AdjEn = $row['nationalityAdjEn'];
	$NameAr = $row['nationalityNameAr'];
	$AdjAr = $row['nationalityAdjAr'];
	$flag = $row['nationalityFlag'];
	echo "	<td colspan=\"2\">  ⁄œÌ· œÊ·… </td>\n";

}
elseif ($type == "add") {
	$NameEn = "";
	$AdjEn = "";
	$NameAr = "";
	$AdjAr = "";
	$flag = "";
	echo "	<td colspan=\"2\"> ≈÷«›… œÊ·… </td>\n";

}
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·⁄—»Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameAr\" id=\"NameAr\" value=\"$NameAr\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·’›… »«·⁄—»Ì</td>\n";
echo "	<td><input type=\"text\" name=\"AdjAr\" id=\"AdjAr\" value=\"$AdjAr\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·«‰Ã·Ì“Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameEn\" id=\"NameEn\" value=\"$NameEn\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·’›… »«·«‰Ã·Ì“Ì</td>\n";
echo "	<td><input type=\"text\" name=\"AdjEn\" id=\"AdjEn\" value=\"$AdjEn\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>⁄·„ «·œÊ·…</td>\n";
echo "	<td><input type=\"text\" name=\"flags\" id=\"flags\" value=\"$flag\"></td>\n";
echo " </tr>\n";
echo "	<tr>\n";
echo getImagesJS();
echo "	<td colspan=\"2\">";
echo getImages("flags",100);
echo "</td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameEn = trim($_POST['NameEn']);
	$AdjEn = trim($_POST['AdjEn']);
	$NameAr = trim($_POST['NameAr']);
	$AdjAr = trim($_POST['AdjAr']);
	$flag = $_POST['flags'];
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {
		include 'db_conn.php';
		$outPut = "<table  class=\"mcenter\">\n";
		$outPut .= "	<tr class=\"mcenter\">\n";
		$outPut .= "	<td colspan=\"2\"> „  ⁄œÌ· «·œÊ·… »‰Ã«Õ! </td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		$outPut .= "	<td>".$NameAr."-".$AdjAr."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		$outPut .= "	<td>".$NameEn."-".$AdjEn."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·œÊ·…</td>\n";
		$outPut .= "	<td><img border=\"0\" src=\"../flags/$flag\">";
		$outPut .= "	</td></tr>\n";
		$outPut .= "</table>\n";
		// end displaying data
		$outPut .= redirection();
		if (isset($_GET['ID'])) {
			$idGet = $_GET['ID'];
			$sql = "UPDATE nationality SET nationalityNameEn='$NameEn',nationalityAdjEn='$AdjEn',nationalityNameAr='$NameAr',
		nationalityAdjAr='$AdjAr', nationalityFlag='$flag' WHERE nationalityID='$idGet'";
			mysql_query($sql) or die (mysql_error());
			echo $outPut;
		}
		else {
			$sqlM = "SELECT * FROM nationality WHERE (nationalityNameAr='$NameAr' OR nationalityAdjAr='$AdjAr')
			 OR (nationalityNameEn='$NameEn' OR nationalityAdjEn='$AdjEn')";
			$queryresultM = mysql_query($sqlM)
				or die(mysql_error());
			$rowNum = mysql_num_rows($queryresultM);
			if ($rowNum == 0) {
				$sql = "INSERT INTO nationality (nationalityNameEn, nationalityAdjEn, nationalityNameAr, nationalityAdjAr, nationalityFlag)
							values ('$NameEn','$AdjEn','$NameAr','$AdjAr','$flag')";
				mysql_query($sql) or die (mysql_error());
				echo $outPut;
			} else {
				echo "<script type=\"text/javascript\">";
				echo "alert('Â–Â  «·œÊ·… „ÊÃÊœÂ „”»ﬁ«');</script>";
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