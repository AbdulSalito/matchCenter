<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Links");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
if (isset($_GET["match"])) {
	$match = $_GET["match"];
	echo "<form id = \"addLinks\" action = \"\" method = \"post\">\n";

	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"100%\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$dateMatch = $rowMatch['matchDate'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$time = $rowMatch['matchTime'];

		$sqlLinks = "SELECT * FROM `links` WHERE linkMatch='$match'";
		$queryresultLinks = mysql_query($sqlLinks)
			or die(mysql_error());
		if (mysql_num_rows($queryresultLinks) == 0) {
			$fullMatch = "";
			$video = "";
			$Pics = "";
		}
		else {
			$rowLinks = mysql_fetch_assoc($queryresultLinks);
			$fullMatch = $rowLinks['linkFullMatch'];
			$video = $rowLinks['linkVideo'];
			$Pics = $rowLinks['linkPics'];
		}
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
		echo "<td colspan=\"1\" class=\"whiteBorder\">\n ›ÌœÌÊ </td>\n";
		echo "<td colspan=\"4\" class=\"whiteBorder\">\n";
		echo "<input style=\"width:300px;\" type=\"text\" name=\"Video\" id=\"Video\" value=\"$video\">\n";
		echo "</td>\n";
		echo "</tr>";

		echo "<tr class=\"Matches\">";
		echo "<td colspan=\"1\" class=\"whiteBorder\">\n „»«—«… ﬂ«„·… </td>\n";
		echo "<td colspan=\"4\" class=\"whiteBorder\">\n";
		echo "<input style=\"width:300px;\" type=\"text\" name=\"fullMatch\" id=\"fullMatch\" value=\"$fullMatch\">\n";
		echo "</td>\n";
		echo "</tr>";

		echo "<tr class=\"Matches\">";
		echo "<td colspan=\"1\" class=\"whiteBorder\">\n ’Ê— </td>\n";
		echo "<td colspan=\"4\" class=\"whiteBorder\">\n";
		echo "<input style=\"width:300px;\" type=\"text\" name=\"Pics\" id=\"Pics\" value=\"$Pics\">\n";
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

if (isset($_POST['Pics']) && isset($_GET["match"]) && isset($_POST['fullMatch'])) {
	include 'db_conn.php';
	$match = $_GET["match"];
	$pics = trim($_POST['Pics']);
	$fullMatch = trim($_POST['fullMatch']);
	$video = trim($_POST['Video']);
	if ($pics == "") {
		$pics = 0;
	}
	if ($fullMatch == "") {
		$fullMatch = 0;
	}
	if ($video == "") {
		$video = 0;
	}

	$sqlLinks = "SELECT * FROM `links` WHERE linkMatch='$match'";
	$queryresultLinks = mysql_query($sqlLinks)
	or die(mysql_error());
	if (mysql_num_rows($queryresultLinks) == 0) {
		$sql = "INSERT INTO links (linkMatch, linkVideo, linkFullMatch, linkPics)
							values ('$match','$video','$fullMatch','$pics')";
		mysql_query($sql) or die (mysql_error());
	}
	else {
		$sql = "UPDATE links SET linkVideo='$video',linkFullMatch='$fullMatch',linkPics='$pics' WHERE linkMatch='$match'";
		mysql_query($sql) or die (mysql_error());
	}
	// displaying the inserted data as a confirmation
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\"> „ «÷«›… «·„⁄·Ê„«  »‰Ã«Õ! </td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	// end displaying data\
	echo redirection();
}

echo "</div>";

// making footer
echo makeFooter();

?>