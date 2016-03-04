<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Chairmen");
// insert the navigation
echo makeMenu();
$type = $_GET['Type'];
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addManager\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";

if ($type == "add") {
	$firstNameAr = "";
	$lastNameAr = "";
	$firstNameEn = "";
	$lastNameEn = "";
	$nationality = "";
	$pic = "";
	$position = "";
	$MemberTeam = "";
	echo "	<td colspan=\"2\"> ≈÷«›… ≈œ«—Ì </td>\n";
}
elseif ($type == "edit") {
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
	echo "	<td colspan=\"2\">  ⁄œÌ· ≈œ«—Ì </td>\n";
}
// start the form with an empty text box to insert the new data
echo "	</tr>\n";
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
echo makeTeamSelector("team","$MemberTeam");
echo "</td></tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['firstNameAr']) && isset($_POST['firstNameEn'])) {
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
		$outPut = "<table  class=\"mcenter\">\n";
		$outPut .= "	<tr class=\"mcenter\">\n";
		$outPut .= "	<td colspan=\"2\"> „ «÷«›… «·„œÌ— »‰Ã«Õ! </td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		$outPut .= "	<td>".$firstNameAr." ".$lastNameAr."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		$outPut .= "	<td>".$firstNameEn." ".$lastNameEn."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·Ã‰”Ì…</td>\n";
		$outPut .= nationalityAdj($Nation,"ar");
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·„‰’»</td>\n";
		global $AdminAr;
		$outPut .= "	<td>\n".$AdminAr[$Admin]."";
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>’Ê—… «·„œÌ—</td>\n";
		$outPut .= "	<td><img border=\"0\" src=\"../admins/$Pic\"></td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "</table>\n";
		// end displaying data
		$outPut .= redirection();

		if (isset($_GET['ID'])) {
			$idGet = $_GET['ID'];
			$sql = "UPDATE chairmen SET chairmanFirstNameAr='$firstNameAr',chairmanLastNameAr='$lastNameAr',chairmanFirstNameEn='$firstNameEn',
			chairmanLastNameEn='$lastNameEn',chairmanNationality='$Nation', chairmanPic='$Pic', chairmanPosition='$Admin', chairmanTeam='$team'
			WHERE chairmanID='$idGet'";
			mysql_query($sql) or die (mysql_error());
			echo $outPut;
		}
		else {
			$sqlM = "SELECT * FROM chairmen WHERE (chairmanFirstNameAr='$firstNameAr' AND chairmanLastNameAr='$lastNameAr')
		 OR (chairmanFirstNameEn='$firstNameEn' AND chairmanLastNameEn='$lastNameEn')";
			$queryresultM = mysql_query($sqlM)
				or die(mysql_error());
			$rowNum = mysql_num_rows($queryresultM);
			if ($rowNum == 0) {
				$sql = "INSERT INTO chairmen (chairmanFirstNameAr, chairmanLastNameAr, chairmanFirstNameEn, chairmanLastNameEn,
			 chairmanNationality, chairmanPic, chairmanPosition, chairmanTeam)
					values ('$firstNameAr','$lastNameAr','$firstNameEn','$lastNameEn','$Nation','$Pic','$Admin','$team')";
				mysql_query($sql) or die (mysql_error());
				echo $outPut;
			} else {
				echo "<script type=\"text/javascript\">";
				echo "alert('Â–« «·≈œ«—Ì „ÊÃÊœ „”»ﬁ«');</script>";
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