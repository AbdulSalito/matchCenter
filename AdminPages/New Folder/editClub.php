<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Club");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addClub\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\">  ⁄œÌ· ‰«œÌ </td>\n";
echo "	</tr>\n";
if (isset($_GET['ID'])) {
	$idGet = $_GET['ID'];
	$sql = "SELECT * FROM teams WHERE teamID='$idGet'";
	$queryresult = mysql_query($sql)
			or die(mysql_error());
	$row = mysql_fetch_assoc($queryresult);
	$NameAr = $row['teamNameAr'];
	$NameEn = $row['teamNameEn'];
	$founded = $row['teamFoundation'];
	$city = $row['teamCity'];
	$stad = $row['teamStadium'];
	$flag = $row['teamFlag'];
	$color1 = $row['teamColor1'];
	$color2 = $row['teamColor2'];

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
	echo "	<td>«·„·⁄»</td>\n";
	echo "	<td>";
	echo makeStadiumList($stad,$city);
	echo "</td>\n";
	echo "	</tr>\n";

	echo "	<tr>\n";
	echo "	<td>”‰… «· √”Ì”</td>\n";
	echo "	<td><input type=\"text\" name=\"founded\" id=\"founded\" value=\"$founded\"></td>\n";
	echo " </tr>\n";
	echo "	<tr>\n";
	echo "	<td> «·‘⁄«—</td>\n";
	echo "	<td><input type=\"text\" name=\"teams\" id=\"teams\" value=\"$flag\"></td>\n";
	echo "</tr><tr><td colspan=\"2\">";
	echo getImagesJS();
	echo getImages("teams",70);
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«··Ê‰ «·√Ê·</td>\n";
	echo "	<td><input type=\"text\" name=\"teamColor1\" id=\"teamColor1\" value=\"$color1\" style=\"background-color:#$color1;\"></td>\n";
	echo " </tr>\n";
	echo "<tr><td colspan=\"2\">";
	echo getColorPicker('teamColor1');
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«··Ê‰ «·À«‰Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"teamColor2\" id=\"teamColor2\" value=\"$color2\" style=\"background-color:#$color2;\"></td>\n";
	echo " </tr>\n";
	echo "<tr><td colspan=\"2\">";
	echo getColorPicker('teamColor2');
	echo " </td></tr>\n";
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
	$stad = trim($_POST['stadium']);
	$founded = $_POST['founded'];
	$Pic = trim($_POST['teams']);
	$teamColor1 = trim($_POST['teamColor1']);
	$teamColor2 = trim($_POST['teamColor2']);
	// START valdate if all required fields are not empty
	if ($NameAr != "" && $NameEn != "") {
		include 'db_conn.php';
		$sql = "UPDATE teams SET teamNameAr='$NameAr',teamNameEn='$NameEn',teamFoundation='$founded', teamStadium='$stad',
		teamCity='$city',teamFlag='$Pic',teamColor1='$teamColor1',teamColor2='$teamColor2' WHERE teamID='$idGet'";

		mysql_query($sql) or die (mysql_error());
		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «·‰«œÌ »‰Ã«Õ! </td>\n";
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
		echo "	<td> ".cityNameAr($city)."";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>”‰… «· √”Ì”</td>\n";
		echo "	<td>$founded";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>‘⁄«— «·‰«œÌ </td>\n";
		echo "	<td><img border=\"0\" src=\"../teams/$Pic\"></td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td> √·Ê«‰ «·‰«œÌ</td>\n";
		echo "	<td>";
		echo "<table width=\"30\" height=\"15\"><tr><td  bgcolor=\"#$teamColor1\"></td><td  bgcolor=\"#$teamColor2\"></td></tr></table>";
		echo "	</td></tr>\n";
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