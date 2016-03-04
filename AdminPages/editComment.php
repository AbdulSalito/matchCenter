<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Edit Comment");
// insert the navigation
echo makeMenu();

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\">  ⁄œÌ· «· ⁄·Ìﬁ« </td>\n";
$beginTable .= "	</tr>\n";

// insert the navigation
if (isset($_GET["match"])) {
	$matchIDGet = $_GET["match"];

	echo "<form id = \"editComments\" action = \"\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„»«—«…</td>\n";
	echo "	<td>\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$Comp = $rowMatch['matchComp'];
	$Season = $rowMatch['matchSeason'];
	$outputTable = "<table>";
	$outputTable .= "<tr><td>";
	$dateDayEn = date('l', strtotime($dateMatch));
	$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
	$dateDayAr = $dateArr[$dateDayEn];
	$outputTable .= "$dateDayAr $dateMatch</td>";

	$teamPlaying1 = TeamNameAr($team1);
	$teamPlaying2 = TeamNameAr($team2);

	$outputTable .= "<td>$teamPlaying1</td>";
	$outputTable .= "<td>-</td>";
	$outputTable .= "<td>$teamPlaying2</td>";
	$outputTable .= "</tr></table>";
	echo $outputTable;

	echo "<br><a href=\"addMatchAnalysis.php?match=$matchIDGet\">«·⁄Êœ… ·≈÷«›…  Õ·Ì· «·„»«—«…</a>";
	echo " - <a href=\"editMatchAnalysis.php?match=$matchIDGet\">«·⁄Êœ… · ⁄œÌ· „œŒ·«  «· Õ·Ì·</a>";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>";
	echo "<select name=\"Comments\" size=\"11\" onclick=\"CityExFile('getPlayerCheck.php','editComment',this.value,'analysis')\">";
	$sqlMatch = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisComment<>'0' AND analysisComment > 11";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$commentID = $rowMatch['analysisComment'];
		$sqlComment = "SELECT * FROM comment WHERE commentID='$commentID'";
		$queryresultComment = mysql_query($sqlComment)
			or die(mysql_error());
		$rowComment = mysql_fetch_assoc($queryresultComment);
		$comment = $rowComment['commentText'];
		echo "	<option value=\"$commentID\"> $comment </option>";
	}
	echo "</select>";
	echo "</td>\n<td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "<div id=\"analysis\"></div>";
	echo "</td>\n</tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

elseif (isset($_GET["ID"])) {
	$commentID = $_GET["ID"];

	echo "<form id = \"editComments\" action = \"\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>";
	echo "</td>\n<td>\n";
	$sqlComment = "SELECT * FROM comment WHERE commentID='$commentID'";
	$queryresultComment = mysql_query($sqlComment)
	or die(mysql_error());
	$rowComment = mysql_fetch_assoc($queryresultComment);
	$comment = $rowComment['commentText'];
	echo "<textarea rows=\"7\" style=\"width:90%;\" type=\"text\" name=\"commentPost\" id=\"commentPost\">$comment</textarea>";
	echo "</td>\n</tr>";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}


echo "</table>\n";
echo "</form>\n";

if (isset($_POST['commentPost'])) {
	include 'db_conn.php';
	$commentPost = trim($_POST['commentPost']);
	if (isset($_GET["ID"])) {
		$commentID = $_GET["ID"];
	} elseif ($_POST['Comments']) {
		$commentID = $_POST['Comments'];
	}
	if ($commentPost != "" ) {
		$sqlComment = "UPDATE comment SET commentText='$commentPost'
				WHERE commentID='$commentID'";
		mysql_query($sqlComment) or die (mysql_error());
		// displaying the inserted data as a confirmation
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „  ⁄œÌ· «· ⁄·Ìﬁ »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		echo redirection();

	}
}

echo "</div>";

// making footer
echo makeFooter();

?>