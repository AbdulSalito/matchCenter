<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Edit Country");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addCountry\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\">  ⁄œÌ· œÊ·… </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
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
	echo getImages("flags",50);
	echo "</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
}

if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameEn = trim($_POST['NameEn']);
	$AdjEn = trim($_POST['AdjEn']);
	$NameAr = trim($_POST['NameAr']);
	$AdjAr = trim($_POST['AdjAr']);
	$flag = $_POST['flag'];
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {

		include 'db_conn.php';
		$sql = "UPDATE nationality SET nationalityNameEn='$NameEn',nationalityAdjEn='$AdjEn',nationalityNameAr='$NameAr',
		nationalityAdjAr='$AdjAr', nationalityFlag='$flag' WHERE nationalityID='$idGet'";
		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «·œÊ·… »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		echo "	<td>".$NameAr."-".$AdjAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		echo "	<td>".$NameEn."-".$AdjEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·œÊ·…</td>\n";
		echo "	<td><img border=\"0\" src=\"../flags/$flag\">";
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