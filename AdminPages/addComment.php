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
	echo "<form id = \"addMatchComment\" action = \"\" method = \"post\">\n";

	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"100%\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$time = $rowMatch['matchTime'];
	echo "<tr class=\"hilalMatches\">";
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
	echo "<tr class=\"hilalMatches\">";
	echo "<td colspan=\"5\" class=\"whiteBorder\"><textarea rows=\"5\" width=\"100%\" type=\"text\" name=\"commentPost\" id=\"commentPost\"></textarea></td>\n";
	echo "</tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"5\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
	echo "</table>\n";
	mysql_free_result($queryresultMatch);
	// end comp table
	echo "</td>\n</tr>\n";
}
echo "</form>\n";

if (isset($_POST['commentPost']) && isset($_GET["match"])) {
	include 'db_conn.php';
	$match = $_GET["match"];
	$commentPost = trim($_POST['commentPost']);
	if ($commentPost != "" ) {
		$sql = "INSERT INTO comment (`commentText`)	VALUES ('$commentPost');";
		mysql_query($sql) or die (mysql_error());
		$sqlComment = "SELECT * FROM comment WHERE commentText='$commentPost' ORDER BY commentID DESC";
		$queryresultComment = mysql_query($sqlComment)
			or die(mysql_error());
		$commentRow = mysql_fetch_assoc($queryresultComment);
		$commentID = $commentRow['commentID'];
		mysql_free_result($queryresultComment);

		$sqlMatchComment = "UPDATE `matchcenter`.`match` SET matchComment='$commentID'
				WHERE matchID='$match'";
		mysql_query($sqlMatchComment) or die (mysql_error());
		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „ «÷«›… «· ⁄·Ìﬁ »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«· ⁄·Ìﬁ</td>\n";
		echo "	<td>".$commentPost."</td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		echo "</div>\n";
		// end displaying data\
		echo redirection();

	}
}

echo "</div>";

// making footer
echo makeFooter();

?>