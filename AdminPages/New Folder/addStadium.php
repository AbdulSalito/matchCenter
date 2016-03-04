<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');

// insert the header
echo makeHeader("Add Stadium");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addReferee\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\"> ≈÷«›… «” «œ </td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·⁄—»Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameAr\" id=\"NameAr\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·«”„ »«·«‰Ã·Ì“Ì</td>\n";
echo "	<td><input type=\"text\" name=\"NameEn\" id=\"NameEn\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·„œÌ‰…</td>\n";
echo "	<td>";
echo makeCountryList();
echo "</td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·”⁄…</td>\n";
echo "	<td><input type=\"text\" name=\"capacity\" id=\"capacity\"></td>\n";
echo " </tr>\n";
echo "	<tr>\n";
echo "	<td>”‰… «·«›  «Õ</td>\n";
echo "	<td><input type=\"text\" name=\"founded\" id=\"founded\"></td>\n";
echo " </tr>\n";
echo "	<tr>\n";
echo "	<td>’Ê—… «·„·⁄»</td>\n";
echo "	<td><input type=\"text\" name=\"stadium\" id=\"stadium\">";
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
		$sql = "INSERT INTO stadiums (stadiumNameAr, stadiumNameEn, stadiumCity, stadiumCapacity, stadiumFounded, stadiumPic)
							values ('$NameAr','$NameEn','$city','$capacity', '$founded', '$Pic')";
		mysql_query($sql) or die (mysql_error());

		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „ «÷«›… «·«” «œ »‰Ã«Õ! </td>\n";
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
		echo "	<td>\n";
		echo cityNameAr($city);
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
		echo "	<td>’Ê—… «·«” «œ</td>\n";
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