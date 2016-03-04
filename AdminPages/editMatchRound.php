<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginForm = "<form id = \"addClub\" action = \"\" method = \"post\">\n";
$beginTable = "<table class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"3\">  ⁄œÌ· «·ÃÊ·« </td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["season"]) && isset($_GET["comp"]) && isset($_GET["Group"])) {
	$seasonIDGet = $_GET["season"];
	$compIDGet = $_GET["comp"];

	echo "<form id = \"editMatchRound\" action = \"\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td colspan=\"4\">«·„»«—Ì« </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"4\">\n";
	echo "<script type=\"text/javascript\" src=\"../js/checkAll.js\"></script>";
	echo "<a href=\"#\" onClick=\"return checkAll();\">≈Œ Ì«— «·ﬂ·</a> || <a href=\"#\" onClick=\" return checkNone();\">⁄œ„ ≈Œ Ì«— «·ﬂ·</a>";
	echo "</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n";
	$CheckMatchAction = "season=";
	$CheckMatchAction .= $seasonIDGet;
	$CheckMatchAction .= "&comp=";
	$CheckMatchAction .= $compIDGet;

	// check if the competition league or Groups
	$sqlComp = "SELECT * FROM competition WHERE compID='$compIDGet'";
	$queryresultComp = mysql_query($sqlComp)
	or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	// END check if the competition league or Groups

	if ($CompSys == 0) {
		echo "<select class=\"round\" name=\"matchesRound\" size=\"11\" onclick=\"CityExFile('getMatchCheck.php','$CheckMatchAction&Group=Yes&roundID',this.value,'matchRound')\">";
		$sqlMatchRound = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet'";
		$queryresultMatchRound = mysql_query($sqlMatchRound)
			or die(mysql_error());
		$NumberOfMatches =  mysql_num_rows($queryresultMatchRound);
		$NumberOfMatches -- ;
		for ($i = 1; $i <= ($NumberOfMatches * 2); $i++) {
			if ($roundIDGet == $i) {
				echo "	<option selected=\"selected\" value=\"$i\"> «·ÃÊ·… $i</option>";
			}
			else {
				echo "	<option value=\"$i\"> «·ÃÊ·… $i</option>";
			}
		}
		mysql_free_result($queryresultMatchRound);
		echo "</select>";
	}
	else {
		$sqlMatchRound = "SELECT MAX(matchRound) FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet'";
		$queryresultMatchRound = mysql_query($sqlMatchRound)
			or die(mysql_error());
		$MatchRoundRow = mysql_fetch_assoc($queryresultMatchRound);
		$NumberOfMatches = $MatchRoundRow['MAX(matchRound)'];
		echo "<select class=\"round\" name=\"matchesRound\" size=\"11\" onclick=\"CityExFile('getMatchCheck.php','$CheckMatchAction&Group=Yes&roundID',this.value,'matchRound')\">";
		while($NumberOfMatches % 2 == 0){
			if ($NumberOfMatches == 2) {
				echo "	<option value=\"3\"> «·„—ﬂ“ «·À«·À</option>";
				echo "	<option value=\"$NumberOfMatches\"> «·‰Â«∆‹‹Ì</option>";
			} else {
				echo "	<option value=\"$NumberOfMatches\"> œÊ— «·‹ $NumberOfMatches</option>";
			}
			$NumberOfMatches /= 2;
		}
		mysql_free_result($queryresultMatchRound);
		echo "</select>";
	}

	echo "	</td>\n";
	echo "<td colspan=\"3\">";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<div id=\"matchRound\"></div>";
	echo "	<td colspan=\"3\">\n";
	echo "	</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"3\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

elseif (isset($_GET["season"]) && isset($_GET["comp"])) {
	$seasonIDGet = $_GET["season"];
	$compIDGet = $_GET["comp"];

	echo "<form id = \"editMatchRound\" action = \"\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td colspan=\"4\">«·„»«—Ì« </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"4\"><input type=\"checkbox\" name=\"nextRound\" value=\"0\"> ⁄œÌ· «·ÃÊ·… «· «·Ì…</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"4\">\n";
	echo "<script type=\"text/javascript\" src=\"../js/checkAll.js\"></script>";
	echo "<a href=\"#\" onClick=\"return checkAll();\">≈Œ Ì«— «·ﬂ·</a> || <a href=\"#\" onClick=\" return checkNone();\">⁄œ„ ≈Œ Ì«— «·ﬂ·</a>";
	echo "</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n";
	$CheckMatchAction = "season=";
	$CheckMatchAction .= $seasonIDGet;
	$CheckMatchAction .= "&comp=";
	$CheckMatchAction .= $compIDGet;

	// check if the competition league or Groups
	$sqlComp = "SELECT * FROM competition WHERE compID='$compIDGet'";
	$queryresultComp = mysql_query($sqlComp)
	or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	// END check if the competition league or Groups

	if ($CompSys == 0) {
		echo "<select class=\"round\" name=\"matchesRound\" size=\"11\" onclick=\"CityExFile('getMatchCheck.php','$CheckMatchAction&roundID',this.value,'matchRound')\">";
		$sqlMatchRound = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet'";
		$queryresultMatchRound = mysql_query($sqlMatchRound)
			or die(mysql_error());
		$NumberOfMatches =  mysql_num_rows($queryresultMatchRound);
		$NumberOfMatches -- ;
		for ($i = 1; $i <= ($NumberOfMatches * 2); $i++) {
			if ($roundIDGet == $i) {
				echo "	<option selected=\"selected\" value=\"$i\"> «·ÃÊ·… $i</option>";
			}
			else {
				echo "	<option value=\"$i\"> «·ÃÊ·… $i</option>";
			}
		}
		mysql_free_result($queryresultMatchRound);
		echo "</select>";
	}
	else {
		$sqlMatchRound = "SELECT MAX(matchRound) FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet'";
		$queryresultMatchRound = mysql_query($sqlMatchRound)
			or die(mysql_error());
		$MatchRoundRow = mysql_fetch_assoc($queryresultMatchRound);
		$NumberOfMatches = $MatchRoundRow['MAX(matchRound)'];
		echo "<select class=\"round\" name=\"matchesRound\" size=\"11\" onclick=\"CityExFile('getMatchCheck.php','$CheckMatchAction&roundID',this.value,'matchRound')\">";
		$GroupsExist = 0;
		while($NumberOfMatches % 2 == 0){
			if ($NumberOfMatches == 32) {
				$GroupsExist += 1;
			}
			elseif ($NumberOfMatches == 2) {
				echo "	<option value=\"3\"> «·„—ﬂ“ «·À«·À</option>";
				echo "	<option value=\"$NumberOfMatches\"> «·‰Â«∆‹‹Ì</option>";
			} else {
				echo "	<option value=\"$NumberOfMatches\"> œÊ— «·‹ $NumberOfMatches</option>";
			}
			$NumberOfMatches /= 2;
		}
		mysql_free_result($queryresultMatchRound);
		echo "</select>";
		if ($GroupsExist !=0) {
			echo "<br>";
			$CheckMatchAction .= "&roundID=";
			$CheckMatchAction .= "32";
			echo "<select class=\"round\" name=\"matchesGroup\" size=\"9\" onclick=\"CityExFile('getMatchCheck.php','$CheckMatchAction&GroupNum', this.value ,'matchRound')\">";
			for($iGroup = 1; $iGroup <= 8; $iGroup ++){
				echo "	<option value=\"$iGroup\"> «·„Ã„Ê⁄… $iGroup</option>";
			}
			echo "</select>";
		}
	}

	echo "	</td>\n";
	echo "<td colspan=\"3\">";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<div id=\"matchRound\"></div>";
	echo "	<td colspan=\"3\">\n";
	echo "	</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"3\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

/*elseif (isset($_GET["season"]) && isset($_GET["cup"]) && isset($_GET["round"])) {
	$seasonIDGet = $_GET["season"];
	$compIDGet = $_GET["cup"];
	$roundIDGet = $_GET["round"];

	$postAction .= "season=";
	$postAction .= $seasonIDGet;
	$postAction .= "&cup=";
	$postAction .= $compIDGet;
	$postAction .= "&round=";
	$postAction .= $roundIDGet;

	echo "<form id = \"addMatchRound\" action = \"editMatchRound.php?$postAction\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td colspan=\"4\">«·„»«—Ì« </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n";
	$CheckMatchAction = "season=";
	$CheckMatchAction .= $seasonIDGet;
	$CheckMatchAction .= "&comp=";
	$CheckMatchAction .= $compIDGet;

	echo "<td colspan=\"3\">";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<div id=\"matchRound\"></div>";
	echo "	<td colspan=\"3\">\n";
	echo "	</td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"3\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}*/


echo "</table>\n";
echo "</form>\n";

if (isset($_POST['matches']) && isset($_GET["season"])) {
	include 'db_conn.php';
	$matchesPost = $_POST['matches'];
	$seasonIDGet = $_GET["season"];
	if (isset($_GET["comp"])) {
		$comp = $_GET["comp"];
	} elseif (isset($_GET["cup"])) {
		$comp = $_GET["cup"];
	}

	foreach ($matchesPost as $matches){
		if (isset($_GET["Group"])) {
			$matchGroup = "Group$matches";
			$matchGroupPost = $_POST[$matchGroup];
			$setUpdate = "matchGroup='$matchGroupPost'";
		} else {
			$matchRoundPost = $_POST[$matches];
			$matchDate = "date$matches";
			$matchDatePost = $_POST[$matchDate];
			$matchTime = "time$matches";
			$matchTimePost = $_POST[$matchTime];
			$setUpdate = "matchRound='$matchRoundPost', matchDate='$matchDatePost', matchTime='$matchTimePost'";
		}
		$sql = "UPDATE `matchcenter`.`match` SET $setUpdate
		WHERE matchID='$matches'";
		mysql_query($sql) or die (mysql_error());
	}
	if (isset($_POST['nextRound'])) {
		if ($_POST['nextRound'] == 0) {
			foreach ($matchesPost as $matches){
				$matchRoundPost = $_POST[$matches];
				$matchRoundPost ++;
				$matchDate = "date$matches";
				$matchDatePost = $_POST[$matchDate];
				//$matchDatePost = strtotime(strtotime($matchDatePost) . " +1 week");
				$matchTime = "time$matches";
				$matchTimePost = $_POST[$matchTime];
				$sqlNext = "UPDATE `matchcenter`.`match` SET matchDate='$matchDatePost', matchTime='$matchTimePost'
				WHERE matchSeason='$seasonIDGet' AND matchComp='$comp' AND matchRound='$matchRoundPost'";
				mysql_query($sqlNext) or die (mysql_error());
			}
		}
	}
	echo " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"editMatchRound.php\">«·⁄Êœ…</a>";
	echo redirection();
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>