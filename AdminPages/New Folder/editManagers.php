<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Edit Manager");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addManager\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\"> ����� ���� </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
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
	echo "	<tr>\n";
	echo "	<td>����� ����� �������</td>\n";
	echo "	<td><input type=\"text\" name=\"firstNameAr\" id=\"firstNameAr\" value=\"$firstNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>��� ������� �������</td>\n";
	echo "	<td><input type=\"text\" name=\"lastNameAr\" id=\"lastNameAr\" value=\"$lastNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>����� ����� ����������</td>\n";
	echo "	<td><input type=\"text\" name=\"firstNameEn\" id=\"firstNameEn\" value=\"$firstNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>��� ������� ����������</td>\n";
	echo "	<td><input type=\"text\" name=\"lastNameEn\" id=\"lastNameEn\" value=\"$lastNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>����� �������</td>\n";
	echo "	<td><input type=\"text\" name=\"dob\" id=\"dob\" value=\"$dob\">";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<a href=\"javascript:displayDatePicker('dob');\">";
	echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
	echo "</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>���� �������</td>\n";
	echo "	<td>\n";
	echo makeCountryListEdit($pob);
	echo "<div id=\"cityList\"></div>";
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>�������</td>\n";
	echo "	<td>\n";
	echo makeNationList("Adj",$nationality);
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>������</td>\n";
	echo "	<td>\n";
	echo makeLevel($position);
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>���� ������</td>\n";
	echo "	<td><input type=\"text\" name=\"managers\" id=\"managers\" value=\"$Pic\"></td>\n";
	echo " </tr>\n";
	echo "<tr><td colspan=\"2\">";
	echo getImagesJS();
	echo getImages("managers",200);
	echo "</td></tr>";
	echo "	<tr>\n";
	echo "	<td>������</td>\n";
	echo "	<td>\n";
	echo makeTeamSelector($MemberTeam);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}
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

		include 'db_conn.php';
		$sql = "UPDATE managers SET managerFirstNameAr='$firstNameAr',managerLastNameAr='$lastNameAr',managerFirstNameEn='$firstNameEn',
		managerLastNameEn='$lastNameEn',managerDOB='$dob',managerPOB='$pob',managerNationality='$Nation',
		managerPic='$Pic',managerLevel='$Level',managerTeam='$team' WHERE playerID='$idGet'";

		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\">�� ����� ������ �����! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>�����  �������</td>\n";
		echo "	<td>".$firstNameAr." ".$lastNameAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>�����  ����������</td>\n";
		echo "	<td>".$firstNameEn." ".$lastNameEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>����� �������</td>\n";
		echo "	<td> $dob </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>���� �������</td>\n";
		include 'db_conn.php';
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
		echo "	<td>�������</td>\n";
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
		echo "	<td>������</td>\n";
		global $LevelAr;
		echo "	<td>\n".$LevelAr[$Level]."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>���� ������</td>\n";
		echo "	<td><img border=\"0\" src=\"../managers/$Pic\"></td>\n";
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