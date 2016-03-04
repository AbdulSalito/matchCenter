<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>MatchCenter </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/styleLive.css" />
</head>
<body>
<?php
	require_once('Functions.php');
include 'AdminPages/db_conn.php';

echo "<div id = \"maincontent\">\n";
$beginTable = "<table border=\"0\" width=\"100%\">\n";

if (isset($_GET["match"]) && isset($_GET["text"])) {
	$matchIDGet = $_GET["match"];
	$textGet = $_GET["text"];
	echo $beginTable;
	$previousEvent = "";
	$previousHalf = "";
	$previousMins = "";
	$doublePreviousEvent = "";
	$commentText = "";
	function playerNameAr($PlayerInt,$teamInt){
		if ($PlayerInt == 0) {
			echo "لـ ";
			echo TeamNameAr($teamInt);
		}
		else {
			echo "<strong><a href=\"player.php?ID=$PlayerInt\">";
			echo playerShortNameAr($PlayerInt);
			echo "</a></strong>";
		}

	}
	$sqlMatchAna = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' ORDER BY analysisMins DESC, analysisID DESC";
	$queryresultMatchAna = mysql_query($sqlMatchAna)
		or die(mysql_error());
	while ($rowMatchAna = mysql_fetch_assoc($queryresultMatchAna)) {
		$MatchMin = $rowMatchAna['analysisMins'];
		$MatchPlayer = $rowMatchAna['analysisPlayer'];
		$MatchEvent = $rowMatchAna['analysisEvent'];
		$MatchPen = $rowMatchAna['analysisPenalty'];
		$MatchComment = $rowMatchAna['analysisComment'];
		$MatchHalf = $rowMatchAna['analysisHalf'];
		$MatchTeam = $rowMatchAna['analysisTeam'];
		if ($MatchComment == 0) {
			$commentText .= "";
		}
		else {
			$sqlcity = "SELECT * FROM comment WHERE commentID='$MatchComment'";
			$queryresultcity = mysql_query($sqlcity)
			or die(mysql_error());
			$rowCity = mysql_fetch_assoc($queryresultcity);
			$Comment = $rowCity['commentText'];
			$commentText .= "	<td>\n $Comment</td></tr>\n";
		}
		global $EventSimpleAr;
		if ($MatchEvent == 0) {
			if ($MatchHalf == 0 && $MatchMin == 0 && $MatchTeam == 0 && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/1start.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 45 && $MatchTeam == 0  && $MatchEvent == 0) {
				$FirstHalfEnd = "	<tr class=\"startEnd\">\n";
				$FirstHalfEnd .= "	<td><img src=\"images/1end.gif\"> </td>\n";
				$FirstHalfEnd .= "<td>\n<strong>$Comment</strong>";
				$FirstHalfEnd .= "</td></tr>\n";
				$FirstHalfEnd .= "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				echo $FirstHalfEnd;
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 46 && $MatchTeam == 0  && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/2start.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 90 && $MatchTeam == 0  && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/2end.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 91 && $MatchTeam == 0  && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/1start.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 105 && $MatchTeam == 0  && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/1end.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 106 && $MatchTeam == 0  && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/2start.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchHalf == 0 && $MatchMin == 120 && $MatchTeam == 0  && $MatchEvent == 0) {
				echo "	<tr class=\"startEnd\">\n";
				echo "	<td><img src=\"images/2end.gif\"> </td>\n";
				echo "<td>\n<strong>$Comment</strong>";
				echo "</td></tr>\n";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			elseif ($MatchPen == 1) {
				echo "	<tr>\n";
				echo "	<td rowspan=\"2\">$MatchMin </td>\n";
				echo "	<td>\n <img src=\"images/whistle.gif\"> ضربة جزاء لـ ";
				echo teamNameAr($MatchTeam);
				echo " تسبب فيها ";
				echo playerNameAr($MatchPlayer,$MatchTeam);
				echo "</td></tr>\n";
				echo "	<tr>\n";
				echo $commentText;
				$commentText = "";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
			}
			elseif ($MatchPen == 3) {
				echo "	<tr>\n";
				echo "	<td rowspan=\"2\">$MatchMin </td>\n";
				echo "	<td>\n <img src=\"images/penaltyMissed.gif\"> أضاع ضربة الجزاء ";
				echo playerNameAr($MatchPlayer,$MatchTeam);
				echo "</td></tr>\n";
				echo "	<tr>\n";
				echo $commentText;
				$commentText = "";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
			}
			else {
				echo "	<tr>\n";
				echo "	<td rowspan=\"2\">$MatchMin </td>\n";
				echo "	<td>\n ";
				echo playerNameAr($MatchPlayer,$MatchTeam);
				echo "</td></tr>\n";
				echo "	<tr>\n";
				echo $commentText;
				$commentText = "";
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
			}
		}
		elseif ($MatchEvent == 1) {
			if ($MatchEvent == $doublePreviousEvent) {
				$previousEvent = 0;
			}
			if ($previousHalf == 0 && $previousEvent == 0 && $previousMins == 46) {
				if ($previousEvent != $MatchEvent) {
					echo "	<tr>\n";
					echo "	<td rowspan=\"2\"> </td>\n";
					echo "	<td>\n ";
					echo "<strong>تبديل</strong>";
					echo " دخول <img src=\"images/in.gif\">";
					echo playerNameAr($MatchPlayer,$MatchTeam);
				}
				else {
					echo " بدلا من <img src=\"images/out.gif\">";
					echo playerNameAr($MatchPlayer,$MatchTeam);
					echo "</td></tr>\n";
					echo "	<tr>\n";
					echo $commentText;
					$commentText = "";
					echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				}
			}
			else {
				if ($previousEvent != $MatchEvent) {
					echo "	<tr>\n";
					echo "	<td rowspan=\"2\">$MatchMin </td>\n";
					echo "	<td>\n ";
					echo "<strong>تبديل</strong>";
					echo " دخول <img src=\"images/in.gif\">";
					echo playerNameAr($MatchPlayer,$MatchTeam);
				}
				else {
					echo " بدلا من <img src=\"images/out.gif\">";
					echo playerNameAr($MatchPlayer,$MatchTeam);
					echo "</td></tr>\n";
					echo "	<tr>\n";
					echo $commentText;
					$commentText = "";
					echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				}
			}
		}
		elseif ($MatchEvent == 2 || $MatchEvent == 5) {
			if ($MatchEvent == 5) {
				$GoalAssist = $MatchPlayer;
			}
			elseif ($MatchEvent == 2 && $previousEvent!= 5) {
				echo  "	<tr>\n";
				echo "	<td rowspan=\"2\">$MatchMin </td>\n";
				echo "	<td>\n ";
				if ($MatchPen == 2) {
					echo "<img src=\"images/penaltyScored.gif\"><strong> سجل ضربة الجزاء </strong>";
				}
				elseif ($MatchPen == 0) {
					echo "<img src=\"images/goal.gif\"><strong>هدف </strong>\n";
				}
				elseif ($MatchPen == 5) {
					echo "<img src=\"images/OwnGoal.gif\"><strong>هدف عكسي </strong>\n";
				}
				//echo "<img src=\"images/goal.gif\"> هدف ";
				echo playerNameAr($MatchPlayer,$MatchTeam);
				echo "</td></tr>\n";
				echo "	<tr>\n";
				echo $commentText;
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
			else {
				echo  "	<tr>\n";
				echo "	<td rowspan=\"2\">$MatchMin </td>\n";
				echo "	<td>\n ";
				echo "<img src=\"images/goal.gif\"><strong> هدف </strong>";
				echo playerNameAr($MatchPlayer,$MatchTeam);
				echo " بتمريرة من ";
				echo playerNameAr($GoalAssist,$MatchTeam);
				echo "</td></tr>\n";
				echo "	<tr>\n";
				echo $commentText;
				echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
				$commentText = "";
			}
		}
		elseif ($MatchEvent == 3) {
			echo "	<tr>\n";
			echo "	<td rowspan=\"2\">$MatchMin </td>\n";
			echo "	<td>\n ";
			echo "<img class=\"card\" src=\"images/yellow.gif\"> <strong>". $EventSimpleAr[$MatchEvent] ." </strong>";
			echo playerNameAr($MatchPlayer,$MatchTeam);
			echo "</td></tr>\n";
			echo "	<tr>\n";
			echo $commentText;
			$commentText = "";
			echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
		}
		elseif ($MatchEvent == 4) {
			echo "	<tr>\n";
			echo "	<td rowspan=\"2\">$MatchMin </td>\n";
			echo "	<td>\n ";
			echo "<img class=\"card\" src=\"images/red.gif\"> <strong>". $EventSimpleAr[$MatchEvent] ." </strong>";
			echo playerNameAr($MatchPlayer,$MatchTeam);
			echo "</td></tr>\n";
			echo "	<tr>\n";
			echo $commentText;
			$commentText = "";
			echo "<tr><td colspan=\"2\">\n <hr></td></tr>\n";
		}
		$doublePreviousEvent = $previousEvent;
		$previousEvent = $MatchEvent;
		$previousHalf = $MatchHalf;
		$previousMins = $MatchMin;
	}
	mysql_free_result($queryresultMatchAna);
}

elseif (isset($_GET["match"]) && isset($_GET["playersList"])) {
	$matchIDGet = $_GET["match"];
	$textGet = $_GET["playersList"];
	if ($textGet == "full") {
		 // AND (inmatchType=0 OR inmatchType=1 OR inmatchType=5 OR inmatchType=6)
		$beginTableTr = "<tr class=\"dates\">\n";
		$beginTableTr .= "<td rowspan=\"2\"></td>\n";
		$beginTableTr .= "<td rowspan=\"2\"></td>\n";
		$beginTableTr .= "<td rowspan=\"2\">أهداف</td>\n";
		$beginTableTr .= "<td rowspan=\"2\">ت ح</td>\n";
		$beginTableTr .= "<td colspan=\"2\">تمريرات ق</td>\n";
		$beginTableTr .= "<td colspan=\"2\">تمريرات ط</td>\n";
		$beginTableTr .= "<td colspan=\"2\">أخطاء</td>\n";
		$beginTableTr .= "<td colspan=\"2\">كروت</td>\n";
		$beginTableTr .= "<td colspan=\"2\">دفاع</td>\n";

		$TrTdGK = "<td colspan=\"5\">صدات</td>\n";
		//$TrTdGK .= "<td colspan=\"3\">كرات ثابته</td>\n";
		$TrTdGK .= "<td rowspan=\"2\">دقائق</td>\n";
		$TrTdGK .= "</tr>\n";
		$TrTdGK .= "<tr class=\"dates\">\n";
		$TrTdGK .= "<td>كل</td>\n";
		$TrTdGK .= "<td>نسبة</td>\n";
		$TrTdGK .= "<td>كل</td>\n";
		$TrTdGK .= "<td>نسبة</td>\n";
		$TrTdGK .= "<td>له</td>\n";
		$TrTdGK .= "<td>عليه</td>\n";
		$TrTdGK .= "<td>أصفر</td>\n";
		$TrTdGK .= "<td>أحمر</td>\n";
		$TrTdGK .= "<td>افتكاك</td>\n";
		$TrTdGK .= "<td>فقدان</td>\n";
		$TrTdGK .= "<td>داخل</td>\n";
		$TrTdGK .= "<td>خارج</td>\n";
		$TrTdGK .= "<td>ض ج</td>\n";
		$TrTdGK .= "<td>انفراد</td>\n";
		$TrTdGK .= "<td>خروج</td>\n";
		$TrTdGK .= "</tr>\n";

		$TrTdLinedUp = "<td colspan=\"2\">تسديدات</td>\n";
		$TrTdLinedUp .= "<td colspan=\"3\">كرات ثابته</td>\n";
		$TrTdLinedUp .= "<td rowspan=\"2\">دقائق</td>\n";
		$TrTdLinedUp .= "</tr>\n";
		$TrTdLinedUp .= "<tr class=\"dates\">\n";
		$TrTdLinedUp .= "<td>كل</td>\n";
		$TrTdLinedUp .= "<td>نسبة</td>\n";
		$TrTdLinedUp .= "<td>كل</td>\n";
		$TrTdLinedUp .= "<td>نسبة</td>\n";
		$TrTdLinedUp .= "<td>له</td>\n";
		$TrTdLinedUp .= "<td>عليه</td>\n";
		$TrTdLinedUp .= "<td>أصفر</td>\n";
		$TrTdLinedUp .= "<td>أحمر</td>\n";
		$TrTdLinedUp .= "<td>افتكاك</td>\n";
		$TrTdLinedUp .= "<td>فقدان</td>\n";
		$TrTdLinedUp .= "<td>داخل</td>\n";
		$TrTdLinedUp .= "<td>خارج</td>\n";
		$TrTdLinedUp .= "<td>ركني</td>\n";
		$TrTdLinedUp .= "<td>فاول</td>\n";
		$TrTdLinedUp .= "<td>تسلل</td>\n";
		$TrTdLinedUp .= "</tr>\n";

		$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet'
	 ORDER BY inmatchPosition,inmatchNumber,inmatchType";
		$queryresultInMatch = mysql_query($sqlInMatch)
			or die(mysql_error());
		//$TrTdGK = "";
		//$TrTdLinedUp = "";
		$TrTdSubs = "";
		$TrTdManager = "";
		$TrTdAdmins = "";
		$TrClass = 0;
		while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
			$InMatchMember = $rowInMatch['inmatchMember'];
			$InMatchMumber = $rowInMatch['inmatchNumber'];
			$InMatchType = $rowInMatch['inmatchType'];
			$goal = 0;
			$assist = 0;
			$Ycard = 0;
			$Rcard = 0;
			$subIn = 0;
			$subOut = 90;
			$CrctSB = 0;
			$WrngSB = 0;
			$CrctLB = 0;
			$WrngLB = 0;
			$CrctST = 0;
			$WrngST = 0;
			$GainF = 0;
			$GiveF = 0;
			$tackl = 0;
			$lost = 0;
			$foul = 0;
			$CK = 0;
			$offSide = 0;

			$sqlcity = "SELECT * FROM players WHERE playerID='$InMatchMember'";
			$queryresultcity = mysql_query($sqlcity)
			or die(mysql_error());
			$rowCity = mysql_fetch_assoc($queryresultcity);
			$firstNameAr = $rowCity['playerFirstNameAr'];
			$MidNameAr = $rowCity['playerMidNameAr'];
			$lastNameAr = $rowCity['playerLastNameAr'];
			$playerPosition = $rowCity['playerPosition'];
			if ($InMatchType == 5) {
				if ($playerPosition == 0) {
					$TrTdGK .= "	<tr class=\"FullStat\" id=\"$InMatchMember\" onMouseOver=\"this.bgColor='#FFFFFF';\" onMouseOut=\"this.bgColor='#E1E9FB';\">\n";
					$TrTdGK .= "	<td>$InMatchMumber </td>\n";
					$TrTdGK .= "	<td>\n";
					$TrTdGK .= "<a href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdGK .= "</td>\n";
				} else {
					$TrTdSubs .= "	<tr class=\"FullStat\" id=\"$InMatchMember\" onMouseOver=\"this.bgColor='#FFFFFF';\" onMouseOut=\"this.bgColor='#E1E9FB';\">\n";
					$TrTdSubs .= "	<td>$InMatchMumber </td>\n";
					$TrTdSubs .= "	<td>\n";
					$TrTdSubs .= "<a href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdSubs .= "</td>\n";
				}
			}
			elseif ($InMatchType == 0 || $InMatchType == 6) {
				if ($playerPosition == 0) {
					$TrTdGK .= "	<tr class=\"FullStat\" id=\"$InMatchMember\" onMouseOver=\"this.bgColor='#FFFFFF';\" onMouseOut=\"this.bgColor='#E1E9FB';\">\n";
					$TrTdGK .= "	<td>$InMatchMumber </td>\n";
					$TrTdGK .= "	<td>\n";
					$TrTdGK .= "<a href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdGK .= "</td>\n";
				} else {
					$TrTdLinedUp .= "	<tr class=\"FullStat\" id=\"$InMatchMember\" onMouseOver=\"this.bgColor='#FFFFFF';\" onMouseOut=\"this.bgColor='#E1E9FB';\">\n";
					$TrTdLinedUp .= "	<td>$InMatchMumber </td>\n";
					$TrTdLinedUp .= "	<td>\n";
					$TrTdLinedUp .= "<a href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdLinedUp .= "</td>\n";
				}
			}

			$sqlMatchAnaly = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisPlayer='$InMatchMember'";
			$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
				or die(mysql_error());
			while ($rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly)) {
				$analyEvent = $rowMatchAnaly['analysisEvent'];
				$analyMins = $rowMatchAnaly['analysisMins'];
				$analyPen = $rowMatchAnaly['analysisPenalty'];
				if ($analyEvent == 1) {
					if ($InMatchType == 5) {
						$subIn = 90 - $analyMins;
					} else {
						$subOut = $analyMins;
					}
				}
				elseif ($analyEvent == 2) {
					$goal ++;
				}
				elseif ($analyEvent == 3) {
					$Ycard ++;
				}
				elseif ($analyEvent == 4) {
					$Rcard ++;
				}
				elseif ($analyEvent == 5) {
					$assist ++;
				}
			}
			$sqlAdvAnaly = "SELECT * FROM advanceanalysis WHERE advMatch='$matchIDGet' AND advPlayer='$InMatchMember'";
			$queryresultAdvAnaly = mysql_query($sqlAdvAnaly)
				or die(mysql_error());
			while($rowAdv = mysql_fetch_assoc($queryresultAdvAnaly)){
				$AdvEvent = $rowAdv['advEvent'];
				switch($AdvEvent){
					case 0:
					case 2:
					case 4:
						$CrctST ++;
						break;
					case 1:
					case 3:
					case 5:
						$WrngST ++;
						break;
					case 10:
					case 12:
						$GainF ++;
						break;
					case 11:
					case 13:
						$GiveF ++;
						break;
					case 14:
						$offSide ++;
						break;
					case 20:
					case 21:
					case 22:
					case 23:
						$foul ++;
						break;
					case 24:
					case 25:
						$foul ++;
						break;
					case 30:
						$CrctSB ++;
						break;
					case 31:
						$WrngSB ++;
						break;
					case 34:
					case 36:
						$CrctSB ++;
						$foul ++;
						break;
					case 35:
					case 37:
						$WrngSB ++;
						$foul ++;
						break;
					case 38:
						$CrctSB ++;
						$CK ++;
						break;
					case 39:
						$WrngSB ++;
						$CK ++;
						break;
					case 32:
						$CrctLB ++;
						break;
					case 33:
						$WrngLB ++;
						break;
					case 40:
						$tackl ++;
						break;
					case 41:
						$lost ++;
						break;
				} // switch
			}
			if ($CrctSB OR $WrngSB != 0) {
				$totalSB = $CrctSB + $WrngSB;
				$persSB = $CrctSB / $totalSB * 100;
				$persSB = number_format($persSB,0)." %";
			} else {
				$totalSB = $CrctSB + $WrngSB;
				$persSB = 0;
			}
			if ($CrctLB OR $WrngLB != 0) {
				$totalLB = $CrctLB + $WrngLB;
				$persLB = $CrctLB / $WrngLB * 100;
				$persLB = number_format($persLB,0)." %";
			} else {
				$totalLB = $CrctLB + $WrngLB;
				$persLB = 0;
			}

			if ($InMatchType == 5) {
				if ($playerPosition == 0) {
					$TrTdGK .= "<td>$goal</td>\n";
					$TrTdGK .= "<td>$assist</td>\n";
					$TrTdGK .= "<td>$totalSB</td>\n";
					$TrTdGK .= "<td>$persSB</td>\n";
					$TrTdGK .= "<td>$totalLB</td>\n";
					$TrTdGK .= "<td>$persLB</td>\n";
					$TrTdGK .= "<td>$GainF</td>\n";
					$TrTdGK .= "<td>$GiveF</td>\n";
					$TrTdGK .= "<td>$Ycard</td>\n";
					$TrTdGK .= "<td>$Rcard</td>\n";
					$TrTdGK .= "<td>$tackl</td>\n";
					$TrTdGK .= "<td>$lost</td>\n";
					$TrTdGK .= "<td>$CrctST</td>\n";
					$TrTdGK .= "<td>$WrngST</td>\n";
					$TrTdGK .= "<td>$CK</td>\n";
					$TrTdGK .= "<td>$foul</td>\n";
					$TrTdGK .= "<td>$offSide</td>\n";
					$TrTdGK .= "<td>$subIn</td>\n";
					$TrTdGK .= "</tr>\n";
				} else {
					$TrTdSubs .= "<td>$goal</td>\n";
					$TrTdSubs .= "<td>$assist</td>\n";
					$TrTdSubs .= "<td>$totalSB</td>\n";
					$TrTdSubs .= "<td>$persSB</td>\n";
					$TrTdSubs .= "<td>$totalLB</td>\n";
					$TrTdSubs .= "<td>$persLB</td>\n";
					$TrTdSubs .= "<td>$GainF</td>\n";
					$TrTdSubs .= "<td>$GiveF</td>\n";
					$TrTdSubs .= "<td>$Ycard</td>\n";
					$TrTdSubs .= "<td>$Rcard</td>\n";
					$TrTdSubs .= "<td>$tackl</td>\n";
					$TrTdSubs .= "<td>$lost</td>\n";
					$TrTdSubs .= "<td>$CrctST</td>\n";
					$TrTdSubs .= "<td>$WrngST</td>\n";
					$TrTdSubs .= "<td>$CK</td>\n";
					$TrTdSubs .= "<td>$foul</td>\n";
					$TrTdSubs .= "<td>$offSide</td>\n";
					$TrTdSubs .= "<td>$subIn</td>\n";
					$TrTdSubs .= "</tr>\n";
				}
			}
			elseif ($InMatchType == 0 || $InMatchType == 6) {
				if ($playerPosition == 0) {
					$TrTdGK .= "<td>$goal</td>\n";
					$TrTdGK .= "<td>$assist</td>\n";
					$TrTdGK .= "<td>$totalSB</td>\n";
					$TrTdGK .= "<td>$persSB</td>\n";
					$TrTdGK .= "<td>$totalLB</td>\n";
					$TrTdGK .= "<td>$persLB</td>\n";
					$TrTdGK .= "<td>$GainF</td>\n";
					$TrTdGK .= "<td>$GiveF</td>\n";
					$TrTdGK .= "<td>$Ycard</td>\n";
					$TrTdGK .= "<td>$Rcard</td>\n";
					$TrTdGK .= "<td>$tackl</td>\n";
					$TrTdGK .= "<td>$lost</td>\n";
					$TrTdGK .= "<td>$CrctST</td>\n";
					$TrTdGK .= "<td>$WrngST</td>\n";
					$TrTdGK .= "<td>$CK</td>\n";
					$TrTdGK .= "<td>$foul</td>\n";
					$TrTdGK .= "<td>$offSide</td>\n";
					$TrTdGK .= "<td>$subOut</td>\n";
					$TrTdGK .= "</tr>\n";
				} else {
					$TrTdLinedUp .= "<td>$goal</td>\n";
					$TrTdLinedUp .= "<td>$assist</td>\n";
					$TrTdLinedUp .= "<td>$totalSB</td>\n";
					$TrTdLinedUp .= "<td>$persSB</td>\n";
					$TrTdLinedUp .= "<td>$CrctLB</td>\n";
					$TrTdLinedUp .= "<td>$WrngLB</td>\n";
					$TrTdLinedUp .= "<td>$GainF</td>\n";
					$TrTdLinedUp .= "<td>$GiveF</td>\n";
					$TrTdLinedUp .= "<td>$Ycard</td>\n";
					$TrTdLinedUp .= "<td>$Rcard</td>\n";
					$TrTdLinedUp .= "<td>$tackl</td>\n";
					$TrTdLinedUp .= "<td>$lost</td>\n";
					$TrTdLinedUp .= "<td>$CrctST</td>\n";
					$TrTdLinedUp .= "<td>$WrngST</td>\n";
					$TrTdLinedUp .= "<td>$CK</td>\n";
					$TrTdLinedUp .= "<td>$foul</td>\n";
					$TrTdLinedUp .= "<td>$offSide</td>\n";
					$TrTdLinedUp .= "<td>$subOut</td>\n";
					$TrTdLinedUp .= "</tr>\n";
				}
			}
			/*elseif ($InMatchType == 2) {
				$sqlcity = "SELECT * FROM managers WHERE managerID='$InMatchMember'";
				$queryresultcity = mysql_query($sqlcity)
					or die(mysql_error());
				$rowCity = mysql_fetch_assoc($queryresultcity);
				$firstNameAr = $rowCity['managerFirstNameAr'];
				$lastNameAr = $rowCity['managerLastNameAr'];
				$TrTdManager .= "<hr>\n";
				$TrTdManager .= "	<tr class=\"linedUp\">\n";
				$TrTdManager .= "	<td>مدرب الفريق</td>\n";
				$TrTdManager .= "	<td>\n";
				$TrTdManager .= "<a href=\"manager.php?ID=$InMatchMember\">$firstNameAr $lastNameAr</a>";
				$TrTdManager .= "</td>\n";
				$TrTdManager .= "</tr>\n";
			}
			elseif ($InMatchType == 3 || $InMatchType == 4) {
				$sqlcity = "SELECT * FROM chairmen WHERE chairmanID='$InMatchMember'";
				$queryresultcity = mysql_query($sqlcity)
					or die(mysql_error());
				$TrTdAdmins .= "	<tr class=\"linedUp\">\n";
				while($rowCity = mysql_fetch_assoc($queryresultcity)){
					$firstNameAr = $rowCity['chairmanFirstNameAr'];
					$lastNameAr = $rowCity['chairmanLastNameAr'];
					switch($InMatchType){
						case 3:
							$TrTdAdmins .= "	<td>مدير الفريق</td>\n";
							break;
						case 4:
							$TrTdAdmins .= "	<td>رئيس النادي</td>\n";
							break;
					} // switch

					$TrTdAdmins .= "	<td>\n";
					$TrTdAdmins .= "<a href=\"chairman.php?ID=$InMatchMember\">$firstNameAr $lastNameAr</a>";
					$TrTdAdmins .= "</td>\n";
				}
				$TrTdAdmins .= "</tr>\n";
			}*/
		}
		mysql_free_result($queryresultInMatch);

		echo $beginTable;
		echo $beginTableTr;
		echo $TrTdGK;
		echo $beginTableTr;
		echo $TrTdLinedUp;
		echo "<tr><td colspan=\"18\"><hr></td></tr>";
		echo $TrTdSubs;
		echo "</table>\n <table border=\"0\" width=\"100%\">\n";
		echo $TrTdManager;
		echo $TrTdAdmins;
	}

	else {
		echo $beginTable;
		$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND (inmatchType=0 OR inmatchType=1 OR
		inmatchType=2 OR inmatchType=5 OR inmatchType=6) ORDER BY inmatchPosition,inmatchNumber,inmatchType";
		$queryresultInMatch = mysql_query($sqlInMatch)
			or die(mysql_error());
		$TrTdLinedUp = "";
		$TrTdSubs = "";
		$TrTdManager = "";
		while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
			$InMatchMember = $rowInMatch['inmatchMember'];
			$InMatchMumber = $rowInMatch['inmatchNumber'];
			$InMatchType = $rowInMatch['inmatchType'];
			if ($InMatchType == 0 || $InMatchType == 6) {
				$sqlcity = "SELECT * FROM players WHERE playerID='$InMatchMember'";
				$queryresultcity = mysql_query($sqlcity)
				or die(mysql_error());
				$rowCity = mysql_fetch_assoc($queryresultcity);
				$firstNameAr = $rowCity['playerFirstNameAr'];
				$MidNameAr = $rowCity['playerMidNameAr'];
				$lastNameAr = $rowCity['playerLastNameAr'];
				if ($InMatchType == 6) {
					$TrTdLinedUp .= "	<tr class=\"Subs\" onMouseOver=\"this.bgColor='#FFFFFF';\" onMouseOut=\"this.bgColor='#E1E9FB';\">\n";
					$TrTdLinedUp .= "	<td>$InMatchMumber </td>\n";
					$TrTdLinedUp .= "	<td>\n";
					$TrTdLinedUp .= "<a class=\"Subs\" class=\"Subs\" href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdLinedUp .= "</td>\n";
				}
				else {
					$TrTdLinedUp .= "	<tr class=\"linedUp\" onMouseOver=\"this.bgColor='#FFFFFF';\" onMouseOut=\"this.bgColor='#E1E9FB';\">\n";
					$TrTdLinedUp .= "	<td>$InMatchMumber </td>\n";
					$TrTdLinedUp .= "	<td>\n";
					$TrTdLinedUp .= "<a href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdLinedUp .= "</td>\n";
				}

				$LinedUpArray = array();
				$sqlMatchAnaly = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisPlayer='$InMatchMember'";
				$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
					or die(mysql_error());
				while ($rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly)) {
					$analyEvent = $rowMatchAnaly['analysisEvent'];
					$analyMins = $rowMatchAnaly['analysisMins'];
					$analyPen = $rowMatchAnaly['analysisPenalty'];
					if ($analyEvent == 1) {
						array_push($LinedUpArray ,"<img src=\"images/out.gif\">'$analyMins " );
						//$TrTdLinedUp .= "	<td><img src=\"images/out.gif\">'$analyMins </td>\n";
					}
					elseif ($analyEvent == 2) {
						if ($analyPen == 2) {
							array_push($LinedUpArray ,"<img src=\"images/penaltyScored.gif\">'$analyMins " );
							//$TrTdLinedUp .= "	<td><img src=\"images/penaltyScored.gif\">'$analyMins </td>\n";
						}
						elseif ($analyPen == 5) {
							array_push($LinedUpArray ,"<img src=\"images/OwnGoal.gif\">'$analyMins " );
						}
						elseif ($analyPen == 0) {
							array_push($LinedUpArray ,"<img src=\"images/goal.gif\">'$analyMins " );
							//$TrTdLinedUp .= "	<td><img src=\"images/goal.gif\">'$analyMins </td>\n";
						}
					}
					elseif ($analyEvent == 3) {
						array_push($LinedUpArray ,"<img class=\"card\" src=\"images/yellow.gif\">'$analyMins " );
						//$TrTdLinedUp .= "	<td><img class=\"card\" src=\"images/yellow.gif\">'$analyMins </td>\n";
					}
					elseif ($analyEvent == 4) {
						array_push($LinedUpArray ,"<img class=\"card\" src=\"images/red.gif\">'$analyMins " );
						//$TrTdLinedUp .= "	<td><img class=\"card\" src=\"images/red.gif\">'$analyMins </td>\n";
					}
				}
				for ($i = 0; $i < 4; $i++) {
					if (isset($LinedUpArray[$i])) {
						$TrTdLinedUp .= "<td>".$LinedUpArray[$i]."</td>";
					} else {
						$TrTdLinedUp .= "<td> </td>";
					}
				}
				/*$TrTdLinedUp .= "	<td> </td>\n";
				   $TrTdLinedUp .= "	<td> </td>\n";*/
				$TrTdLinedUp .= "</tr>\n";
			}
			elseif ($InMatchType == 1 || $InMatchType == 5) {
				$sqlcity = "SELECT * FROM players WHERE playerID='$InMatchMember'";
				$queryresultcity = mysql_query($sqlcity)
					or die(mysql_error());
				$rowCity = mysql_fetch_assoc($queryresultcity);
				$firstNameAr = $rowCity['playerFirstNameAr'];
				$MidNameAr = $rowCity['playerMidNameAr'];
				$lastNameAr = $rowCity['playerLastNameAr'];
				if ($InMatchType == 5) {
					$TrTdSubs .= "	<tr class=\"linedUp\">\n";
					$TrTdSubs .= "	<td>$InMatchMumber </td>\n";
					$TrTdSubs .= "	<td>\n";
					$TrTdSubs .= "<a href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdSubs .= "</td>\n";
				}
				else {
					$TrTdSubs .= "	<tr class=\"Subs\">\n";
					$TrTdSubs .= "	<td>$InMatchMumber </td>\n";
					$TrTdSubs .= "	<td>\n";
					$TrTdSubs .= "<a class=\"Subs\" href=\"player.php?ID=$InMatchMember\">$firstNameAr $MidNameAr $lastNameAr</a>";
					$TrTdSubs .= "</td>\n";
				}
				$sqlMatchAnaly = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisPlayer='$InMatchMember'";
				$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
					or die(mysql_error());
				while ($rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly)) {
					$analyEvent = $rowMatchAnaly['analysisEvent'];
					$analyMins = $rowMatchAnaly['analysisMins'];
					$analyPen = $rowMatchAnaly['analysisPenalty'];
					if ($analyEvent == 1) {
						$TrTdSubs .= "	<td><img src=\"images/in.gif\">$analyMins </td>\n";
					}
					elseif ($analyEvent == 2) {
						if ($analyPen == 2) {
							$TrTdSubs .= "	<td><img src=\"images/penaltyScored.gif\">'$analyMins </td>\n";
						}
						elseif ($analyPen == 0) {
							$TrTdSubs .= "	<td><img src=\"images/goal.gif\">'$analyMins </td>\n";
						}
					}
					elseif ($analyEvent == 3) {
						$TrTdSubs .= "	<td><img class=\"card\" src=\"images/yellow.gif\">'$analyMins </td>\n";
					}
					elseif ($analyEvent == 4) {
						$TrTdSubs .= "	<td><img class=\"card\" src=\"images/red.gif\">$analyMins </td>\n";
					}
				}
				$TrTdSubs .= "</tr>\n";
			}
			elseif ($InMatchType == 2) {
				$sqlcity = "SELECT * FROM managers WHERE managerID='$InMatchMember'";
				$queryresultcity = mysql_query($sqlcity)
					or die(mysql_error());
				$rowCity = mysql_fetch_assoc($queryresultcity);
				$firstNameAr = $rowCity['managerFirstNameAr'];
				$lastNameAr = $rowCity['managerLastNameAr'];
				$TrTdManager .= "<hr>\n";
				$TrTdManager .= "	<tr class=\"linedUp\">\n";
				$TrTdManager .= "	<td>مدرب الفريق</td>\n";
				$TrTdManager .= "	<td>\n";
				$TrTdManager .= "<a href=\"manager.php?ID=$InMatchMember\">$firstNameAr $lastNameAr</a>";
				$TrTdManager .= "</td>\n";
				$TrTdManager .= "</tr>\n";
			}
		}
		mysql_free_result($queryresultInMatch);

		echo $TrTdLinedUp;
		echo "<tr><td colspan=\"2\"><hr></td></tr>";
		echo $TrTdSubs;
		echo "</table>\n <table border=\"0\" width=\"100%\">\n";
		echo $TrTdManager;
	}
}

elseif (isset($_GET["match"]) && isset($_GET["result"])) {
	$matchIDGet = $_GET["match"];
	$textGet = $_GET["result"];

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$season = $rowMatch['matchSeason'];
	$comp = $rowMatch['matchComp'];
	$round = $rowMatch['matchRound'];
	$team1 = $rowMatch['matchTeamHome'];
	$teamHomeKit = $rowMatch['matchTeamHomeKit'];
	$team2 = $rowMatch['matchTeamAway'];
	$teamAwayKit = $rowMatch['matchTeamAwayKit'];

	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet' AND analysisEvent=2 AND
	(analysisHalf=1 OR analysisHalf=2 OR analysisHalf=3 OR analysisHalf=4)";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
		or die(mysql_error());
	$result1 = 0;
	$result2 = 0;
	$goals1 = "<table class=\"goalsTeam1\">\n";
	$goals2 = "<table class=\"goalsTeam2\">\n";

	while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
		$Mins = $rowMatchAnalysis['analysisMins'];
		$Pen = $rowMatchAnalysis['analysisPenalty'];
		$Player = $rowMatchAnalysis['analysisPlayer'];
		$team = $rowMatchAnalysis['analysisTeam'];
		if ($Player == 0) {
			$playerName = "unKnown";
		}
		else {
			$sqlcity = "SELECT * FROM players WHERE playerID='$Player'";
			$queryresultcity = mysql_query($sqlcity)
				or die(mysql_error());
			$rowCity = mysql_fetch_assoc($queryresultcity);
			$firstNameAr = $rowCity['playerFirstNameAr'];
			$MidNameAr = $rowCity['playerMidNameAr'];
			$lastNameAr = $rowCity['playerLastNameAr'];
			$playerName = "<strong><a href=\"player.php?ID=$Player\"> $firstNameAr $MidNameAr $lastNameAr </a></strong>";
		}
		if ($team == $team1) {
			if ($Pen == 2) {
				$goals1 .= "<td><img src=\"images/penaltyScored.gif\">'$Mins </td>\n";
			}
			elseif ($Pen == 5) {
				$goals1 .= "<td><img src=\"images/OwnGoal.gif\">'$Mins </td>\n";
			}
			elseif ($Pen == 0) {
				$goals1 .= "<td><img src=\"images/goal.gif\">'$Mins </td>\n";
			}
			$goals1 .= "	<td>\n";
			$goals1 .= $playerName;
			if ($Pen == 5) {
				$goals1 .= "(OG)";
			}
			$goals1 .= "</td>\n";
			$goals1 .= "	</tr>\n";
			$result1 ++;
		}
		elseif ($team == $team2) {
			$goals2 .= "	<tr>\n";
			$goals2 .= "	<td>\n";
			if ($Pen == 5) {
				$goals1 .= "(OG)";
			}
			$goals2 .= $playerName;
			$goals2 .= "</td>\n";
			if ($Pen == 2) {
				$goals2 .= "<td><img src=\"images/penaltyScored.gif\">'$Mins </td>\n";
			}
			elseif ($Pen == 0) {
				$goals2 .= "<td><img src=\"images/goal.gif\">'$Mins </td>\n";
			}
			elseif ($Pen == 5) {
				$goals1 .= "<td><img src=\"images/OwnGoal.gif\">'$Mins </td>\n";
			}
			$goals2 .= "	</tr>\n";
			$result2 ++;
		}
	}
	$goals1 .= "</table>\n";
	$goals2 .= "</table>\n";
	$sqlTeam1 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team1'";
	$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team2'";
	$queryresultTeam1 = mysql_query($sqlTeam1)
					or die(mysql_error());
	$queryresultTeam2 = mysql_query($sqlTeam2)
					or die(mysql_error());
	$rowTeam1 = mysql_fetch_assoc($queryresultTeam1);
	$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);
	$bgColorT1 = "#";
	$fhColorT1 = "#";
	$bgColorT2 = "#";
	$fhColorT2 = "#";
	$bgColorT1 .= $rowTeam1['teamColor1'];
	$fhColorT1 .= $rowTeam1['teamColor2'];
	$bgColorT2 .= $rowTeam2['teamColor1'];
	$fhColorT2 .= $rowTeam2['teamColor2'];

	$resultAgg1 = "";
	$resultAgg2 = "";
	// check the previous match to calculate the aggregate ..............................................
	$CompSys = CompSys($comp);
	//global $CompSys;
	if (($CompSys != 0 OR trim($CompSys) != "0") && $round != 32) {
		$sqlMatchAway = "SELECT * FROM `matchcenter`.`match` WHERE matchTeamHome='$team2' AND matchTeamAway='$team1' AND matchComp='$comp'
		AND matchSeason='$season'";
		$queryresultMatchAway = mysql_query($sqlMatchAway)
			or die(mysql_error());
		$rowMatchAway = mysql_fetch_assoc($queryresultMatchAway);
		$matchAwayID = $rowMatchAway['matchID'];
		$sqlMatchAnalysisMatch = "SELECT analysisTeam FROM matchanalysis WHERE analysisMatch='$matchAwayID' AND analysisHalf='0' AND
		analysisMins='90' AND analysisTeam='0'";
		$queryresultMatchAnalysisMatch = mysql_query($sqlMatchAnalysisMatch)
			or die(mysql_error());
		if (mysql_num_rows($queryresultMatchAnalysisMatch) != 0) {
			$sqlMatchAnalysisAway = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchAwayID' AND analysisEvent=2 AND
			(analysisHalf=1 OR analysisHalf=2 OR analysisHalf=3 OR analysisHalf=4)";
			$queryresultMatchAnalysisAway = mysql_query($sqlMatchAnalysisAway)
				or die(mysql_error());
			if (mysql_num_rows($queryresultMatchAnalysisAway) != 0) {
				$resultAgg1 = 0;
				$resultAgg2 = 0;
				while($rowMatchAnalysisAway = mysql_fetch_assoc($queryresultMatchAnalysisAway)){
					$team = $rowMatchAnalysisAway['analysisTeam'];
					if ($team == $team1) {
						$resultAgg1 ++;
					}
					elseif ($team == $team2) {
						$resultAgg2 ++;
					}
				}
			}
		}
	}
	// check the previous match to calculate the aggregate ##############################################

	$outputTable = "<table width=\"100%\" class=\"result\"><tr class=\"teams\">";
	$outputTable .= "<td class=\"teams\" bgcolor=\"$bgColorT1\"><font color=\"$fhColorT1\">".$rowTeam1['teamNameAr']."</font></td>";
	$outputTable .= "<td class=\"result\">$result1 - $result2";
	if (trim($resultAgg1) != "" && trim($resultAgg2) != "") {
		$resultAgg1 += $result1;
		$resultAgg2 += $result2;
		$outputTable .= "<br><font id=\"aggr\">aggr: $resultAgg2 - $resultAgg1</font>";
	}
	$outputTable .= "</td>";
	$outputTable .= "<td class=\"teams\" bgcolor=\"$bgColorT2\"><font color=\"$fhColorT2\">".$rowTeam2['teamNameAr']."</font></td>";
	$outputTable .= "</tr>\n</table>\n<table width=\"100%\" class=\"result\">\n<tr>\n";
	$outputTable .= "<td class=\"club\">".showKit($team1,$matchIDGet,$teamHomeKit)."</td>";
	$outputTable .= "<td class=\"goals\" colspan=\"2\">$goals1 $goals2</td>";
	$outputTable .= "<td class=\"club\">".showKit($team2,$matchIDGet,$teamAwayKit)."</td>";
	$outputTable .= "</tr></table>";
	echo $outputTable;
	mysql_free_result($queryresultMatch);

}

echo "</table>\n";
echo "</div>";
// making footer
?>
	</body>
</html>