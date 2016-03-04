<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Stadium");
// insert the navigation
echo makeMenu();

$type = $_GET['Type'];
// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"Stadium\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";

if ($type == "edit") {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM stadiums WHERE stadiumID='$idGet'";
	$queryresult = mysql_query($sql)
							or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$NameAr = $row['stadiumNameAr'];
	$NameEn = $row['stadiumNameEn'];
	$city = $row['stadiumCity'];
	$capacity = $row['stadiumCapacity'];
	$founded = $row['stadiumFounded'];
	$pic = $row['stadiumPic'];
	echo "	<td colspan=\"2\">  ⁄œÌ· «” «œ </td>\n";

}
elseif ($type == "add") {
	$NameAr = "";
	$NameEn = "";
	$city = "";
	$capacity = "";
	$founded = "";
	$pic = "";
	echo "	<td colspan=\"2\"> ≈÷«›… «” «œ </td>\n";
}
echo "	<tr>\n";
echo "	<td>«·«”„ »«·⁄—»Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameAr\" id=\"NameAr\" value=\"$NameAr\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·«‰Ã·Ì“Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameEn\" id=\"NameEn\" value=\"$NameEn\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·„œÌ‰…</td>\n";
echo "	<td>";
if ($type == "edit") {
	echo makeCountryListEdit($city);
}
elseif ($type == "add") {
	echo makeCountryList();
}
echo "</td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·”⁄…</td>\n";
echo "	<td><input type=\"text\" name=\"capacity\" id=\"capacity\" value=\"$capacity\"></td>\n";
echo " </tr>\n";
echo "	<tr>\n";
echo "	<td>”‰… «·«›  «Õ</td>\n";
echo "	<td><input type=\"text\" name=\"founded\" id=\"founded\" value=\"$founded\"></td>\n";
echo " </tr>\n";
echo "	<tr>\n";
echo "	<td>’Ê—… «·„·⁄»</td>\n";
echo "	<td><input type=\"text\" name=\"stadium\" id=\"stadium\" value=\"$pic\">";
echo getImagesJS();
echo getImages("stadium",184);
echo " </td>\n</tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameAr = trim($_POST['NameAr']);
	$NameEn = trim($_POST['NameEn']);
	$city = trim($_POST['city']);
	$capacity = trim($_POST['capacity']);
	$founded = $_POST['founded'];
	$Pic = $_POST['stadium'];
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {
		include 'db_conn.php';
		$outPut = "<table  class=\"mcenter\">\n";
		$outPut .= "	<tr class=\"mcenter\">\n";
		$outPut .= "	<td colspan=\"2\"> „ «÷«›… «·«” «œ »‰Ã«Õ! </td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		$outPut .= "	<td>".$NameAr."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		$outPut .= "	<td>".$NameEn."</td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·„œÌ‰… </td>\n";
		$outPut .= "	<td>\n";
		$outPut .= cityNameAr($city);
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>«·”⁄…</td>\n";
		$outPut .= "	<td>$capacity";
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>”‰… «·«›  «Õ</td>\n";
		$outPut .= "	<td>$founded";
		$outPut .= "	</td></tr>\n";
		$outPut .= "	<tr>\n";
		$outPut .= "	<td>’Ê—… «·«” «œ</td>\n";
		$outPut .= "	<td><img border=\"0\" src=\"../stadium/$Pic\"></td>\n";
		$outPut .= "	</tr>\n";
		$outPut .= "</table>\n";
		// end displaying data
		$outPut .= redirection();
		if (isset($_GET['ID'])) {
			$idGet = $_GET['ID'];
			$sql = "UPDATE stadiums SET stadiumNameAr='$NameAr',stadiumNameEn='$NameEn',stadiumCity='$city',stadiumCapacity='$capacity',
			stadiumFounded='$founded', stadiumPic='$Pic' WHERE stadiumID='$idGet'";
			mysql_query($sql) or die (mysql_error());
			echo $outPut;
		} else {
			$sqlM = "SELECT * FROM stadiums WHERE stadiumNameAr='$NameAr' OR stadiumNameEn='$NameEn'";
			$queryresultM = mysql_query($sqlM)
				or die(mysql_error());
			$rowNum = mysql_num_rows($queryresultM);
			if ($rowNum == 0) {
				$sql = "INSERT INTO stadiums (stadiumNameAr, stadiumNameEn, stadiumCity, stadiumCapacity, stadiumFounded, stadiumPic)
							values ('$NameAr','$NameEn','$city','$capacity', '$founded', '$Pic')";
				mysql_query($sql) or die (mysql_error());
				echo $outPut;
			} else {
				echo "<script type=\"text/javascript\">";
				echo "alert('Â–« «·«” «œ „ÊÃÊœ „”»ﬁ«');</script>";
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