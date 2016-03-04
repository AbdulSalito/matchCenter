<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Kits");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\">≈÷«›… √ÿﬁ„ «·›—Ìﬁ</td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["season"]) && isset($_GET["team"])) {
	$SeasonIDGet = $_GET["season"];
	$TeamIDGet = $_GET["team"];

	$sqlKit = "SELECT * FROM kits WHERE kitSeason='$SeasonIDGet' AND kitTeam='$TeamIDGet'";
	$queryresultKit = mysql_query($sqlKit)
		or die(mysql_error());
	if (mysql_num_rows($queryresultKit) != 0) {
		$rowKit = mysql_fetch_assoc($queryresultKit);
		$kit1 = $rowKit['kit1'];
		$kit2 = $rowKit['kit2'];
		$kit3 = $rowKit['kit3'];
	} else {
		$kit1 = "";
		$kit2 = "";
		$kit3 = "";
	}
	echo "<form id = \"addKits\" action = \"\" method = \"post\">\n";
	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n";
	echo season($SeasonIDGet);
	echo " <a href=\"addKits.php\">  ⁄œÌ·</a>";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ</td>\n";
	echo "	<td>\n";
	echo TeamNameAr($TeamIDGet);
	echo " <a href=\"addKits.php?season=$SeasonIDGet\">  ⁄œÌ·</a>";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td> «·ÿﬁ„ «·√Ê·</td>\n";
	echo getImagesJS();
	$sqlSes = "SELECT * FROM season WHERE seasonID='$SeasonIDGet'";
	$queryresultSes = mysql_query($sqlSes)
	or die(mysql_error());
	$rowSes = mysql_fetch_assoc($queryresultSes);
	$start = $rowSes['seasonYearStart'];
	$end = $rowSes['seasonYearEnd'];
	$subFolder = "$start$end";

	echo "	<td><input type=\"text\" name=\"kit1\" id=\"kit1\" value=\"$kit1\"></td>\n";
	echo "</tr><tr><td colspan=\"2\">";
	echo getImagesKits("kits","kit1",$subFolder);
	echo " </td></tr>\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\"> # # # </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td> «·ÿﬁ„ «·À«‰Ì</td>\n";
	echo "	<td><input type=\"text\" name=\"kit2\" id=\"kit2\" value=\"$kit2\"></td>\n";
	echo "</tr><tr><td colspan=\"2\">";
	echo getImagesKits("kits","kit2",$subFolder);
	echo " </td></tr>\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\">  # # # </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td> «·ÿﬁ„ «·À«·À</td>\n";
	echo "	<td><input type=\"text\" name=\"kit3\" id=\"kit3\" value=\"$kit3\"></td>\n";
	echo "</tr><tr><td colspan=\"2\">";
	echo getImagesKits("kits","kit3",$subFolder);
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

elseif (isset($_GET["season"])) {
	$SeasonIDGet = $_GET["season"];
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n";
	echo season($SeasonIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ</td>\n";
	echo "	<td>\n <select name = \"match\" id =\"match\" onChange=\"location.href='addKits.php?season=".$SeasonIDGet."&team='+this.options[this.selectedIndex].value;\">";
	echo "	<option value=\"\"> </option>";
	$sqlMatch = "SELECT * FROM teams";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$teamID = $rowMatch['teamID'];
		$teamNameAr = $rowMatch['teamNameAr'];
		$teamCity = $rowMatch['teamCity'];
		echo "	<option value=\"$teamID\">$teamNameAr - ". CityNameAr($teamCity) ."</option>";
	}
	mysql_free_result($queryresultMatch);
	echo "	</select></td></tr>\n";
}

else {
	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\" onChange=\"location.href='addKits.php?season='+this.options[this.selectedIndex].value;\">";
	echo "	<option value=\"\"> </option>";
	$sqlSes = "SELECT * FROM season";
	$queryresultSes = mysql_query($sqlSes)
				or die(mysql_error());
	while ($rowSes = mysql_fetch_assoc($queryresultSes)) {
		$sesID = $rowSes['seasonID'];
		$start = $rowSes['seasonYearStart'];
		$end = $rowSes['seasonYearEnd'];
		echo "	<option value=\"$sesID\">$start - $end</option>";
	}
	mysql_free_result($queryresultSes);
	echo "	</select></td></tr>\n";
}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['kit1']) && isset($_POST['kit2'])) {
	$kit1 = trim($_POST['kit1']);
	$kit2 = trim($_POST['kit2']);
	$kit3 = trim($_POST['kit3']);
	$season = $_GET['season'];
	$team = $_GET['team'];
	// START valdate if all required fields are not empty
	if ($kit1 != "" && $kit2 != "") {
		include 'db_conn.php';

		$sqlKit = "SELECT * FROM kits WHERE kitSeason='$SeasonIDGet' AND kitTeam='$TeamIDGet'";
		$queryresultKit = mysql_query($sqlKit)
			or die(mysql_error());
		if (mysql_num_rows($queryresultKit) != 0) {
			$sql = "UPDATE kits SET kit1='$kit1',kit2='$kit2',kit3='$kit3'
				WHERE kitSeason='$season' AND kitTeam='$team'";
			mysql_query($sql) or die (mysql_error());
		} else {
			$sql = "INSERT INTO kits (kitSeason, kitTeam, kit1, kit2, kit3)
							values ('$season','$team', '$kit1', '$kit2','$kit3')";
			mysql_query($sql) or die (mysql_error());
		}
		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „ «÷«›… «·√ÿﬁ„ »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·„Ê”„</td>\n";
		echo "	<td> ";
		echo season($season);
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·‰«œÌ</td>\n";
		echo "	<td> ";
		echo TeamNameAr($team);
		echo "	</td></tr>\n";
		$sqlSes = "SELECT * FROM season WHERE seasonID='$season'";
		$queryresultSes = mysql_query($sqlSes)
			or die(mysql_error());
		$rowSes = mysql_fetch_assoc($queryresultSes);
		$start = $rowSes['seasonYearStart'];
		$end = $rowSes['seasonYearEnd'];
		$StartEnd = "$start$end";
		echo "	<tr>\n";
		echo "	<td>«·ÿﬁ„ «·√Ê· </td>\n";
		echo "	<td> <img src=\"../kits/$StartEnd/$kit1\">\n";
		echo "	</td></tr>\n";

		echo "	<tr>\n";
		echo "	<td>«·ÿﬁ„ «·À«‰Ì </td>\n";
		echo "	<td> <img src=\"../kits/$StartEnd/$kit2\">\n";
		echo "	</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·ÿﬁ„ «·À«·À </td>\n";
		echo "	<td> <img src=\"../kits/$StartEnd/$kit3\">\n";
		echo "	</tr>\n";
		echo "</table>\n";
		// end displaying data
		echo redirection();
		mysql_close($conn);
		// close database connection
	}
}
echo "</div>";

// making footer
echo makeFooter();

?>