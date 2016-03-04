<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
if (isset($_GET['Lang'])) {
	$lang = $_GET['Lang'];
} else {
	$lang = "ar";
}

if ($lang == "ar") {
	echo makeHeader("Player");
} elseif ($lang == "en") {
	echo makeHeaderEn("Player");
}

// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "<tr class=\"mcenter\">\n";

if (isset($_GET["ID"])) {
	$IDGet = $_GET["ID"];

	$sqlPlayer = "SELECT * FROM players WHERE playerID='$IDGet'";
	$queryresultPlayer = mysql_query($sqlPlayer)
		or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	if ($lang == "ar") {
		$firstName = $rowPlayer['playerFirstNameAr'];
		$MidName = $rowPlayer['playerMidNameAr'];
		$lastName = $rowPlayer['playerLastNameAr'];
	}
	elseif ($lang == "en") {
		$firstName = $rowPlayer['playerFirstNameEn'];
		$MidName = $rowPlayer['playerMidNameEn'];
		$lastName = $rowPlayer['playerLastNameEn'];
	}

	$DOB = $rowPlayer['playerDOB'];
	$POB = $rowPlayer['playerPOB'];
	$Nationality = $rowPlayer['playerNationality'];
	$height = $rowPlayer['playerHeight'];
	$Position = $rowPlayer['playerPosition'];
	$Pic = $rowPlayer['playerPic'];
	$team = $rowPlayer['playerTeam'];

	$beginTable .= "<td colspan=\"3\"><strong>$firstName $MidName $lastName</strong></td>\n";
	$beginTable .= "</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	if ($lang == "ar") {
		$beginTable .= " «—ÌŒ «·„Ì·«œ";
	}
	elseif ($lang == "en") {
		$beginTable .= "Date of birth";
	}
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";
	$beginTable .= "<strong> $DOB (";
	$beginTable .= GetAge($DOB);
	$beginTable .= ") </strong></td>\n";
	$beginTable .= "<td rowspan=\"5\">\n";
	$beginTable .= "<img src=\"players/$Pic\">";
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	if ($lang == "ar") {
		$beginTable .= "„ﬂ«‰ «·„Ì·«œ";
	}
	elseif ($lang == "en") {
		$beginTable .= "Place of birth";
	}
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";

	$sqlcity = "SELECT * FROM city WHERE cityID='$POB'";
	$queryresultcity = mysql_query($sqlcity)
			or die(mysql_error());
	$rowCity = mysql_fetch_assoc($queryresultcity);
	if ($lang == "ar") {
		$cityName = $rowCity['cityNameAr'];
	}
	elseif ($lang == "en") {
		$cityName = $rowCity['cityNameEn'];
	}
	$cityCountry = $rowCity['cityContry'];
	$sqlNat = "SELECT * FROM nationality WHERE nationalityID='$cityCountry'";
	$queryresultNat = mysql_query($sqlNat)
		or die(mysql_error());
	$rowNat = mysql_fetch_assoc($queryresultNat);
	if ($lang == "ar") {
		$countryName = $rowNat['nationalityNameAr'];
	}
	elseif ($lang == "en") {
		$countryName = $rowNat['nationalityNameEn'];
	}
	$beginTable .= "<strong>$cityName - $countryName</strong>";
	mysql_free_result($queryresultcity);
	mysql_free_result($queryresultNat);


	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	if ($lang == "ar") {
		$beginTable .= "«·Ã‰”Ì…";
	}
	elseif ($lang == "en") {
		$beginTable .= "Nationality";
	}
	$beginTable .= "</td>\n";
	$beginTable .= "<td>\n";

	$sqlNationality = "SELECT * FROM nationality WHERE nationalityID='$Nationality'";
	$queryresultNationality = mysql_query($sqlNationality)
		or die(mysql_error());
	$rowNationality = mysql_fetch_assoc($queryresultNationality);
	if ($lang == "ar") {
		$NatAdjName = $rowNationality['nationalityAdjAr'];
	}
	elseif ($lang == "en") {
		$NatAdjName = $rowNationality['nationalityAdjEn'];
	}
	$NatFlag = $rowNationality['nationalityFlag'];
	$beginTable .= "<strong>$NatAdjName</strong> <img src=\"flags/$NatFlag\">";
	mysql_free_result($queryresultNationality);

	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	if ($lang == "ar") {
		$beginTable .= "«·ÿÊ·";
		$beginTable .= "</td>\n";
		$beginTable .= "<td>\n";
		$beginTable .= "<strong>$height ”„</strong>";
	}
	elseif ($lang == "en") {
		$beginTable .= "Height";
		$beginTable .= "</td>\n";
		$beginTable .= "<td>\n";
		$beginTable .= "<strong>$height cm</strong>";
	}
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "<tr>\n<td>\n";
	if ($lang == "ar") {
		$beginTable .= "«·„—ﬂ“";
		$beginTable .= "</td>\n";
		$beginTable .= "<td>\n";
		global $positionAr;
		$beginTable .= "<strong>$positionAr[$Position]</strong>";
	}
	elseif ($lang == "en") {
		$beginTable .= "Position";
		$beginTable .= "</td>\n";
		$beginTable .= "<td>\n";
		global $positionEn;
		$beginTable .= "<strong>$positionEn[$Position]</strong>";
	}
	$beginTable .= "</td>\n</tr>\n";
	$beginTable .= "</table>\n";
	$beginTable .= "</div>";

	echo $beginTable;
	mysql_free_result($queryresultPlayer);

	$beginstatTable = "<div id = \"maincontent\">\n";
	$beginstatTable .= "<table  class=\"mcenter\">\n";
	$beginstatTable .= "<tr class=\"mcenter\">\n";
	if ($lang == "ar") {
		$beginstatTable .= "<td colspan=\"8\"><strong>≈Õ’«∆Ì«  «··«⁄»</strong></td>\n";
		$beginstatTable .= "</tr>\n";
		$beginstatTable .= "<tr>\n<td width=\"25%\">\n";
		$beginstatTable .= "«·„Ê«”„";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"15%\">\n";
		$beginstatTable .= " √”«”Ì ";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= " »œÌ·";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= " «·œﬁ«∆ﬁ";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td  width=\"10%\">\n";
		$beginstatTable .= "«·√Âœ«›";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "«· „—Ì—« ";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "ﬂ—Ê  ’›—«¡";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "ﬂ—Ê  Õ„—«¡";
		$beginstatTable .= "</td>\n</tr>\n";
	}
	elseif ($lang == "en") {
		$beginstatTable .= "<td colspan=\"8\"><strong>Individual statistics</strong></td>\n";
		$beginstatTable .= "</tr>\n";
		$beginstatTable .= "<tr>\n<td width=\"25%\">\n";
		$beginstatTable .= "Seasons";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"15%\">\n";
		$beginstatTable .= "Played";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "Substitute";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "Minutes";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td  width=\"10%\">\n";
		$beginstatTable .= "Goals";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "Assists";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "Yellow cards";
		$beginstatTable .= "</td>\n";
		$beginstatTable .= "<td width=\"10%\">\n";
		$beginstatTable .= "Red cards";
		$beginstatTable .= "</td>\n</tr>\n";
	}
	$matchPlayedLinedUp = 0;
	$matchPlayedSubs = 0;
	$matchPlayedMins = 0;
	$goalsNum = 0;
	$yellowCard = 0;
	$redCard = 0;
	$Assists = 0;
	$goalsNumEach = 0;
	$AssistsEach = 0;
	$yellowCardEach = 0;
	$redCardEach = 0;

	echo $beginstatTable;
	$statTable = "";
	$sqlInSeason = "SELECT * FROM inseason WHERE inseasonMember='$IDGet' AND inseasonType='0'";
	$queryresultInSeason = mysql_query($sqlInSeason)
	or die(mysql_error());
	while($rowInSeason = mysql_fetch_assoc($queryresultInSeason)){
		$inSesSeason = $rowInSeason['inseasonSeason'];
		$inSesTeam = $rowInSeason['inseasonTeam'];
		$statTable .= "<tr>\n";
		$statTable .= "<td>\n";
		$sqlSeason = "SELECT * FROM season WHERE seasonID='$inSesSeason'";
		$queryresultSeason = mysql_query($sqlSeason)
			or die(mysql_error());
		$rowSeason = mysql_fetch_assoc($queryresultSeason);
		$start = $rowSeason['seasonYearStart'];
		$end = $rowSeason['seasonYearEnd'];
		$statTable .= " <a href=\"javascript:ChangeTbl('$inSesSeason');\">+</a>$start - $end\n";
		$statTable .= "</td>\n";
		$detailedTable = "<tr><td colspan=\"8\">\n";
		$detailedTable .= "<table class=\"mcenter\" style=\"display:none;\" id=\"$inSesSeason\">\n";
		$iColor = 1;
		$dateStarting = "$start-07-01";
		$dateFinishin = "$end-06-01";

		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin')
		AND (matchTeamHome='$inSesTeam' OR matchTeamAway='$inSesTeam') ORDER BY matchComp,matchDate";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
			$matchID = $rowMatch['matchID'];

			// check the matches that the player played in
			$matchTeamHome = $rowMatch['matchTeamHome'];
			$matchTeamAway = $rowMatch['matchTeamAway'];
			$Comp = $rowMatch['matchComp'];

			$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchID' AND inmatchTeam='$inSesTeam' AND inmatchMember='$IDGet' AND
			(inmatchType=0 OR inmatchType=5 OR inmatchType=6 )"; // inmatchType=1 OR
			$queryresultInMatch = mysql_query($sqlInMatch)
				or die(mysql_error());
			while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
				$inMatchType = $rowInMatch['inmatchType'];
				$inMatchMatch = $rowInMatch['inmatchMatch'];
				$sqlMatchAnalyHalf = "SELECT analysisMins FROM matchanalysis WHERE analysisMatch='$inMatchMatch' AND analysisHalf='0'
				AND analysisEvent='0' AND analysisPlayer='0' ORDER BY analysisID DESC";
				$queryresultMatchAnalyHalf = mysql_query($sqlMatchAnalyHalf)
								or die(mysql_error());
				if (mysql_num_rows($queryresultMatchAnalyHalf) == 0) {
					break 1;
				}
				while ($rowMatchAnalyHalf = mysql_fetch_assoc($queryresultMatchAnalyHalf)) {
				$matchMin = $rowMatchAnalyHalf['analysisMins'];
					if ($matchMin == 120) {
						$matchMinute = 120;
						break;
					}
					elseif ($matchMin == 90) {
						$matchMinute = 90;
						break;
					}
				}
				if ($iColor % 2 == 0) {
					$trClass = " class=\"Matches\"";
				}
				else {
					$trClass = " class=\"hilalMatches\"";
				}
				if ($matchTeamHome == $inSesTeam) {
					$detailedTable .= "<tr $trClass>\n<td width=\"25%\">\n";
					if ($lang == "ar") {
						$detailedTable .= "<a href=\"liveMatch.php?match=$matchID\">";
						$detailedTable .= TeamNameAr($matchTeamAway);
						$detailedTable .= "</a>";
						$detailedTable .= "(H) <br>";
						$detailedTable .= CompAr($Comp);
					}
					elseif ($lang == "en") {
						$detailedTable .= "<a href=\"liveMatch.php?match=$matchID\">";
						$detailedTable .= TeamNameEn($matchTeamAway);
						$detailedTable .= "</a>";
						$detailedTable .= "(H) <br>";
						$detailedTable .= CompEn($Comp);
					}
					$detailedTable .= "</td>\n";
				} elseif ($matchTeamAway == $inSesTeam) {
					$detailedTable .= "<tr $trClass>\n<td width=\"25%\">\n";
					if ($lang == "ar") {
						$detailedTable .= "<a href=\"liveMatch.php?match=$matchID\">";
						$detailedTable .= TeamNameAr($matchTeamHome);
						$detailedTable .= "</a>";
						$detailedTable .= "(A) <br>";
						$detailedTable .= CompAr($Comp);
					}
					elseif ($lang == "en") {
						$detailedTable .= "<a href=\"liveMatch.php?match=$matchID\">";
						$detailedTable .= TeamNameEn($matchTeamHome);
						$detailedTable .= "</a>";
						$detailedTable .= "(A) <br>";
						$detailedTable .= CompEn($Comp);
					}
					$detailedTable .= "</td>\n";
				}
				switch($inMatchType){
					case 0:
						$matchPlayedLinedUp ++;
						$matchPlayedMins += $matchMinute;

						$detailedTable .= "<td width=\"15%\">\n";
						$detailedTable .= "1 \n";
						$detailedTable .= "</td>\n";
						$detailedTable .= "<td width=\"10%\">\n";
						$detailedTable .= "0 \n";
						$detailedTable .= "</td>\n";
						$detailedTable .= "<td width=\"10%\">\n";
						$detailedTable .= "$matchMinute\n";
						$detailedTable .= "</td>\n";
						break;
					case 5:
						//$matchPlayedLinedUp ++;
						$matchPlayedSubs ++;;
						$sqlMatchAnaly = "SELECT analysisMins FROM matchanalysis WHERE analysisMatch='$inMatchMatch' AND analysisPlayer='$IDGet' AND analysisEvent='1'";
						$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
							or die(mysql_error());
						$rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly);
						$MatchAnalyMin = $rowMatchAnaly['analysisMins'];
						$matchPlayedMins += ($matchMinute - $MatchAnalyMin);

						$detailedTable .= "<td width=\"15%\">\n";
						$detailedTable .= "0\n";
						$detailedTable .= "</td>\n";
						$detailedTable .= "<td width=\"10%\">\n";
						$detailedTable .= "1 \n";
						$detailedTable .= "</td>\n";
						$detailedTable .= "<td width=\"10%\">\n";
						$detailedTable .= $matchMinute - $MatchAnalyMin;
						$detailedTable .= "</td>\n";
						break;
					case 6:
						$matchPlayedLinedUp ++;;
						$sqlMatchAnaly = "SELECT analysisMins FROM matchanalysis WHERE analysisMatch='$inMatchMatch' AND analysisPlayer='$IDGet' AND (analysisEvent='1' OR analysisEvent='4')";
						$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
							or die(mysql_error());
						$rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly);
						$MatchAnalyMin = $rowMatchAnaly['analysisMins'];
						$matchPlayedMins += $MatchAnalyMin;

						$detailedTable .= "<td width=\"15%\">\n";
						$detailedTable .= "1\n";
						$detailedTable .= "</td>\n";
						$detailedTable .= "<td width=\"10%\">\n";
						$detailedTable .= "0 \n";
						$detailedTable .= "</td>\n";
						$detailedTable .= "<td width=\"10%\">\n";
						$detailedTable .= $MatchAnalyMin;
						$detailedTable .= "</td>\n";
						break;
				} // switch

				$sqlMatchAnaly = "SELECT * FROM matchanalysis WHERE analysisMatch='$inMatchMatch' AND analysisPlayer='$IDGet'";
				$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
					or die(mysql_error());
				while ($rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly)) {
					 $MatchAnalyEvent = $rowMatchAnaly['analysisEvent'];
					if ($MatchAnalyEvent == 2) {
						$goalsNum ++;
						$goalsNumEach ++;
					}
					elseif ($MatchAnalyEvent == 3) {
						$yellowCard ++;
						$yellowCardEach ++;
					}
					elseif ($MatchAnalyEvent == 4) {
						$redCard ++;
						$redCardEach ++;
					}
					elseif ($MatchAnalyEvent == 5) {
						$Assists ++;
						$AssistsEach ++;
					}
				}
				$detailedTable .= "<td width=\"10%\">\n";
				$detailedTable .= "$goalsNumEach\n";
				$detailedTable .= "</td>\n";
				$detailedTable .= "<td width=\"10%\">\n";
				$detailedTable .= "$AssistsEach\n";
				$detailedTable .= "</td>\n";
				$detailedTable .= "<td width=\"10%\">\n";
				$detailedTable .= "$yellowCardEach\n";
				$detailedTable .= "</td>\n";
				$detailedTable .= "<td width=\"10%\">\n";
				$detailedTable .= "$redCardEach\n";
				$detailedTable .= "</td>\n";
				$detailedTable .= "<td width=\"10%\">\n";
				$detailedTable .= "</td>\n";

				$detailedTable .= "</tr>\n";
				$goalsNumEach = 0;
				$AssistsEach = 0;
				$yellowCardEach = 0;
				$redCardEach = 0;
				$iColor ++;
			}
		}
		$statTable .= "<td>\n";
		$statTable .= "$matchPlayedLinedUp\n";
		$statTable .= "</td>\n";
		$statTable .= "<td>\n";
		$statTable .= "$matchPlayedSubs\n";
		$statTable .= "</td>\n";
		$statTable .= "<td>\n";
		$statTable .= "$matchPlayedMins\n";
		$statTable .= "</td>\n";
		$statTable .= "<td>\n";
		$statTable .= "$goalsNum\n";
		$statTable .= "</td>\n";
		$statTable .= "<td>\n";
		$statTable .= "$Assists\n";
		$statTable .= "</td>\n";
		$statTable .= "<td>\n";
		$statTable .= "$yellowCard\n";
		$statTable .= "</td>\n";
		$statTable .= "<td>\n";
		$statTable .= "$redCard\n";
		$statTable .= "</td>\n";
		$statTable .= "</tr>\n";
		$detailedTable .= "</table>\n";
		$detailedTable .= "</td>\n</tr>\n";
		echo $statTable;
		echo $detailedTable;

		$statTable = "";
		$detailedTable = "";
		$matchPlayedLinedUp = 0;
		$matchPlayedSubs = 0;
		$matchPlayedMins = 0;
		$goalsNum = 0;
		$yellowCard = 0;
		$redCard = 0;
		$Assists = 0;
		$goalsNumEach = 0;
		$AssistsEach = 0;
		$yellowCardEach = 0;
		$redCardEach = 0;
	}
}
echo "<script type=\"text/javascript\" src=\"js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"js/getNewDiv.js\"></script>\n";
echo "</table>\n";
echo "</div>";
// making footer
echo makeFooter();

?>