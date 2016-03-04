<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("edit Stadium");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addReferee\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\">  ⁄œÌ· «” «œ </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
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
	echo makeCountryListEdit($city);
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
}

if (isset($_POST['NameAr']) && isset($_POST['NameEn'])) {
	$NameAr = trim($_POST['NameAr']);
	$NameEn = trim($_POST['NameEn']);
	$city = trim($_POST['city']);
	$capacity = trim($_POST['capacity']);
	$founded = $_POST['founded'];
	$Pic = trim($_POST['stadium']);
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {

		include 'db_conn.php';
		$sql = "UPDATE stadiums SET stadiumNameAr='$NameAr',stadiumNameEn='$NameEn',stadiumCity='$city',stadiumCapacity='$capacity',
		stadiumFounded='$founded', stadiumPic='$Pic' WHERE stadiumID='$idGet'";
		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «·«” «œ »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·⁄—»Ì</td>\n";
		echo "	<td>".$NameAr."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·«”„  »«·«‰Ã·Ì“Ì</td>\n";
		echo "	<td>".$NameEn."</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·„œÌ‰… </td>\n";
		include 'db_conn.php';
		$sqlCity = "SELECT * FROM city WHERE cityID='$city'";
		$queryresultCity = mysql_query($sqlCity)
				or die(mysql_error());
		while ($rowCity = mysql_fetch_assoc($queryresultCity)) {
			$cityName = $rowCity['cityNameAr'];
			echo "	<td> $cityName";
		}
		mysql_free_result($queryresultCity);
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·”⁄…</td>\n";
		echo "	<td>$capacity";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>”‰… «·«›  «Õ</td>\n";
		echo "	<td>$founded";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>’Ê—… «·„·⁄»</td>\n";
		echo "	<td><img border=\"0\" src=\"../stadium/$Pic\"></td>\n";
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