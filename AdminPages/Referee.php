<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("edit Referee");
// insert the navigation
echo makeMenu();

$type = $_GET['Type'];
// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addReferee\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
if ($type == "edit") {
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
	echo "	<td colspan=\"2\"> ����� ��� </td>\n";
}
elseif ($type == "add") {
	$firstNameAr = "";
	$lastNameAr = "";
	$firstNameEn = "";
	$lastNameEn = "";
	$nation = "";
	$dob = "";
	$refList = "";
	$pic = "";
	echo "	<td colspan=\"2\"> ����� ��� </td>\n";
}
echo "	</tr>\n";
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
		$outPut = "<table  class=\"mcenter\">\n";
		$outPut .= "	<tr class=\"mcenter\">\n";
		$outPut .= "	<td colspan=\"2\">�� ����� ����� �����! </td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>�����  �������</td>\n";
		$outPut .= "	<td>".$firstNameAr." ".$lastNameAr."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>�����  ����������</td>\n";
		$outPut .= "	<td>".$firstNameEn." ".$lastNameEn."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>����� �������</td>\n";
		$outPut .= "	<td>$dob</td>\n";
		$outPut .= " </tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>�������</td>\n<td>";
		$outPut .= NationalityAdj($nation,"ar");
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>�����</td>\n";
		global $refClassAr;
		$outPut .= "	<td>\n".$refClassAr[$refList]."";
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>���� �����</td>\n";
		$outPut .= "	<td><img border=\"0\" src=\"../referee/$Pic\"></td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "</table>\n";
		$outPut .= redirection();
		if (isset($_GET['ID'])) {
			$idGet = $_GET['ID'];
			$sql = "UPDATE referee SET refereeFirstNameAr='$firstNameAr',refereeLastNameAr='$lastNameAr',refereeFirstNameEn='$firstNameEn',
			refereeLastNameEn='$lastNameEn',refereeDOB='$dob', refereeNationality='$nation', refereeType='$refList', refereePic='$Pic'
			WHERE refereeID='$idGet'";
				mysql_query($sql) or die (mysql_error());
			echo $outPut;
		}
		else {
			$sqlM = "SELECT * FROM referee WHERE (refereeFirstNameAr='$firstNameAr' AND refereeLastNameAr='$lastNameAr')
			 OR (refereeFirstNameEn='$firstNameEn' AND refereeLastNameEn='$lastNameEn')";
			$queryresultM = mysql_query($sqlM)
				or die(mysql_error());
			$rowNum = mysql_num_rows($queryresultM);
			if ($rowNum == 0) {
				$sql = "INSERT INTO referee (refereeFirstNameAr, refereeLastNameAr, refereeFirstNameEn, refereeLastNameEn,
				 refereeDOB, refereeNationality, refereeType, refereePic)
							values ('$firstNameAr','$lastNameAr','$firstNameEn','$lastNameEn',
							'$dob', '$nation', '$refList', '$Pic')";
				mysql_query($sql) or die (mysql_error());
				echo $outPut;
			} else {
				echo "<script type=\"text/javascript\">";
				echo "alert('��� ����� ����� �����');</script>";
			}
		}

		mysql_close($conn);
		// close database connection
	}
}
echo "</div>";

// making footer
echo makeFooter();

?>