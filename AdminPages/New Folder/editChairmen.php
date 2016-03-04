<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');

// insert the header
echo makeHeader("Add Manager");
// insert the navigation
echo makeMenu();

include 'db_conn.php';
// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addManager\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\">  ⁄œÌ· ≈œ«—Ì </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM chairmen WHERE chairmanID='$idGet'";
	$queryresult = mysql_query($sql)
		or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);

	$firstNameAr = $row['chairmanFirstNameAr'];
	$lastNameAr = $row['chairmanLastNameAr'];
	$firstNameEn = $row['chairmanFirstNameEn'];
	$lastNameEn = $row['chairmanLastNameEn'];
	$nationality = $row['chairmanNationality'];
	$pic = $row['chairmanPic'];
	$position = $row['chairmanPosition'];
	$MemberTeam = $row['chairmanTeam'];

	mysql_free_result($queryresult);
	echo "	<tr>\n";
	echo "	<td>«·«”„ «·√Ê· »«·⁄—»Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"firstNameAr\" id=\"firstNameAr\" value=\"$firstNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«”„ «·⁄«∆·… »«·⁄—»Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"lastNameAr\" id=\"lastNameAr\" value=\"$lastNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·«”„ «·√Ê· »«·«‰Ã·Ì“Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"firstNameEn\" id=\"firstNameEn\" value=\"$firstNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«”„ «·⁄«∆·… »«·«‰Ã·Ì“Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"lastNameEn\" id=\"lastNameEn\" value=\"$lastNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·Ã‰”Ì…</td>\n";
	echo "	<td>\n";
	echo makeNationList("Adj","$nationality");
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·„‰’»</td>\n";
	echo "	<td>\n";
	echo makeAdmin($position);
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>’Ê—… «·„œÌ—</td>\n";
	echo "	<td><input type=\"text\" name=\"admins\" id=\"admins\" value=\"$pic\"></td>\n";
	echo " </tr>\n";
	echo "<tr><td colspan=\"2\">";
	echo getImagesJS();
	echo getImages("admins",200);
	echo "</td></tr>";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ</td>\n";
	echo "	<td>\n";
	echo makeTeamSelector("$MemberTeam");
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['firstNameAr']) && isset($_POST['firstNameEn'])) {
	$idGet = $_GET['ID'];
	$firstNameAr = trim($_POST['firstNameAr']);
	$lastNameAr = $_POST['lastNameAr'];
	$firstNameEn = trim($_POST['firstNameEn']);
	$lastNameEn = $_POST['lastNameEn'];
	$Nation = $_POST['nation'];
	$Pic = trim($_POST['admins']);
	$Admin = $_POST['adminList'];
	$team = $_POST['team'];
	// START valdate if all required fields are not empty
	if ($firstNameAr != "" && $lastNameAr != "") {
		include 'db_conn.php';
		$sql = "UPDATE chairmen SET chairmanFirstNameAr='$firstNameAr',chairmanLastNameAr='$lastNameAr',chairmanFirstNameEn='$firstNameEn',
		chairmanLastNameEn='$lastNameEn',chairmanNationality='$Nation', chairmanPic='$Pic', chairmanPosition='$Admin', chairmanTeam='$team'
		WHERE chairmanID='$idGet'";
		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «·„œÌ— »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		echo "	<td>".$firstNameAr." ".$lastNameAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		echo "	<td>".$firstNameEn." ".$lastNameEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·Ã‰”Ì…</td>\n";
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
		echo "	<tr>\n";
		echo "	<td>«·„‰’»</td>\n";
		global $AdminAr;
		echo "	<td>\n".$AdminAr[$Admin]."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>’Ê—… «·„œÌ—</td>\n";
		echo "	<td><img border=\"0\" src=\"../admins/$Pic\"></td>\n";
		echo "	</tr>\n";
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