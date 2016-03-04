<?php
// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Content");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
	echo "<div id = \"maincontent\">\n";
	echo "<form id = \"addPlayer\" action = \"\" method = \"post\">\n";
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\">  ⁄œÌ· ·«⁄» </td>\n";
	echo "	</tr>\n";
if (isset($_GET['ID'])) {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM players WHERE playerID='$idGet'";
	$queryresult = mysql_query($sql)
		or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$firstNameAr = $row['playerFirstNameAr'];
	$midNameAr = $row['playerMidNameAr'];
	$lastNameAr = $row['playerLastNameAr'];
	$firstNameEn = $row['playerFirstNameEn'];
	$midNameEn = $row['playerMidNameEn'];
	$lastNameEn = $row['playerLastNameEn'];
	$nickNameAr = $row['playerNickNameAr'];
	$nickNameEn = $row['playerNickNameEn'];

	$dob = $row['playerDOB'];
	$pob = $row['playerPOB'];
	$nationality = $row['playerNationality'];
	$height = $row['playerHeight'];
	$pic = $row['playerPic'];
	$position = $row['playerPosition'];
	$MemberTeam = $row['playerTeam'];
	$number = $row['playerNum'];

	echo "	<tr>\n";
	echo "	<td>«·«”„ «·√Ê· »«·⁄—»Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"firstNameAr\" id=\"firstNameAr\"  value=\"$firstNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«”„ «·√» »«·⁄—»Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"midNameAr\" id=\"midNameAr\"  value=\"$midNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«”„ «·⁄«∆·… »«·⁄—»Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"lastNameAr\" id=\"lastNameAr\"  value=\"$lastNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·«”„ «·„Œ ’— »«·⁄—»Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"nickNameAr\" id=\"nickNameAr\"  value=\"$nickNameAr\"></td>\n";
	echo "	</tr>\n";

	echo "	<tr>\n";
	echo "	<td>«·«”„ «·√Ê· »«·«‰Ã·Ì“Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"firstNameEn\" id=\"firstNameEn\"  value=\"$firstNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«”„ «·√» »«·«‰Ã·Ì“Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"midNameEn\" id=\"midNameEn\"  value=\"$midNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«”„ «·⁄«∆·… »«·«‰Ã·Ì“Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"lastNameEn\" id=\"lastNameEn\"  value=\"$lastNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·«”„ «·„Œ ’— »«·«‰Ã·Ì“Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"nickNameEn\" id=\"nickNameEn\"  value=\"$nickNameEn\"></td>\n";
	echo "	</tr>\n";

	echo "	<tr>\n";
	echo "	<td> «—ÌŒ «·„Ì·«œ</td>\n";
	echo "	<td><input type=\"text\" name=\"dob\" id=\"dob\"  value=\"$dob\">";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<a href=\"javascript:displayDatePicker('dob');\">";
	echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
	echo "</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>„ﬂ«‰ «·„Ì·«œ</td>\n";
	echo "	<td>\n";
	echo makeCountryListEdit($pob);
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·Ã‰”Ì…</td>\n";
	echo "	<td>\n";
	echo makeNationList("Adj","$nationality");
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·„—ﬂ“</td>\n";
	echo "	<td>\n";
	echo makePosition($position);
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·ÿÊ·</td>\n";
	echo "	<td>";
	echo makeHieght($height);
	echo"</td>\n";
	echo " </tr>\n";
	echo "	<tr>\n";
	echo "	<td>’Ê—… «··«⁄»</td>\n";
	echo "	<td><input type=\"text\" name=\"players\" id=\"players\" value=\"$pic\"></td>\n";
	echo " </tr>\n";
	echo "<tr><td colspan=\"2\">";
	echo getImagesJS();
	echo getImages("players",200);
	echo "</td></tr>";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ</td>\n";
	echo "	<td>\n";
	echo makeTeamSelector($MemberTeam);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>—ﬁ„ «·ﬁ„Ì’</td>\n";
	echo "	<td>";
	echo makePlayerNum($number);
	echo "</td></tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}
	echo "</table>\n";
	echo "</form>\n";

if (isset($_POST['firstNameAr']) && isset($_POST['firstNameEn'])) {
	$idGet = $_GET['ID'];
	$firstNameAr = trim($_POST['firstNameAr']);
	$midNameAr = trim($_POST['midNameAr']);
	$lastNameAr = trim($_POST['lastNameAr']);
	$firstNameEn = trim($_POST['firstNameEn']);
	$midNameEn = trim($_POST['midNameEn']);
	$lastNameEn = trim($_POST['lastNameEn']);
	$nickNameAr = trim($_POST['nickNameAr']);
	$nickNameEn = trim($_POST['nickNameEn']);
	$dob = trim($_POST['dob']);
	$pob = $_POST['city'];
	$Nation = $_POST['nation'];
	$hieght = trim($_POST['HieghtList']);
	$position = $_POST['positionList'];
	$Pic = trim($_POST['players']);
	$team = trim($_POST['team']);
	$playerNum = trim($_POST['PlayerNum']);

	$redirectAction = "editPlayer.php?ID=";
	$redirectAction .= $idGet;
	$redirection =  " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	$redirection .= header("location: $redirectAction") ;
	// START valdate if all required fields are not empty
	if ($firstNameAr != "" && $midNameAr != "" && $lastNameAr != "") {

		$sql = "UPDATE players SET playerFirstNameAr='$firstNameAr',playerMidNameAr='$midNameAr',playerLastNameAr='$lastNameAr',
		playerFirstNameEn='$firstNameEn',playerMidNameEn='$midNameEn',playerLastNameEn='$lastNameEn',playerNickNameAr='$nickNameAr',
		playerNickNameEn='$nickNameEn',playerDOB='$dob',playerPOB='$pob',playerNationality='$Nation',playerHeight='$hieght',
		playerPosition='$position',playerPic='$Pic', playerTeam='$team',playerNum='$playerNum'
		WHERE playerID='$idGet'";

		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «··«⁄» »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		echo "	<td>".$firstNameAr." ".$midNameAr." ".$lastNameAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		echo "	<td>".$firstNameEn." ".$midNameEn." ".$lastNameEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td> «—ÌŒ «·„Ì·«œ</td>\n";
		echo "	<td> $dob </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>„ﬂ«‰ «·„Ì·«œ</td>\n";
		$sqlCity = "SELECT * FROM city WHERE cityID='$pob'";
			$queryresultCity = mysql_query($sqlCity)
				or die(mysql_error());
			while ($rowCity = mysql_fetch_assoc($queryresultCity)) {
				$cityName = $rowCity['cityNameAr'];
				echo "	<td> $cityName";
			}
		mysql_free_result($queryresultCity);
		echo "	</td></tr>\n";
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
		echo "	<td>«·„—ﬂ“</td>\n";
		global $positionAr;
		echo "	<td>\n".$positionAr[$position]."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·ÿÊ·</td>\n";
		echo "	<td>$hieght</td>\n";
		echo " </tr>\n";
		echo "	<tr>\n";
		echo "	<td>’Ê—… «··«⁄»</td>\n";
		echo "	<td><img border=\"0\" src=\"../players/$Pic\"></td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		echo "</div>\n";
		// end displaying data
		echo $redirection;
		echo redirection();

		// close database connection
		die("<p>You have not entered all of the required fields</p>\n");
	}
	die("<p>You have not entered all of the required fields</p>\n");
}
echo "</div>";

// making footer
echo makeFooter();

?>