<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>MatchCenter</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/style1.css" />

</head>
<body>
<?php
include 'db_conn.php';
//require_once('AFunctions.php');
if (isset($_GET["teams"])) {
	$teamsCountGet = $_GET["teams"];

	function teamList($fieldName){
		echo "<select name=\"$fieldName\">";
		$sqlMatch = "SELECT * FROM teams";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
			$teamID = $rowMatch['teamID'];
			$teamNameAr = $rowMatch['teamNameAr'];
			echo "	<option value=\"$teamID\">$teamNameAr</option>";
		}
		mysql_free_result($queryresultMatch);
		echo "</select>";
	}

	if ($teamsCountGet == 16) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">16</td>\n";
		echo "<td class=\"cupTblTD\">8</td>\n";
		echo "<td class=\"cupTblTD\">4</td>\n";
		echo "<td class=\"cupTblTD\">2</td>\n";
		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"16\">ذهاب - إياب</td>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"8\">ذهاب - إياب</td>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"4\">ذهاب - إياب</td>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"2\">ذهاب - إياب\n";
		echo "<br /><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"3\">مباراة ثالث ورابع</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team11");
		echo " Vs ";
		echo teamList("team12");
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\"></td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"4\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team21");
		echo " Vs ";
		echo teamList("team22");
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team31");
		echo " Vs ";
		echo teamList("team32");
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 23 24
		echo teamList("team41");
		echo " Vs ";
		echo teamList("team42");
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		//31 32
		echo teamList("team51");
		echo " Vs ";
		echo teamList("team52");
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 33 34
		echo teamList("team61");
		echo " Vs ";
		echo teamList("team62");
		echo "</td>\n";
		echo "<td rowspan=\"4\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 41 42
		echo teamList("team71");
		echo " Vs ";
		echo teamList("team72");
		echo "</td>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		// 43 44
		echo teamList("team81");
		echo " Vs ";
		echo teamList("team82");
		echo "</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr></table>\n";
	}

	elseif ($teamsCountGet == 8) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">8</td>\n";
		echo "<td class=\"cupTblTD\">4</td>\n";
		echo "<td class=\"cupTblTD\">2</td>\n";
		echo "</tr><tr>\n";

		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"8\">ذهاب - إياب</td>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"4\">ذهاب - إياب</td>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"2\">ذهاب - إياب\n";
		echo "<br /><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"3\">مباراة ثالث ورابع</td>\n";

		echo "</tr><tr>\n";

		echo "<td rowspan=\"2\" class=\"cupTblTD\">\n";
		echo teamList("team11");
		echo " Vs ";
		echo teamList("team12");
		echo "</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"4\" class=\"cupTblTD\">&nbsp;</td>\n";
		echo "<td rowspan=\"3\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\" rowspan=\"3\">\n";
		echo teamList("team21");
		echo " Vs ";
		echo teamList("team22");
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"5\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"3\" class=\"cupTblTD\">\n";
		echo teamList("team31");
		echo " Vs ";
		echo teamList("team32");
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"4\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"3\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo teamList("team41");
		echo " Vs ";
		echo teamList("team42");
		echo "</td>\n";

		echo "</tr></table>\n";
	}

	elseif ($teamsCountGet == 4) {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">4</td>\n";
		echo "<td class=\"cupTblTD\">2</td>\n";
		echo "</tr><tr>\n";

		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"4\">ذهاب - إياب</td>\n";
		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"2\">ذهاب - إياب\n";
		echo "<br /><input type=\"checkbox\" name=\"RoundTrip[]\" value=\"3\">مباراة ثالث ورابع</td>\n";

		echo "</tr><tr>\n";

		echo "<td rowspan=\"2\" class=\"cupTblTD\">\n";
		echo teamList("team11");
		echo " Vs ";
		echo teamList("team12");
		echo "</td>\n";
		echo "<td>&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"2\" class=\"cupTblTD\">&nbsp;</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\">\n";
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td class=\"cupTblTD\" rowspan=\"3\">\n";
		echo teamList("team21");
		echo " Vs ";
		echo teamList("team22");
		echo "</td>\n";

		echo "</tr><tr>\n";
		echo "<td rowspan=\"2\">&nbsp;</td>\n";

		echo "</tr></table>\n";
	}

	mysql_close($conn);
}

elseif (isset($_GET["teamsGroups"])) {
	$teamsCountGet = $_GET["teamsGroups"];

	if ($teamsCountGet == 32) {
		$Group = $_GET["Group"];
		$season = $_GET["Season"];
		$comp = $_GET["Comp"];
		// if the group already has been added
		$sqlMatchsExist = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$season' AND matchComp='$comp' AND
		matchRound='32' AND matchGroup='$Group'";
		$queryresultMatchsExist = mysql_query($sqlMatchsExist)
						or die(mysql_error());
		$MatchRowNum = mysql_num_rows($queryresultMatchsExist);
		// End checking by the number of Rows !!

		if ($MatchRowNum == 0) {

			// start checking for excluding the team that has been already selected
			$sqlTeamsExist = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$season' AND matchComp='$comp' AND
		matchRound='32'";
			$queryresultTeamsExist = mysql_query($sqlTeamsExist)
				or die(mysql_error());
			$arrayTeamsExist = array();
			while($TeamsRow = mysql_fetch_assoc($queryresultTeamsExist)){
				$TeamExist = $TeamsRow['matchTeamHome'];
				array_push($arrayTeamsExist, "$TeamExist");
			}
			$sqlTeamsNotSelected = "SELECT * FROM teams";
			$queryresultTeamsNotSelected = mysql_query($sqlTeamsNotSelected)
				or die(mysql_error());
			$arrayTeamsNotSelected = array();
			while($TeamsNotRow = mysql_fetch_assoc($queryresultTeamsNotSelected)){
				$TeamNot = $TeamsNotRow['teamID'];
				array_push($arrayTeamsNotSelected, "$TeamNot");
			}
			$TeamsNotSelected = array_diff($arrayTeamsNotSelected,$arrayTeamsExist);
			$TeamsNotSelectedResorted = array_values($TeamsNotSelected);
			// END checking for excluding the team that has been already selected

			echo "<h4>المجموعة $Group</h4>";
			echo "<select name=\"matchs[]\" multiple=\"multiple\">";
			for ($LookUp = 0; $LookUp <sizeof($TeamsNotSelectedResorted);$LookUp++) {
				$teamLookUp = $TeamsNotSelectedResorted[$LookUp];
				$sqlMatch = "SELECT * FROM teams WHERE teamID='$teamLookUp'";
				$queryresultMatch = mysql_query($sqlMatch)
					or die(mysql_error());
				$rowMatch = mysql_fetch_assoc($queryresultMatch);
				$teamID = $rowMatch['teamID'];
				$teamNameAr = $rowMatch['teamNameAr'];
				$teamCity = $rowMatch['teamCity'];
				$sqlCity = "SELECT * FROM city WHERE cityID='$teamCity'";
				$queryresultCity = mysql_query($sqlCity)
					or die(mysql_error());
				$rowCity = mysql_fetch_assoc($queryresultCity);
				$CityAr = $rowCity['cityNameAr'];
				echo "	<option value=\"$teamID\">$teamNameAr - $CityAr</option>";
			}
			mysql_free_result($queryresultMatch);
			echo "</select>";
		} else {
			echo "تم اضافة هذه المجموعة مسبقا  <br>";
			while ($rowMatchExist = mysql_fetch_assoc($queryresultMatchsExist)) {
				$teamID = $rowMatchExist['matchTeamHome'];
				$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$teamID'";
				$queryresultTeam2 = mysql_query($sqlTeam2)
					or die(mysql_error());
				$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);
				$teamName = $rowTeam2['teamNameAr'];
				echo "$teamName, <br>";
			}
		}
	}
	else {
		echo "<table border=\"0\" width=\"100%\" id=\"table1\"><tr>\n";
		echo "<td class=\"cupTblTD\">$teamsCountGet</td>\n";
		echo "</tr><tr>\n";

		echo "<td class=\"cupTblTD\"><input type=\"checkbox\" name=\"RoundTripMatch\" value=\"$teamsCountGet\">ذهاب - إياب</td>\n";
		echo "</tr></table>\n";
	}
}

elseif (isset($_GET["CompSeason"])) {
	$compSeason = $_GET["CompSeason"];
	$teamsCount = $_GET["TeamNum"];
	echo "بداية الموسم الثاني بعد الدور";
	echo "<br>";
	echo "<select name=\"whichRound\">";
	$numberOfTeams1 = $teamsCount / 2 ;
	for ($i = 1; $i <= 3; $i ++) {
		echo "	<option value=\"$numberOfTeams1\">$numberOfTeams1</option>";
		$numberOfTeams1 /= 2;
	}
	echo "</select>";
}
?>
	</body>
</html>