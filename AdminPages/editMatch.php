<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Comment");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
if (isset($_GET["match"])) {
	$match = $_GET["match"];

	echo "<form id = \"editMatch\" action = \"\" method = \"post\">\n";
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"3\">  ⁄œÌ· „»«—«…</td>\n";
	echo "	</tr>\n";

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$comp = $rowMatch['matchComp'];
	$Season = $rowMatch['matchSeason'];
	$Round = $rowMatch['matchRound'];

	echo "	<tr>\n";
	echo "	<td colspan=\"3\">".CompAr($comp)." , ".season($Season)."<br>";
	if (CompSys($comp) == 0) {
		echo "«·ÃÊ·… $Round";
	}
	elseif (CompSys($comp) == 1 OR 2) {
		if ($Round == 2) {
			echo "«·‰Â«∆Ì";
		}
		elseif ($Round == 3) {
			echo " ÕœÌœ «·„—ﬂ“ «·À«·À";
		}
		else {
			echo "œÊ— «·‹$Round";
		}
	}
	echo "</td>\n </tr>\n";
	echo "<tr>";
	echo "<td>$dateMatch</td>";
	echo "<td>";
	echo makeTeamSelector("team1",$team1);
	echo "</td>";
	echo "<td>";
	echo makeTeamSelector("team2",$team2);
	echo "</td>";
	echo "</tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"3\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	mysql_free_result($queryresultMatch);
	// end comp table
	echo "</td>\n</tr>\n";
}
echo "</form>\n";

if (isset($_POST['team1']) && isset($_GET["match"])) {
	include 'db_conn.php';
	$match = $_GET["match"];
	$team1 = $_POST['team1'];
	$team2 = $_POST['team2'];
	if ($team1 != $team2 ) {
		$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$team1',matchTeamAway='$team2' WHERE matchID='$match'";
		mysql_query($sql) or die (mysql_error());
		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «·„»«—«… »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		// end displaying data\
		echo redirection();

	}
}

echo "</div>";

// making footer
echo makeFooter();

?>