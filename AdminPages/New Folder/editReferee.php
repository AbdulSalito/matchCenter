<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("edit Referee");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addReferee\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\"> ����� ��� </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM referee WHERE refereeID='$idGet'";
	$queryresult = mysql_query($sql)
						or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$firstNameAr = $row['refereeFirstNameAr'];
	$lastNameAr = $row['refereeLastNameAr'];
	$firstNameEn = $row['refereeFirstNameEn'];
	$lastNameEn = $row['refereeLastNameEn'];
	$nation = $row['refereeNationality'];
	$dob = $row['refereeDOB'];
	$refList = $row['refereeType'];
	$pic = $row['refereePic'];
	echo "	<tr>\n";
	echo "	<td>����� ����� �������</td>\n";
	echo "	<td><input type=\"text\" name=\"FirstNameAr\" id=\"FirstNameAr\" value=\"$firstNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>��� ������� �������</td>\n";
	echo "	<td><input type=\"text\" name=\"LastNameAr\" id=\"LastNameAr\" value=\"$lastNameAr\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>����� ����� ����������</td>\n";
	echo "	<td><input type=\"text\" name=\"FirstNameEn\" id=\"FirstNameEn\" value=\"$firstNameEn\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>��� ������� ����������</td>\n";
	echo "	<td><input type=\"text\" name=\"LastNameEn\" id=\"LastNameEn\" value=\"$lastNameEn\"></td>\n";
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
	echo "	<td>�������</td>\n";
	echo "	<td>";
	echo makeNationList("Adj",$nation);
	echo " </td>\n</tr>\n";
	echo "	<tr>\n";
	echo "	<td>�����</td>\n";
	echo "	<td>\n";
	echo makeRefList($refList);
	echo "	</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>���� �����</td>\n";
	echo "	<td><input type=\"text\" name=\"Pic\" id=\"Pic\" value=\"$pic\"></td>\n";
	echo " </tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
}

if (isset($_POST['FirstNameAr']) && isset($_POST['FirstNameEn'])) {
	$firstNameAr = trim($_POST['FirstNameAr']);
	$lastNameAr = trim($_POST['LastNameAr']);
	$firstNameEn = trim($_POST['FirstNameEn']);
	$lastNameEn = trim($_POST['LastNameEn']);
	$dob = $_POST['dob'];
	$nation = $_POST['nation'];
	$refList = $_POST['refList'];
	$Pic = $_POST['Pic'];
	// START valdate if all required fields are not empty
	if ($firstNameEn != "" && $firstNameAr != "") {
		include 'db_conn.php';
		$sql = "UPDATE referee SET refereeFirstNameAr='$firstNameAr',refereeLastNameAr='$lastNameAr',refereeFirstNameEn='$firstNameEn',refereeLastNameEn='$lastNameEn',
		refereeDOB='$dob', refereeNationality='$nation', refereeType='$refList', refereePic='$Pic' WHERE refereeID='$idGet'";
		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\">�� ����� ����� �����! </td>\n";
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
		echo "	<td>$dob</td>\n";
		echo " </tr>\n";
		echo "	<tr>\n";
		echo "	<td>�������</td>\n";
		$sqlNation = "SELECT * FROM nationality WHERE nationalityID='$nation'";
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
		echo "	<td>�����</td>\n";
		global $refClassAr;
		echo "	<td>\n".$refClassAr[$refList]."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>���� �����</td>\n";
		echo "	<td><img border=\"0\" src=\"../players/$Pic\"></td>\n";
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