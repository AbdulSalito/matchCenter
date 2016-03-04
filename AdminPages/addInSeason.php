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
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\"> ≈÷«›… ≈·Ï «·„Ê”„</td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["season"]) && isset($_GET["team"]) && isset($_GET["type"])) {
	$TeamIDGet = $_GET["team"];
	$SeasonIDGet = $_GET["season"];
	$SesTypIDGet = $_GET["type"];

	$postAction .= "season=";
	$postAction .= $SeasonIDGet;
	$postAction .= "&team=";
	$postAction .= $TeamIDGet;
	$postAction .= "&type=";
	$postAction .= $SesTypIDGet;

	echo "<form id = \"addClub\" action = \"addInSeason.php?$postAction\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n";
	echo season($SeasonIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ</td>\n";
	echo "	<td>\n";
	echo TeamNameAr($TeamIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n";
	global $SeasonTypeAr;
	echo "$SeasonTypeAr[$SesTypIDGet]";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n  «·√⁄÷«¡";
	echo " </td>\n";
	echo "	<td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getCity.js\"></script>\n";
	echo "<a href=\"#\" onClick=\"return checkAll();\">≈Œ Ì«— «·ﬂ·</a> || <a href=\"#\" onClick=\" return checkNone();\">⁄œ„ ≈Œ Ì«— «·ﬂ·</a>";
	echo "<table  class=\"player\">\n";
	echo "<tr>";
	if ($SesTypIDGet == 0) {
		$i = 0;
		include 'db_conn.php';
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$SeasonIDGet' AND inseasonTeam='$TeamIDGet' AND inseasonType=0";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		$arrayPlayer = array();
		$arrayInSes = array();
		while($rowInSes = mysql_fetch_assoc($queryresultInSes)){
			$PlayerInSes = $rowInSes['inseasonMember'];
			array_push($arrayInSes, "$PlayerInSes");
		}
		$sqlPlayer = "SELECT * FROM players WHERE playerTeam='$TeamIDGet' ORDER BY playerFirstNameAr";
		$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
		while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
			$playerID = $rowPlayer['playerID'];
			array_push($arrayPlayer, "$playerID");
		}
		$SubsPlayer = array_diff($arrayPlayer,$arrayInSes);
		$PlayerResorted = array_values($SubsPlayer);
		//while ($rowPlayer = mysql_fetch_assoc($queryresultPlayer)) {
		for ($iPlayer = 0; $iPlayer < sizeof($PlayerResorted);$iPlayer++) {
			$playerIDOutOfSes = $PlayerResorted[$iPlayer];
			$sqlPlayerOutOfSes = "SELECT * FROM players WHERE playerID='$playerIDOutOfSes'";
			$queryresultPlayerOutOfSes = mysql_query($sqlPlayerOutOfSes)
				or die(mysql_error());
			$rowPlayerOutOfSes = mysql_fetch_assoc($queryresultPlayerOutOfSes);
			$PlayerFirstNameAr = $rowPlayerOutOfSes['playerFirstNameAr'];
			$PlayerMidNameAr = $rowPlayerOutOfSes['playerMidNameAr'];
			$PlayerLastNameAr = $rowPlayerOutOfSes['playerLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"checkbox\" name=\"players[]\" value=\"$playerIDOutOfSes\"> $PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</td>";
			$i ++;
		}
	mysql_free_result($queryresultPlayer);
	mysql_free_result($queryresultInSes);
	}
	elseif ($SesTypIDGet == 1) {
		$i = 0;
		include 'db_conn.php';
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$SeasonIDGet' AND inseasonTeam='$TeamIDGet' AND inseasonType=0";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		$arrayManager = array();
		$arrayInSesM = array();
		while($rowInSes = mysql_fetch_assoc($queryresultInSes)){
			$PlayerInSes = $rowInSes['inseasonMember'];
			array_push($arrayInSesM, "$PlayerInSes");
		}
		$sqlManager = "SELECT * FROM managers WHERE managerTeam='$TeamIDGet' ORDER BY managerFirstNameAr";
		$queryresultManager = mysql_query($sqlManager)
			or die(mysql_error());
		while ($rowManager = mysql_fetch_assoc($queryresultManager)) {
			$managerID = $rowManager['managerID'];
			array_push($arrayManager, "$managerID");
		}
		$manager = array_diff($arrayManager,$arrayInSesM);
		$managerResorted = array_values($manager);
		//while ($rowPlayer = mysql_fetch_assoc($queryresultPlayer)) {
		for ($iMgr = 0; $iMgr < sizeof($managerResorted);$iMgr++) {
			$managerIDOutOfSes = $managerResorted[$iMgr];
			$sqlMgrOutOfSes = "SELECT * FROM managers WHERE managerID='$managerIDOutOfSes'";
			$queryresultMgrOutOfSes = mysql_query($sqlMgrOutOfSes)
				or die(mysql_error());
			$rowMgrOutOfSes = mysql_fetch_assoc($queryresultMgrOutOfSes);
			$managerFirstNameAr = $rowMgrOutOfSes['managerFirstNameAr'];
			$managerLastNameAr = $rowMgrOutOfSes['managerLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"checkbox\" name=\"players[]\" value=\"$managerIDOutOfSes\"> $managerFirstNameAr $managerLastNameAr</td>";
			$i ++;
		}
		mysql_free_result($queryresultManager);
		mysql_free_result($queryresultInSes);
	}
	elseif ($SesTypIDGet == 2) {
		$i = 0;
		include 'db_conn.php';
		$sqlChairman = "SELECT * FROM  chairmen WHERE  chairmanTeam='$TeamIDGet' ORDER BY chairmanFirstNameAr";
		$queryresultChairman = mysql_query($sqlChairman)
			or die(mysql_error());
		while ($rowChairman = mysql_fetch_assoc($queryresultChairman)) {
			$ChairmanID = $rowChairman['chairmanID'];
			$ChairmanFirstNameAr = $rowChairman['chairmanFirstNameAr'];
			$ChairmanLastNameAr = $rowChairman['chairmanLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"checkbox\" name=\"players[]\" value=\"$ChairmanID\"> $ChairmanFirstNameAr $ChairmanLastNameAr</td>";
			$i ++;
		}
		mysql_free_result($queryresultChairman);
	}
	echo "	</tr>\n";
	echo "</table>\n";
	echo "<script type=\"text/javascript\" src=\"../js/checkAll.js\"></script>";
	echo "<div id=\"cityList\"></div>";
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

elseif (isset($_GET["season"]) && isset($_GET["team"])) {
	$SeasonIDGet = $_GET["season"];
	$TeamIDGet = $_GET["team"];
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n";
	echo season($SeasonIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ</td>\n";
	echo "	<td>\n";
	echo TeamNameAr($TeamIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n";
	echo "<select name = \"match\" id =\"match\" onChange=\"location.href='addInSeason.php?season=".$SeasonIDGet."&team=".$TeamIDGet."&type='+this.options[this.selectedIndex].value;\">";
	echo makeSesType();
	echo "	</td></tr>\n";
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
	echo "	<td>\n <select name = \"match\" id =\"match\" onChange=\"location.href='addInSeason.php?season=".$SeasonIDGet."&team='+this.options[this.selectedIndex].value;\">";
	echo "	<option value=\"\"> </option>";
	$sqlMatch = "SELECT * FROM teams";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$teamID = $rowMatch['teamID'];
		$teamNameAr = $rowMatch['teamNameAr'];
		$teamCity = $rowMatch['teamCity'];
		echo "	<option value=\"$teamID\">$teamNameAr - ".CityNameAr($teamCity)."</option>";
	}
	mysql_free_result($queryresultMatch);
	echo "	</select></td></tr>\n";
}

else {
	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\" onChange=\"location.href='addInSeason.php?season='+this.options[this.selectedIndex].value;\">";
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

if (isset($_POST['players']) && isset($_GET["season"]) && isset($_GET["team"])  && isset($_GET["type"])) {
	include 'db_conn.php';
	$playersPost = $_POST['players'];
	$season = $_GET["season"];
	$team = $_GET["team"];
	$type = $_GET["type"];
	foreach ($playersPost as $players){
		$sql = "INSERT INTO inseason (`inseasonSeason`, `inseasonTeam`, `inseasonMember`, `inseasonType`)
							VALUES ('$season', '$team', '$players', '$type');";
		mysql_query($sql) or die (mysql_error());
	}
	echo " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	echo redirection();
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>