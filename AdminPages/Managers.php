<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Managers");
// insert the navigation
echo makeMenu();

$type = $_GET['Type'];
// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addManager\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
if ($type == "edit") {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM managers WHERE managerID='$idGet'";
	$queryresult = mysql_query($sql)
		or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$firstNameAr = $row['managerFirstNameAr'];
	$lastNameAr = $row['managerLastNameAr'];
	$firstNameEn = $row['managerFirstNameEn'];
	$lastNameEn = $row['managerLastNameEn'];
	$dob = $row['managerDOB'];
	$pob = $row['managerPOB'];
	$nationality = $row['managerNationality'];
	$Pic = $row['managerPic'];
	$position = $row['managerLevel'];
	$MemberTeam = $row['managerTeam'];
	echo "	<td colspan=\"2\">  ⁄œÌ· „œÌ— </td>\n";

}
elseif ($type == "add") {
	$firstNameAr = "";
	$lastNameAr = "";
	$firstNameEn = "";
	$lastNameEn = "";
	$dob = "";
	$pob = "";
	$nationality = "";
	$Pic = "";
	$position = "";
	$MemberTeam = "";
	echo "	<td colspan=\"2\"> ≈÷«›… „œÌ— </td>\n";

}
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
echo "	<td> «—ÌŒ «·„Ì·«œ</td>\n";
echo "	<td><input type=\"text\" name=\"dob\" id=\"dob\" value=\"$dob\">";
echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
echo "<a href=\"javascript:displayDatePicker('dob');\">";
echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
echo "</td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>„ﬂ«‰ «·„Ì·«œ</td>\n";
echo "	<td>\n";
if ($type == "edit") {
	echo makeCountryListEdit($pob);
}
elseif ($type == "add") {
	echo makeCountryList();
}
echo "<div id=\"cityList\"></div>";
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td>«·Ã‰”Ì…</td>\n";
echo "	<td>\n";
echo makeNationList("Adj",$nationality);
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td>«·„‰’»</td>\n";
echo "	<td>\n";
echo makeLevel($position);
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td>’Ê—… «·„œ—»</td>\n";
echo "	<td><input type=\"text\" name=\"managers\" id=\"managers\" value=\"$Pic\"></td>\n";
echo " </tr>\n";
echo "<tr><td colspan=\"2\">";
echo getImagesJS();
echo getImages("managers",200);
echo "</td></tr>";
echo "	<tr>\n";
echo "	<td>«·‰«œÌ</td>\n";
echo "	<td>\n";
echo makeTeamSelector("team",$MemberTeam);
echo "</td></tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['firstNameAr']) && isset($_POST['firstNameEn'])) {
	$firstNameAr = trim($_POST['firstNameAr']);
	$lastNameAr = trim($_POST['lastNameAr']);
	$firstNameEn = trim($_POST['firstNameEn']);
	$lastNameEn = trim($_POST['lastNameEn']);
	$dob = trim($_POST['dob']);
	$pob = $_POST['city'];
	$Nation = $_POST['nation'];
	$Level = $_POST['levelList'];
	$Pic = trim($_POST['managers']);
	$team = trim($_POST['team']);
	// START valdate if all required fields are not empty
	if ($firstNameAr != "" && $lastNameAr != "") {
		$outPut = "<table  class=\"mcenter\">\n";
		$outPut .= "	<tr class=\"mcenter\">\n";
		$outPut .= "	<td colspan=\"2\"> „  ⁄œÌ· «·„œÌ— »‰Ã«Õ! </td>\n";
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
		$outPut .= "	<td> «—ÌŒ «·„Ì·«œ</td>\n";
		$outPut .= "	<td> $dob </td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>„ﬂ«‰ «·„Ì·«œ</td>\n";
		$outPut .= "	<td>\n";
		$outPut .= CityNameAr($pob);
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·Ã‰”Ì…</td>\n";
		$outPut .= "	<td>\n";
		$outPut .= nationalityAdj($Nation,"ar");
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·„‰’»</td>\n";
		global $LevelAr;
		$outPut .= "	<td>\n".$LevelAr[$Level]."";
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>’Ê—… «·„œÌ—</td>\n";
		$outPut .= "	<td><img border=\"0\" src=\"../managers/$Pic\"></td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "</table>\n";
		// end displaying data
		$outPut .= redirection();
		include 'db_conn.php';
		if (isset($_GET['ID'])) {
			$idGet = $_GET['ID'];
			$sql = "UPDATE managers SET managerFirstNameAr='$firstNameAr',managerLastNameAr='$lastNameAr',managerFirstNameEn='$firstNameEn',
			managerLastNameEn='$lastNameEn',managerDOB='$dob',managerPOB='$pob',managerNationality='$Nation',
			managerPic='$Pic',managerLevel='$Level',managerTeam='$team' WHERE managerID='$idGet'";
				mysql_query($sql) or die (mysql_error());
			echo $outPut;
		}
		else {
			$sqlM = "SELECT * FROM managers WHERE (managerFirstNameAr='$firstNameAr' AND managerLastNameAr='$lastNameAr')
			 OR (managerFirstNameEn='$firstNameEn' AND managerLastNameEn='$lastNameEn')";
			$queryresultM = mysql_query($sqlM)
				or die(mysql_error());
			$rowNum = mysql_num_rows($queryresultM);
			if ($rowNum == 0) {
				$sql = "INSERT INTO managers (managerFirstNameAr, managerLastNameAr, managerFirstNameEn, managerLastNameEn,
				managerDOB, managerPOB, managerNationality, managerPic, managerLevel, managerTeam)
							values ('$firstNameAr','$lastNameAr','$firstNameEn','$lastNameEn',
								'$dob', '$pob','$Nation','$Pic','$Level','$team')";
				mysql_query($sql) or die (mysql_error());
				echo $outPut;
			} else {
				echo "<script type=\"text/javascript\">";
				echo "alert('Â–« «·„œÌ— „ÊÃÊœ „”»ﬁ«');</script>";
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