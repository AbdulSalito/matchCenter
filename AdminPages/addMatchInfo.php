<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Match Information");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
if (isset($_GET["match"])) {
	$match = $_GET["match"];
	echo "<form id = \"addMatchInfo\" action = \"\" method = \"post\">\n";

	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"100%\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$dateMatch = $rowMatch['matchDate'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$time = $rowMatch['matchTime'];
		echo "<tr class=\"Matches\">";
		echo "<td class=\"whiteBorder\">$dateMatch</td>";
		echo "<td class=\"whiteBorder\">$time</td>";
		echo "<td class=\"whiteBorder\">";
		echo teamNameAr($team1);
		echo "</td>";
		echo "<td class=\"whiteBorder\"><a href=\"liveMatch.php?match=$match\"> - </a></td>";
		echo "<td class=\"whiteBorder\">";
		echo teamNameAr($team2);
		echo "</td>";
		echo "</tr>";
		echo "<tr class=\"Matches\">";
		echo "<td colspan=\"2\" class=\"whiteBorder\">\n «·Õﬂ„ </td>\n";
		echo "<td colspan=\"3\" class=\"whiteBorder\">\n";
		$sqlRef = "SELECT * FROM referee";
		$queryresultRef = mysql_query($sqlRef)
			or die(mysql_error());

		echo "<select name = \"referee\" id =\"referee\">";
		echo "<option value=\"\"> </option>\n";
		while ($rowRef = mysql_fetch_assoc($queryresultRef)) {
			$refID = $rowRef['refereeID'];
			$refFrirstName = $rowRef['refereeFirstNameAr'];
			$refLastName = $rowRef['refereeLastNameAr'];

			echo "<option value=\"$refID\">$refFrirstName $refLastName</option>\n";
		}
		// close the select box
		echo "</select>";
		echo "</td>\n";
		echo "</tr>";

		echo "<tr class=\"Matches\">";
		echo "<td colspan=\"2\" class=\"whiteBorder\">\n «·„·⁄» </td>\n";
		echo "<td colspan=\"3\" class=\"whiteBorder\">\n";
		$sqlStad = "SELECT * FROM stadiums";
		$queryresultStad = mysql_query($sqlStad)
			or die(mysql_error());

		echo "<select name = \"stadium\" id =\"stadium\">";
		echo "<option value=\"\"> </option>\n";
		while ($rowStad = mysql_fetch_assoc($queryresultStad)) {
			$StadID = $rowStad['stadiumID'];
			$StadName = $rowStad['stadiumNameAr'];

			echo "<option value=\"$StadID\">$StadName</option>\n";
		}
		// close the select box
		echo "</select>";
		echo "</td>\n";
		echo "</tr>";
		echo "	<tr>\n";
		echo "	<td colspan=\"5\"><input type=\"submit\" value=\"Add content\"></td>\n";
		echo "	</tr>\n";
	}
	echo "</table>\n";
	mysql_free_result($queryresultMatch);
	// end comp table
	echo "</td>\n</tr>\n";
}
echo "</form>\n";

if (isset($_POST['stadium']) && isset($_GET["match"])) {
	include 'db_conn.php';
	$match = $_GET["match"];
	$ref = $_POST['referee'];
	$stad = $_POST['stadium'];

	$sqlMatchInfo = "UPDATE `matchcenter`.`match` SET matchStadium='$stad', matchReferee='$ref'
			WHERE matchID='$match'";
	mysql_query($sqlMatchInfo) or die (mysql_error());
	// displaying the inserted data as a confirmation
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\"> „ «÷«›… «·„⁄·Ê„«  »‰Ã«Õ! </td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	echo "</div>\n";
	// end displaying data\
	echo redirection();
}

echo "</div>";

// making footer
echo makeFooter();

?>