<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>Match Center</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/style1.css" />

</head>
<body>
<?php
require_once('AFunctions.php');
include 'db_conn.php';

$type = $_COOKIE['username'];
if ($type > 0) {

	if (isset($_GET["matches"])) {
		$Players = $_GET["matches"];
		echo "<table class=\"mcenter\">\n";
		if (isset($_GET["season"]) && isset($_GET["comp"])) {
			$season = $_GET["season"];
			$comp = $_GET["comp"];

			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"4\"></td>\n";
			echo "	</tr>\n";
			echo "	<tr>\n <td colspan=\"4\">\n ";
			echo season($season);
			echo " <a href=\"javascript:CityExFile('getIndex.php','matches','All','showAdmin');\"> تعديل</a>";
			echo "</td>\n</tr>\n";
			echo "	<tr>\n <td colspan=\"4\">\n ";
			echo CompAr($comp);
			echo " <a href=\"javascript:CityExFile('getIndex.php','matches=1&season','$season','showAdmin');\"> تعديل</a>";
			echo "</td>\n</tr>\n";
			echo "	<tr>\n <td colspan=\"4\">\n ";
			echo " <a href=\"editMatchRound.php?season=$season&comp=$comp\">تعديل تاريخ - جولة - وقت</a>";
			echo "</td>\n</tr>\n";
			echo "	<tr>\n <td colspan=\"4\">\n ";
			// start comp table
			echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"100%\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
			// get the start date and end date of the selected season
			$sqlSes = "SELECT * FROM season WHERE seasonID='$season'";
			$queryresultSes = mysql_query($sqlSes)
			or die(mysql_error());
			$rowSes = mysql_fetch_assoc($queryresultSes);
			$start = $rowSes['seasonYearStart'];
			$end = $rowSes['seasonYearEnd'];
			$dateStarting = "$start-07-01";
			$dateFinishin = "$end-06-01";

			mysql_free_result($queryresultSes);
			// get the start date and end date of the selected season

			$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchComp='$comp' AND (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin')
			ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
			$queryresultMatch = mysql_query($sqlMatch)
					or die(mysql_error());
			$previousMatchDate = "";
			$TrClass = "";

			$sqlComp = "SELECT * FROM competition WHERE compID='$comp'";
			$queryresultComp = mysql_query($sqlComp)
				or die(mysql_error());
			$rowComp = mysql_fetch_assoc($queryresultComp);
			$CompSys = $rowComp['compSys'];
			mysql_free_result($queryresultComp);

			while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
				$dateMatch = $rowMatch['matchDate'];
				$matchSeason = $rowMatch['matchSeason'];
				$team1 = $rowMatch['matchTeamHome'];
				$team2 = $rowMatch['matchTeamAway'];
				$time = $rowMatch['matchTime'];
				$matchID = $rowMatch['matchID'];
				$round = $rowMatch['matchRound'];
				$group = $rowMatch['matchGroup'];
				$comment = $rowMatch['matchComment'];
				//check result
				$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
				$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
					or die(mysql_error());
				$result1 = 0;
				$result2 = 0;
				$penaltiesTeam1 = 0;
				$penaltiesTeam2 = 0;
				$MatchAnalysisRowsNumber = mysql_num_rows($queryresultMatchAnalysis);
				if ($MatchAnalysisRowsNumber == 0) {
					$result1 = "";
					$result2 = "";
					$penaltiesTeam1 = "";
					$penaltiesTeam2 = "";

				}
				else {
					while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
						$Mins = $rowMatchAnalysis['analysisMins'];
						$half = $rowMatchAnalysis['analysisHalf'];
						$Player = $rowMatchAnalysis['analysisPlayer'];
						$team = $rowMatchAnalysis['analysisTeam'];
						$analysEvent = $rowMatchAnalysis['analysisEvent'];
						if (($half == 0 && $Mins == 90) OR ($half == 0 && $Mins == 120)) {
							if ($result1 != 0 || $result2 != 0) {

							}
							else {
								$result1 = 0;
								$result2 = 0;
							}
						}
						elseif ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
							if ($team == $team1) {
								$result1 ++;
							}
							elseif ($team == $team2) {
								$result2 ++;
								}
						}
						elseif ($analysEvent == 2 && $half == 5) {
							if ($team == $team1) {
								$penaltiesTeam1 ++;
							}
							elseif ($team == $team2) {
								$penaltiesTeam2 ++;
							}
						}
					}
				}
				//end of checking result
				$outputTable = "";
				if ($previousMatchDate != $dateMatch) {
					$outputTable .= "<tr class=\"dates\"><td class=\"whiteBorder\" colspan=\"10\">";
					$dateDayEn = date('l', strtotime($dateMatch));
					$dateArr = array("Saturday"=>"السبت","Sunday"=>"الأحد","Monday"=>"الأثنين","Tuesday"=>"الثلاثاء","Wednesday"=>"الأربعاء","Thursday"=>"الخميس","Friday"=>"الجمعة");
					$dateDayAr = $dateArr[$dateDayEn];
					$outputTable .= "$dateDayAr $dateMatch</td></tr>";
				}
				if ($team1 == "1" || $team2 == "1") {
					//$strf=strtotime($time);
					$outputTable .=  "<tr class=\"hilalMatches\">";
					$outputTable .= "<td class=\"whiteBorder\">";
					$outputTable .= teamNameAr($team1);
					$outputTable .= "</td>";
					if (trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "" || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> $result1 - $result2 </a></td>";
					} else {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> $result1 - $result2 ";
						$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2) </a></td>";
					}
					$outputTable .= "<td class=\"whiteBorder\">";
					$outputTable .= teamNameAr($team2);
					$outputTable .= "</td>";
					$outputTable .= "<td class=\"whiteBorder\">$time</td>";
					// check if the competition was cup or league
					if ($CompSys == 0) {
						$outputTable .= "<td class=\"whiteBorder\"> الجولة ".$round."</td>";
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?League=$comp&Season=$matchSeason&Round=$round\">اضف نتائج الجولة </a></td>";
					}
					elseif ($CompSys == 1) {
						$outputTable .= "<td class=\"whiteBorder\"> دور الـ ".$round."</td>";
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?League=$comp&Season=$matchSeason&Round=$round\">اضف نتائج الدور </a></td>";
					}
					elseif ($CompSys == 2) {
						if ($round == 32) {
							$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?League=$comp&Season=$matchSeason&Group=$group\">اضف نتائج المجموعة".$group."</a></td>";
						} else {
							if ($team1 == "0" OR $team2 == "0") {
								$outputTable .= "<td class=\"whiteBorder\"><a href=\"addCupQualify.php?Season=$matchSeason&Comp=$comp\">أهل فريق لدور متقدم</a></td>";
							}
							else {
								$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?Cup=$comp&Season=$matchSeason&Round=$round\">اضف نتائج الدور ".$round."</a></td>";
							}
						}
						$outputTable .= "<td class=\"whiteBorder\"></td>";
					}
					$outputTable .= "</tr>";
					$outputTable .= "<tr class=\"hilalMatches\">";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddLinks.php?match=$matchID\">أضف روابط</a></td>";
					// END  checking if the competition was cup or league
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"javascript:ChangeTbl('$matchID');\">معلومات </a></td>";
					if ($comment != 0) {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"editComment.php?ID=$comment\"> ملاحظة</a></td>";
					} else {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"addComment.php?match=$matchID\"> ملاحظة</a></td>";
					}
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addMatchInfo.php?match=$matchID\"> ملاعب وحكام</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"editMatch.php?match=$matchID\"> تعديل</a></td>";
					if ($comment == 18) {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"postponed.php?match=$matchID&type=cancel\"> إلغاء التأجيل</a></td>";
					}
					else {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"postponed.php?match=$matchID&type=confirm\"> تأجلت</a></td>";
					}

					$outputTable .= "</tr>";
					$outputTable .= "<tr class=\"hilalMatches\"><td class=\"whiteBorder\" colspan=\"10\">";
					$outputTable .= "<table class=\"mcenter\">";
					$outputTable .= "<tr class=\"hilalMatches\" id=\"$matchID\" style=\"display:none;\">";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addInMatch.php?match=$matchID&team=$team1&type=0\"> إضافة تشكيلة ";
					$outputTable .= teamNameAr($team1);
					$outputTable .= "</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> - </a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addInMatch.php?match=$matchID&team=$team2&type=0\"> إضافة تشكيلة ";
					$outputTable .= teamNameAr($team2);
					$outputTable .= "</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addMatchAnalysis.php?match=$matchID\"> إضافة احداث المباراة </a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addKitsInMatch.php?match=$matchID\"> إضافة أطقم الفرق في المباراة</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"> </td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addAdvanceAnalysis.php?match=$matchID&team=1\"> إضافة إحصائيات مفصلة</a></td>";
					$outputTable .= "</tr>";
					$outputTable .= "</table>";
					$outputTable .= "</td></tr>";
					$outputTable .= "</tr>";
				}
				else {
					$outputTable .= "<tr class=\"Matches\">";
					$outputTable .= "<td class=\"whiteBorder\">";
					$outputTable .= teamNameAr($team1);
					$outputTable .= "</td>";
					if ((trim($penaltiesTeam1) == "" || trim($penaltiesTeam2) == "") || ($penaltiesTeam1 == 0 && $penaltiesTeam2 == 0)) {
						$outputTable .= "<td class=\"whiteBorder\">$result1 - $result2</td>";
					} else {
						$outputTable .= "<td class=\"whiteBorder\"> $result1 - $result2 ";
						$outputTable .= "<br> ($penaltiesTeam1 - $penaltiesTeam2)</td>";
					}
					$outputTable .= "<td class=\"whiteBorder\">";
					$outputTable .= teamNameAr($team2);
					$outputTable .= "</td>";
					$outputTable .= "<td class=\"whiteBorder\">$time</td>";
					// check if the competition was cup or league
					if ($CompSys == 0) {
						$outputTable .= "<td class=\"whiteBorder\"> الجولة ".$round."</td>";
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?League=$comp&Season=$matchSeason&Round=$round\">اضف نتائج الجولة </a></td>";
					}
					elseif ($CompSys == 1) {
						$outputTable .= "<td class=\"whiteBorder\"> دور الـ ".$round."</td>";
						if ($team1 == "0" OR $team2 == "0") {
							$outputTable .= "<td class=\"whiteBorder\"><a href=\"addCupQualify.php?Season=$matchSeason&Comp=$comp\">أهل فريق لدور متقدم</a></td>";
						}
						else {
							$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?Cup=$comp&Season=$matchSeason&Round=$round\">اضف نتائج الدور </a></td>";
						}
					}
					elseif ($CompSys == 2) {
						if ($round == 32) {
							$outputTable .= "<td class=\"whiteBorder\">المجموعة".$group."</td>";
							$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?League=$comp&Season=$matchSeason&Group=$group\">اضف نتائج الدور </a></td>";
						} else {
							$outputTable .= "<td class=\"whiteBorder\"> دور الـ ".$round."</td>";
							if ($team1 == "0" OR $team2 == "0") {
								$outputTable .= "<td class=\"whiteBorder\"><a href=\"addCupQualify.php?Season=$matchSeason&Comp=$comp\">أهل فريق لدور متقدم</a></td>";
							}
							else {
								$outputTable .= "<td class=\"whiteBorder\"><a href=\"AddCompResults.php?Cup=$comp&Season=$matchSeason&Round=$round\">اضف نتائج الدور </a></td>";
							}
						}
					}
					$outputTable .= "</tr>";
					$outputTable .= "<tr class=\"Matches\">";
					// END  checking if the competition was cup or league
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"javascript:ChangeTbl('$matchID');\">معلومات </a></td>";
					if ($comment != 0) {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"editComment.php?ID=$comment\"> ملاحظة</a></td>";
					} else {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"addComment.php?match=$matchID\"> ملاحظة</a></td>";
					}
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addMatchInfo.php?match=$matchID\"> ملاعب وحكام</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"editMatch.php?match=$matchID\"> تعديل</a></td>";
					if ($comment == 18) {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"postponed.php?match=$matchID&type=cancel\"> إلغاء التأجيل</a></td>";
					}
					else {
						$outputTable .= "<td class=\"whiteBorder\"><a href=\"postponed.php?match=$matchID&type=confirm\"> تأجلت</a></td>";
					}
					$outputTable .= "<td class=\"whiteBorder\"></td>";
					$outputTable .= "</tr>";

					$outputTable .= "<tr class=\"Matches\"><td class=\"whiteBorder\" colspan=\"10\">";
					$outputTable .= "<table class=\"mcenter\">";
					$outputTable .= "<tr class=\"Matches\" id=\"$matchID\" style=\"display:none;\">";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addInMatch.php?match=$matchID&team=$team1&type=0\"> إضافة تشكيلة ";
					$outputTable .= teamNameAr($team1);
					$outputTable .= "</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"../liveMatch.php?match=$matchID\"> - </a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addInMatch.php?match=$matchID&team=$team2&type=0\"> إضافة تشكيلة ";
					$outputTable .= teamNameAr($team2);
					$outputTable .= "</a></td>";
					$outputTable .= "<td class=\"whiteBorder\"><a href=\"addMatchAnalysis.php?match=$matchID\"> إضافة احداث المباراة </a></td>";
					$outputTable .= "</tr>";
					$outputTable .= "</table>";
					$outputTable .= "</td></tr>";
					$outputTable .= "</tr>";
				}
				if ($comment == 0) {
					$outputTable .= "";
				}
				else {
					$sqlComment = "SELECT * FROM comment WHERE commentID='$comment'";
					$queryresultComment = mysql_query($sqlComment)
						or die(mysql_error());
					$rowcomment = mysql_fetch_assoc($queryresultComment);
					$commentText = $rowcomment['commentText'];
					mysql_free_result($queryresultComment);
					$outputTable .= "</tr>";
					$outputTable .= "<tr class=\"hilalMatches\"><td class=\"whiteBorder\" colspan=\"10\">";
					$outputTable .= "<font class=\"Comment\">$commentText</font>";
					$outputTable .= "</td></tr>";
				}
				echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
				echo $outputTable;
				$previousMatchDate = $dateMatch;
			}
			echo "</table>\n";
			mysql_free_result($queryresultMatch);
			// end comp table
			echo "</td>\n</tr>\n";
		}
		elseif (isset($_GET["season"])) {
			$season = $_GET["season"];
			echo "	<tr>\n <td colspan=\"4\">\n ";
			echo season($season);
			echo "</td>\n</tr>\n";
			echo "	<tr>\n <td colspan=\"4\">\n ";
			$NextSeason = $season + 1;
			$sqlMatchComp = "SELECT DISTINCT matchComp FROM `matchcenter`.`match` WHERE (matchSeason='$season' OR matchSeason='$NextSeason')";
			$queryresultMatchComp = mysql_query($sqlMatchComp)
				or die(mysql_error());
			echo "<select name = \"comp\" id =\"comp\" onchange=\"CityExFile('getIndex.php','matches=1&season=$season&comp',this.value,'showAdmin');\">";
			echo "	<option value=\"\"></option>";
			while($rowMatchComp = mysql_fetch_assoc($queryresultMatchComp)){
				$CompID = $rowMatchComp['matchComp'];
				$sqlComp = "SELECT * FROM competition WHERE compID='$CompID'";
				$queryresultComp = mysql_query($sqlComp)
					or die(mysql_error());
				$rowComp = mysql_fetch_assoc($queryresultComp);
				$compNameAr = $rowComp['compNameAr'];
				echo "	<option value=\"$CompID\">$compNameAr</option>";
			}
			echo "	</select>\n";
			echo "</td>\n</tr>\n";
		}
		else {
			echo "	<tr>\n <td colspan=\"4\">\n ";
			$sqlMatchSes = "SELECT DISTINCT matchSeason FROM `matchcenter`.`match`";
			$queryresultMatchSes = mysql_query($sqlMatchSes)
				or die(mysql_error());
			echo "<select name = \"season\" id =\"season\" onchange=\"CityExFile('getIndex.php','matches=1&season',this.value,'showAdmin');\">";
			echo "	<option value=\"\"></option>";
			while($rowMatchSes = mysql_fetch_assoc($queryresultMatchSes)){
				$sesID = $rowMatchSes['matchSeason'];
				$sqlSes = "SELECT * FROM season WHERE seasonID='$sesID'";
				$queryresultSes = mysql_query($sqlSes)
					or die(mysql_error());
				$rowSes = mysql_fetch_assoc($queryresultSes);
				$yearStart = $rowSes['seasonYearStart'];
				$yearEnd = $rowSes['seasonYearEnd'];
				echo "	<option value=\"$sesID\">$yearStart - $yearEnd</option>";
			}
			echo "	</select>\n";
			echo "</td>\n</tr>\n";
		}
		echo "</table>";
	}

	elseif (isset($_GET["user"])) {
		$user = $_GET["user"];
		$type = $_COOKIE['username'];
		$userIDCookie = $_COOKIE['userID'];
		$WhereClause = "";
		//$userIDCookie = $_COOKIE['userID'];
		//$WhereClause = "WHERE userID='$userIDCookie' AND (Type  <=  '$type')";
		if ($type < 32) {
			$WhereClause = "WHERE userID='$userIDCookie'";
		}
		elseif ($type < 128) {
			$WhereClause = "WHERE Type < '$type'";
		}
		$sqlUser = "SELECT * FROM user $WhereClause";
		$queryresultUser = mysql_query($sqlUser)
			or die(mysql_error());

		$sqlUserSelf = "SELECT * FROM user WHERE userID='$userIDCookie'";
		$queryresultUserSelf = mysql_query($sqlUserSelf)
			or die(mysql_error());
		if($type < 32) {
			$rowUser = mysql_fetch_assoc($queryresultUser);
			$username = $rowUser['username'];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"2\">مرحبا بك يا $username</td>\n";
			echo "	</tr>\n";
			echo "	<tr class=\"Color1\">\n";
			echo "	<td> <a href=\"User.php?Type=password\">تعديل الباسوورد</a> </td>\n";
			echo "	<td> <a href=\"User.php?Type=email\">تعديل الإيميل</a> </td>\n";
			echo "	</tr>\n";
		} else {
			$rowUserSelf = mysql_fetch_assoc($queryresultUserSelf);
			$usernameSelf = $rowUserSelf['username'];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"5\">مرحبا بك يا $usernameSelf</td>\n";
			echo "	</tr>\n";
			echo "	<tr class=\"Color1\">\n";
			echo "	<td colspan=\"3\"> <a href=\"User.php?Type=password\">تعديل الباسوورد</a> </td>\n";
			echo "	<td colspan=\"2\"> <a href=\"User.php?Type=email\">تعديل الإيميل</a> </td>\n";
			echo "	</tr>\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"5\"><a class=\"nav\" href=\"User.php?Type=add\"> أضف عضو جديد </a></td>\n";
			echo "	</tr>\n";
			$i=1;
			while($rowUser = mysql_fetch_assoc($queryresultUser)){
				$userID = $rowUser['userID'];
				$username = $rowUser['username'];
				if ($userID != $userIDCookie) {
					if ($i % 2 == 0) {
						echo "	<tr class=\"Color1\">\n";
						echo "	<td> $userID </td>\n";
						echo "	<td> $username </td>\n";
						echo "	<td> <a href=\"User.php?Type=password&user=$userID\">تعديل الباسوورد</a> </td>\n";
						echo "	<td> <a href=\"User.php?Type=email&user=$userID\">تعديل الإيميل</a> </td>\n";
						echo "	<td> <a href=\"User.php?Type=Privilage&user=$userID\">تعديل الرتبه</a> </td>\n";
						echo "	</tr>\n";
						$i ++;
					} else {
						echo "	<tr class=\"Color2\">\n";
						echo "	<td> $userID </td>\n";
						echo "	<td> $username </td>\n";
						echo "	<td> <a href=\"User.php?Type=password&user=$userID\">تعديل الباسوورد</a> </td>\n";
						echo "	<td> <a href=\"User.php?Type=email&user=$userID\">تعديل الإيميل</a> </td>\n";
						echo "	<td> <a href=\"User.php?Type=Privilage&user=$userID\">تعديل الرتبه</a> </td>\n";
						echo "	</tr>\n";
						$i ++;
					}
				}
			}
			echo "</table>";
		}
	}

	if ($type > 16) {

		if (isset($_GET["players"])) {
			$Players = $_GET["players"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"5\"><a class=\"nav\" href=\"Player.php?Type=add\"> أضف لاعب جديد </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM players";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$playerID = $rowPlayer['playerID'];
				$firstNameAr = $rowPlayer['playerFirstNameAr'];
				$MidNameAr = $rowPlayer['playerMidNameAr'];
				$lastNameAr = $rowPlayer['playerLastNameAr'];
				$Position = $rowPlayer['playerPosition'];
				$team = $rowPlayer['playerTeam'];
				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $playerID </td>\n";
					echo "	<td> $firstNameAr $MidNameAr $lastNameAr </td>\n";
					echo "	<td>";
					echo TeamNameAr($team);
					echo "</td>\n";
					global $positionAr;
					echo "	<td> ".$positionAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Player.php?Type=edit&ID=$playerID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $playerID </td>\n";
					echo "	<td> $firstNameAr $MidNameAr $lastNameAr </td>\n";
					echo "	<td>";
					echo TeamNameAr($team);
					echo "</td>\n";
					global $positionAr;
					echo "	<td> ".$positionAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Player.php?Type=edit&ID=$playerID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["managers"])) {
			$Players = $_GET["managers"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"5\"><a class=\"nav\" href=\"Managers.php?Type=add\"> أضف مدرب جديد </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM managers";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['managerID'];
				$firstNameAr = $rowPlayer['managerFirstNameAr'];
				$lastNameAr = $rowPlayer['managerLastNameAr'];
				$Position = $rowPlayer['managerLevel'];
				$team = $rowPlayer['managerTeam'];
				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $firstNameAr $lastNameAr </td>\n";
					echo "	<td>";
					echo TeamNameAr($team);
					echo "</td>\n";
					global $LevelAr;
					echo "	<td> ".$LevelAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Managers.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $firstNameAr  $lastNameAr </td>\n";
					echo "	<td>";
					echo TeamNameAr($team);
					echo "</td>\n";
					global $LevelAr;
					echo "	<td> ".$LevelAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Managers.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["chairmen"])) {
			$Players = $_GET["chairmen"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"5\"><a class=\"nav\" href=\"Chairmen.php?Type=add\"> أضف إداري جديد </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM chairmen";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['chairmanID'];
				$firstNameAr = $rowPlayer['chairmanFirstNameAr'];
				$lastNameAr = $rowPlayer['chairmanLastNameAr'];
				$Position = $rowPlayer['chairmanPosition'];
				$team = $rowPlayer['chairmanTeam'];
				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $firstNameAr $lastNameAr </td>\n";
					echo "	<td>";
					echo TeamNameAr($team);
					echo "</td>\n";
					global $AdminAr;
					echo "	<td> ".$AdminAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Chairmen.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $firstNameAr  $lastNameAr </td>\n";
					echo "	<td>";
					echo TeamNameAr($team);
					echo "</td>\n";
					global $AdminAr;
					echo "	<td> ".$AdminAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Chairmen.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["referee"])) {
			$Players = $_GET["referee"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"4\"><a class=\"nav\" href=\"Referee.php?Type=add\"> أضف حكم جديد </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM referee";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['refereeID'];
				$firstNameAr = $rowPlayer['refereeFirstNameAr'];
				$lastNameAr = $rowPlayer['refereeLastNameAr'];
				$Position = $rowPlayer['refereeType'];

				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $firstNameAr $lastNameAr </td>\n";
					global $refClassAr;
					echo "	<td> ".$refClassAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Referee.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $firstNameAr  $lastNameAr </td>\n";
					global $refClassAr;
					echo "	<td> ".$refClassAr[$Position]." </td>\n";
					echo "	<td> <a href=\"Referee.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["clubs"])) {
			$Players = $_GET["clubs"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"4\"><a class=\"nav\" href=\"Club.php?Type=add\"> أضف نادي جديد </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM teams";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['teamID'];
				$NameAr = $rowPlayer['teamNameAr'];
				$city = $rowPlayer['teamCity'];

				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td> ";
					echo CityNameAr($city);
					echo" </td>\n";
					echo "	<td> <a href=\"Club.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td> ";
					echo CityNameAr($city);
					echo" </td>\n";
					echo "	<td> <a href=\"Club.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["stadium"])) {
			$Players = $_GET["stadium"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"4\"><a class=\"nav\" href=\"Stadium.php?Type=add\"> أضف ملعب جديد </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM stadiums";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['stadiumID'];
				$NameAr = $rowPlayer['stadiumNameAr'];
				$city = $rowPlayer['stadiumCity'];

				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td> ";
					echo CityNameAr($city);
					echo" </td>\n";
					echo "	<td> <a href=\"Stadium.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td> ";
					echo CityNameAr($city);
					echo" </td>\n";
					echo "	<td> <a href=\"Stadium.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["country"])) {
			$Players = $_GET["country"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"4\"><a class=\"nav\" href=\"Country.php?Type=add\"> أضف دولة جديده </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM nationality";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['nationalityID'];
				$NameAr = $rowPlayer['nationalityNameAr'];
				$flag = $rowPlayer['nationalityFlag'];

				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td> <img src=\"../flags/$flag\"> </td>\n";
					echo "	<td> <a href=\"Country.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td> <img src=\"../flags/$flag\"> </td>\n";
					echo "	<td> <a href=\"Country.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		elseif (isset($_GET["city"])) {
			$Players = $_GET["city"];
			echo "<table class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"4\"><a class=\"nav\" href=\"City.php?Type=add\"> أضف مدينة جديده </a></td>\n";
			echo "	</tr>\n";
			$sqlPlayer = "SELECT * FROM city";
			$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
			$i=1;
			while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
				$ID = $rowPlayer['cityID'];
				$NameAr = $rowPlayer['cityNameAr'];
				$country = $rowPlayer['cityContry'];

				if ($i % 2 == 0) {
					echo "	<tr class=\"Color1\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td>";
					echo CountryNameAr($country);
					echo "</td>\n";
					echo "	<td> <a href=\"City.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				} else {
					echo "	<tr class=\"Color2\">\n";
					echo "	<td> $ID </td>\n";
					echo "	<td> $NameAr </td>\n";
					echo "	<td>";
					echo CountryNameAr($country);
					echo "</td>\n";
					echo "	<td> <a href=\"City.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
					echo "	</tr>\n";
					$i ++;
				}
			}
			echo "</table>";
		}

		if ($type > 64) {

			if (isset($_GET["comp"]) && !isset($_GET["matches"])) {
				$Players = $_GET["comp"];
				echo "<table class=\"mcenter\">\n";
				echo "	<tr class=\"mcenter\">\n";
				echo "	<td colspan=\"5\"><a class=\"nav\" href=\"Comp.php?Type=add\"> أضف مسابقة جديده </a></td>\n";
				echo "	</tr>\n";
				$sqlPlayer = "SELECT * FROM competition";
				$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
				$i=1;
				while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
					$ID = $rowPlayer['compID'];
					$NameAr = $rowPlayer['compNameAr'];
					$sys = $rowPlayer['compSys'];
					$country = $rowPlayer['compCountry'];
					global $CompSysAr;
					if ($i % 2 == 0) {
						echo "	<tr class=\"Color1\">\n";
						echo "	<td> $ID </td>\n";
						echo "	<td> $NameAr </td>\n";
						echo "	<td> ".$CompSysAr[$sys]." </td>\n";
						echo "	<td>";
						echo CountryNameAr($country);
						echo "</td>\n";
						echo "	<td> <a href=\"Comp.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
						echo "	</tr>\n";
						$i ++;
					} else {
						echo "	<tr class=\"Color2\">\n";
						echo "	<td> $ID </td>\n";
						echo "	<td> $NameAr </td>\n";
						echo "	<td> ".$CompSysAr[$sys]." </td>\n";
						echo "	<td>";
						echo CountryNameAr($country);
						echo "</td>\n";
						echo "	<td> <a href=\"Comp.php?Type=edit&ID=$ID\">تعديل</a> </td>\n";
						echo "	</tr>\n";
						$i ++;
					}
				}
				echo "</table>";
			}

			elseif (isset($_GET["inSeason"])) {
				$Players = $_GET["inSeason"];
				echo "<table class=\"mcenter\">\n";
				echo "	<tr class=\"mcenter\">\n";
				echo "	<td></td>\n";
				echo "	</tr>\n";
				echo "	<tr>\n";
				echo "	<td> <a href=\"addLeague.php\">إضافة دوري</a> </td>\n";
				echo "	</tr>\n";
				echo "	<tr>\n";
				echo "	<td> <a href=\"addCup.php\">إضافة كأس </a> </td>\n";
				echo "	</tr>\n";
				echo "	<tr>\n";
				echo "	<td> <a href=\"addInSeason.php\">إضافة اعضاء الى فريق في الموسم </a> </td>\n";
				echo "	</tr>\n";
				echo "	<tr>\n";
				echo "	<td> <a href=\"addTransfers.php\">إدارة الانتقالات </a> </td>\n";
				echo "	</tr>\n";
				echo "	<tr>\n";
				echo "	<td> <a href=\"addKits.php\">إضافة اطقم الفريق للموسم</a> </td>\n";
				echo "	</tr>\n";
				echo "</table>";
			}

		}
	}
}
//echo "</div>";
// making footer
?>
	</body>
</html>