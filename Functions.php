<?php
function makeHeader($title) {

$headContent = <<<HEAD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>Alhilalclub MatchCenter - $title </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/style1.css" />
</head>
<body>
<div id="outerarea">
<div id="innerarea">
<div id = "header">
<img src="images/header.jpg" align="left">
<img src="images/headerAr.jpg" align="right">
</div>
HEAD;
	$headContent .="\n";
	return $headContent;
}

function makeHeaderSimple($title,$lang) {
if ($lang == "ar") {
	$dir = "rtl";
} elseif ($lang == "en") {
	$dir = "ltr";
}
$headContentSimple = <<<HEADS
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="$dir" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>Alhilalclub MatchCenter - $title </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/style1.css" />
</head>
<body bgcolor="#F2F9FE">
HEADS;
	$headContentSimple .="\n";
	return $headContentSimple;
}

function makeFooterSimple() {
	$footContentSimple = <<< FOOTS
	</body>
	</html>
FOOTS;
	return $footContentSimple;
}

function makeHeaderEn($title) {

$headContent = <<<HEADEN
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>Alhilalclub MatchCenter - $title </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/style1.css" />
</head>
<body>
<div id="outerarea">
<div id="innerarea">
<div id = "header">
<img src="images/header.jpg" align="left">
<img src="images/headerAr.jpg" align="right">
</div>
HEADEN;
	$headContent .="\n";
	return $headContent;
}

function makeMenu() {
	$menuContent = <<<MENU
	<div id = "navigation">
<table class="linkstbl">
	<tr>
		<td class="links"><a class="nav" href = "index.php">Home </a></td>
		<td class="links"><a class="nav" href = "motorhomes.php">Motor homes </a></td>
		<td class="links"><a class="nav" href = "search.php">Search </a></td>
		<td class="links"><a class="nav" href = "admin.php">Administrator </a></td>
		<td class="links"><a class="nav" href = "orderMotor.html">Quote</a></td>
		<td class="links"><a class="nav" href = "credits.php">Credits</a></td>
		<td class="links"><a class="nav" href = "siteMap.html">Site Map</a></td>
	</tr>
</table>
</div>
MENU;
	$menuContent .= "\n";
	return $menuContent;
}

function makeLinksLive($matchIDGet) {
//javascript:ChangeDiv('FullPlayer');matchDetailsAJAX('$matchIDGet' ,'playersList','full','FullPlayer');ChangeDiv('all');">
$LinksLiveContent = <<<LinksLive
<div id = "links">
<table class="linkstbl">
	<tr>
		<td class="links"><a class="nav" href = "liveMatch.php?match=$matchIDGet&Details=FullStat">Full PlayerList </a></td>
		<td class="links"></td>
	</tr>
</table>
</div>
LinksLive;
	$LinksLiveContent .= "\n";
	return $LinksLiveContent;
}
//<a class="nav" href="mailto:alse3loo@gmail.com">السعلو</a>

function makeFooter() {
	$footContent = <<< FOOT
	<div id = "footer">
	<fontalign="center">MatchCenter 1.0</font><br />
	<font align="left">تطوير </font>
	<font align="right">Developed by <a class="nav" href="mailto:alse3loo@gmail.com">alse3loo</a></font>
	</div>
	</div>
	</div>
	</body>
	</html>
FOOT;
	return $footContent;
}


function GetAge($Birthdate){
	// Explode the date into meaningful variables
	list($BirthYear,$BirthMonth,$BirthDay) = explode("-", $Birthdate);
	// Find the differences
	$YearDiff = date("Y") - $BirthYear;
	$MonthDiff = date("m") - $BirthMonth;
	$DayDiff = date("d") - $BirthDay;
	// If the birthday has not occured this year
	if ($DayDiff < 0 || $MonthDiff < 0)
		$YearDiff--;
	return $YearDiff;
}

function TeamNameAr($teamID){
	$sqlMatch = "SELECT * FROM teams WHERE teamID='$teamID'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$teamNameAr = $rowMatch['teamNameAr'];
	return $teamNameAr;
}

function CountryNameAr($nationID){
	$sqlMatch = "SELECT * FROM nationality WHERE nationalityID='$nationID'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$NameAr = $rowMatch['nationalityNameAr'];
	return $NameAr;
}

function CityNameAr($cityID){
	$sqlMatch = "SELECT * FROM city WHERE cityID='$cityID'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$NameAr = $rowMatch['cityNameAr'];
	return $NameAr;
}

function CompAr($compID){
	$sqlComp = "SELECT * FROM competition WHERE compID='$compID'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompNameAr = $rowComp['compNameAr'];
	mysql_free_result($queryresultComp);
	return $CompNameAr;
}

function CompSys($compID){
	$sqlComp = "SELECT compSys FROM competition WHERE compID='$compID'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	mysql_free_result($queryresultComp);
	return $CompSys;
}

function playerShortNameAr($playerID){
	$sqlPlayer = "SELECT * FROM players WHERE playerID='$playerID'";
	$queryresultPlayer = mysql_query($sqlPlayer)
	or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
	$PlayerlastNameAr = $rowPlayer['playerLastNameAr'];
	$PlayerNickNameAr = $rowPlayer['playerNickNameAr'];
	$playerNameAr = "$PlayerFirstNameAr $PlayerlastNameAr";
	if ($PlayerNickNameAr == "") {
		return $playerNameAr;
	} else {
		return $PlayerNickNameAr;
	}
}

function playerFullNameAr($playerID){
	$sqlPlayer = "SELECT * FROM players WHERE playerID='$playerID'";
	$queryresultPlayer = mysql_query($sqlPlayer)
	or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
	$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
	$PlayerlastNameAr = $rowPlayer['playerLastNameAr'];
	$playerNameAr = "$PlayerFirstNameAr $PlayerMidNameAr $PlayerlastNameAr";
	return $playerNameAr;
}

function TeamNameEN($teamID){
	$sqlMatch = "SELECT * FROM teams WHERE teamID='$teamID'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$teamNameEn = $rowMatch['teamNameEn'];
	return $teamNameEn;
}

function CountryNameEn($nationID){
	$sqlMatch = "SELECT * FROM nationality WHERE nationalityID='$nationID'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$NameEn = $rowMatch['nationalityNameEn'];
	return $NameEn;
}

function CityNameEn($cityID){
	$sqlMatch = "SELECT * FROM city WHERE cityID='$cityID'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$NameEn = $rowMatch['cityNameEn'];
	return $NameEn;
}

function CompEn($compID){
	$sqlComp = "SELECT * FROM competition WHERE compID='$compID'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompNameEn = $rowComp['compNameEn'];
	mysql_free_result($queryresultComp);
	return $CompNameEn;
}

function playerShortNameEn($playerID){
	$sqlPlayer = "SELECT * FROM players WHERE playerID='$playerID'";
	$queryresultPlayer = mysql_query($sqlPlayer)
	or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	$PlayerFirstNameEn = $rowPlayer['playerFirstNameEn'];
	$PlayerlastNameEn = $rowPlayer['playerLastNameEn'];
	$PlayerNickNameEn = $rowPlayer['playerNickNameEn'];
	$playerNameEn = "$PlayerFirstNameEn $PlayerlastNameEn";
	if ($PlayerNickNameEn == "") {
		return $playerNameEn;
	} else {
		return $PlayerNickNameEn;
	}
}

function season($SeasonID){
	$sqlSes = "SELECT * FROM season WHERE seasonID='$SeasonID'";
	$queryresultSes = mysql_query($sqlSes)
		or die(mysql_error());
	$rowSes = mysql_fetch_assoc($queryresultSes);
	$sesID = $rowSes['seasonID'];
	$start = $rowSes['seasonYearStart'];
	$end = $rowSes['seasonYearEnd'];
	$WhatToEcho = "$start - $end";
	return $WhatToEcho;
	mysql_free_result($queryresultSes);
}

function StadiumName($StadID,$Lang){
	if ($StadID == 0) {
		return "";
	} else {
		$sqlStad = "SELECT * FROM stadiums WHERE stadiumID='$StadID'";
		$queryresultStad = mysql_query($sqlStad)
			or die(mysql_error());
		$rowStad = mysql_fetch_assoc($queryresultStad);
		$stadID = $rowStad['stadiumID'];
		if ($Lang == "ar") {
			$show = "استاد ";
			$show .= $rowStad['stadiumNameAr'];
			return $show;
		}
		elseif ($Lang == "en") {
			$show = $rowStad['stadiumNameAr'];
			$show .= " Stadium";
			return $show;
		}
		mysql_free_result($queryresultStad);
	}
}

function showKit($teamID,$MatchID,$choosenKit){

	$sqlMatch = "SELECT matchSeason,matchDate FROM `matchcenter`.`match` WHERE matchID='$MatchID'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$MatchSeason = $rowMatch['matchSeason'];
	$dateMatch = $rowMatch['matchDate'];

	$sqlSesMatch = "SELECT * FROM season WHERE seasonID='$MatchSeason'";
	$queryresultSesMatch = mysql_query($sqlSesMatch)
		or die(mysql_error());
	$rowSesMatch = mysql_fetch_assoc($queryresultSesMatch);
	$seasonStart = $rowSesMatch['seasonYearStart'];
	mysql_free_result($queryresultSesMatch);
	$seasonStart =  strtotime($seasonStart);
	$dateCompStart = date("Y",$seasonStart)."-07-01";
	//$dateCompStart = strtotime($dateCompStart);
	$dateCompStart = date("Y-m-d",strtotime($dateCompStart));
	if ($dateMatch < $dateCompStart) {
		$dateCompStart = strtotime($dateCompStart);
		$dateStarting = date("Y",$dateCompStart);
		$dateStarting --;
		$dateFinishin = date("Y",$dateCompStart);
	}
	elseif ($dateMatch > $dateCompStart) {
		$dateCompStart = strtotime($dateCompStart);
		$dateStarting = date("Y",$dateCompStart);
		$dateFinishin = date("Y",$dateCompStart);
		$dateFinishin ++;
	}
	$sqlSes = "SELECT * FROM season WHERE seasonYearStart='$dateStarting' AND seasonYearEnd='$dateFinishin'";
	$queryresultSes = mysql_query($sqlSes)
	or die(mysql_error());
	$rowSes = mysql_fetch_assoc($queryresultSes);
	$season = $rowSes['seasonID'];
	mysql_free_result($queryresultSes);


	$sqlKit = "SELECT * FROM kits WHERE kitTeam='$teamID' AND kitSeason='$season'";
	$queryresultKit = mysql_query($sqlKit)
			or die(mysql_error());
	if (mysql_num_rows($queryresultKit) != 0) {
		while($rowKit = mysql_fetch_assoc($queryresultKit)){
			$kitSeason = $rowKit['kitSeason'];
			$kit1 = $rowKit['kit1'];
			$kit2 = $rowKit['kit2'];
			$kit3 = $rowKit['kit3'];
			$sqlSes2 = "SELECT * FROM season WHERE seasonID='$kitSeason'";
			$queryresultSes2 = mysql_query($sqlSes2)
				or die(mysql_error());
			$rowSes2 = mysql_fetch_assoc($queryresultSes2);
			$start = $rowSes2['seasonYearStart'];
			$end = $rowSes2['seasonYearEnd'];
			$subFolder = "$start$end";
			switch($choosenKit){
				case 1:
					return "<img src=\"kits/$subFolder/".$kit1."\">";
					break;
				case 2:
					return "<img src=\"kits/$subFolder/".$kit2."\">";
					break;
				case 3:
					return "<img src=\"kits/$subFolder/".$kit2."\">";
					break;
				default:
					$sqlTeam = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$teamID'";
					$queryresultTeam = mysql_query($sqlTeam)
					or die(mysql_error());
					$rowTeam = mysql_fetch_assoc($queryresultTeam);
					return "<img src=\"teams/".$rowTeam['teamFlag']."\">";

			} // switch
		}
	} else {
		$sqlTeam = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$teamID'";
		$queryresultTeam = mysql_query($sqlTeam)
			or die(mysql_error());
		$rowTeam = mysql_fetch_assoc($queryresultTeam);
		return "<img src=\"teams/".$rowTeam['teamFlag']."\">";
	}
}

function nationalityAdj($natID,$lang){
	$sqlNation = "SELECT * FROM nationality WHERE nationalityID='$natID'";
	$queryresultNation = mysql_query($sqlNation)
		or die(mysql_error());
	$rowNation = mysql_fetch_assoc($queryresultNation);
	if ($lang == "ar") {
		$NatioName = $rowNation['nationalityAdjAr'];
	}
	elseif ($lang == "en"){
		$NatioName = $rowNation['nationalityAdjEn'];
	}
	$NatioFlag = $rowNation['nationalityFlag'];
	//return $NatioName;
	return "$NatioName <img border=\"0\" src=\"flags/$NatioFlag\">";
	mysql_free_result($queryresultNation);
	//echo "	<td>$NatioName <img border=\"0\" src=\"../flags/$NatioFlag\">";
}

function LastTblStanding($matchID,$group,$teamID,$plays,$win,$draw,$loose,$goalsFor,$goalsAgainst,$goalsDef,$points){
	// substract last match to get the last position ............................................................
	$sqlMatchAnalysisLast = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchID'";
	$queryresultMatchAnalysisLast = mysql_query($sqlMatchAnalysisLast)
	or die(mysql_error());
	$result1 = 0;
	$result2 = 0;
	while($rowMatchAnalysisLast = mysql_fetch_assoc($queryresultMatchAnalysisLast)){
		$Mins = $rowMatchAnalysisLast['analysisMins'];
		$half = $rowMatchAnalysisLast['analysisHalf'];
		$team = $rowMatchAnalysisLast['analysisTeam'];
		$analysEvent = $rowMatchAnalysisLast['analysisEvent'];
		if ($half == 0 && $Mins == 90) {
			if ($result1 != 0 || $result2 != 0) {
				break;
			}
			else {
				$result1 = 0;
				$result2 = 0;
			}
		}
		elseif ($analysEvent == 2) {
			if ($team == $teamID) {
				$result1 ++;
			}
			else {
				$result2 ++;
			}
		}
	}
	if ($result1 > $result2) {
		$plays --;
		$win -- ;
		$goalsFor -= $result1;
		$goalsAgainst -= $result2;
		$points -= 3;
	}
	elseif ($result1 < $result2) {
		$plays --;
		$loose --;
		$goalsFor -= $result1;
		$goalsAgainst -= $result2;
		$points -= 0;
	}
	else {
		$plays --;
		$draw --;
		$goalsFor -= $result1;
		$goalsAgainst -= $result2;
		$points -= 1;
	}

	$goalsDef = $goalsFor - $goalsAgainst;
	$sqlTableStandingPre = "INSERT INTO tableStandingPrevious (teamGroup, teamID, played, won, draw, lost, goalsFor, goalsAgainst, goalsDif, points)
				VALUES ('$group','$teamID','$plays','$win','$draw','$loose','$goalsFor','$goalsAgainst','$goalsDef','$points');";
	mysql_query($sqlTableStandingPre) or die (mysql_error());

	// end subrtacting ################################################################################################################
}

$positionEn = array("Goal Keeper","Defender","FullBack","Defensive Midfielder","Midfielder","Forward");
$positionAr = array("حارس مرمى","مدافع","ظهير","محور","وسط","مهاجم");
$positionSortCut = array("GK","DF","FB","DM","MF","FW");
$LevelEn = array("Manager","Assistant manager","Fitness coach","Goalkeeping coach","First team coach","Reverse team manager","Reverse team coach","Doctor","Physiotherapist","Masseur");
$LevelAr = array("مدير فني","مساعد مدرب","مدرب لياقة","مدرب حراس","مدرب الفريق الأول","مدير فني للرديف","مدرب الفريق الرديف","طبيب","أخصائي علاج طبيعي","مدلّك");
$AdminEn = array("Chairman","Assistant chairman","Football team director","First team assistant director","First team administrator","Reverse team director","Reverse team assistant director","Reverse team administrator","Director Professionalism","Coordinator");
$AdminAr = array("الرئيس","نائب الرئيس","مدير عام كرة القدم","مساعد مدير الفريق الأول","إداري الفريق الأول","مدير الفريق الرديف","مساعد مدير الفريق الرديف","إداري الفريق الرديف","مدير الإحتراف","منسق");
$CompSysEn = array("League","Cup-knockout","Cup-Group Stage");
$CompSysAr = array("دوري","كأس خروج مغلوب","كأس مجموعات");
$refClassEn = array("Referee","Assistant referee");
$refClassAr = array("حكم ساحة","حكم مساعد");
$SeasonTypeEn = array("Players","Coaching staff","Administration staff");
$SeasonTypeAr = array("لاعبين","جهاز فني", "جهاز إداري");
$matchTypeEn = array("line-up","Substitution","Manager","Team director","Chairman","Subs make it","Lined up went out");
$matchTypeAr = array("أساسي","إحتياط","مدرب", "مدير الفريق","رئيس النادي","إحتياط لعب","أساسي طلع");
$EventSimpleEn = array("Comment","Substitution","Goal","Yellow Card", "Red Card","Assist","Shot on target","Shot off target","Offside","Corner kick","Penalty","Penalty scored","Penalty missed");
$EventSimpleAr = array("تعليق","تبديل","هدف","كرت أصفر", "كرت أحمر","تمريرة هدف","تسديدة داخل المرمى","تسديدة خارج المرمى","تسلل","ضربة ركنية","تسبب في ضربة جزاء","سجل ضربة جزاء","اضاع ضربة جزاء");
$EventSimpleLiveAr = array("تعليق","تبديل","هدف","كرت أصفر", "كرت أحمر","تمريرة هدف");
//$EventAdvEn = array("Shot on target","Shot off target","Penalty scored","Penalty missed","Foul conceded","Foul Given","Penalty kick conceded","Penalty kick given","Successful Short Pass","Missed Short Pass","Successful long Pass","Missed long Pass","Tackle","Miss ball","Random clear","Correct clear","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul","Successful corner kick","Unsuccessful corner kick","Huge mistake");
//$EventAdvAr = array("تسديدة داخل المرمى","تسديدة خارج المرمى","ضربة جزاء مسجله","ضربة جزاء مهدرة","خطأ مكتسب","خطأ مسبب","ضربة جزاء مكتسبه","ضربة جزاء مسببه","تمريره قصيره صحيحه","تمريره قصيره خاطئه","تمريره طويلة صحيحه","تمريره طويلة خاطئه","استخلاص كره","افتقاد كره","تشتيت كره عشوائي","تشتيت كره صحيح","تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد","تنفيذ صحيح لضربة ركنية","تنفيذ خاطئ لضربة ركنية","خطأ فادح");
$EventAdvanceEn = array("Shots","Fouls","'Set pieces","Passes","Defence","GoalKeepers");
$EventAdvanceAr = array("تسديدات","أخطاء","كرات ثابته","تمريرات","دفاع","حارس");
$EventShotEn = array("Shot on target","Shot off target","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul");
$EventShotAr = array("تسديدة داخل المرمى","تسديدة خارج المرمى","تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد");
$EventfoulEn = array("Foul conceded","Foul Given","Penalty kick conceded","Penalty kick given","Offside");
$EventfoulAr = array("خطأ مكتسب","خطأ مسبب","ضربة جزاء مكتسبه","ضربة جزاء مسببه","تسلل");
$EventSetEn = array("Penalty scored","Penalty missed","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul","Successful corner kick","Unsuccessful corner kick");
$EventSetAr = array("ضربة جزاء مسجله","ضربة جزاء مهدرة","تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد","تنفيذ صحيح لضربة ركنية","تنفيذ خاطئ لضربة ركنية");
$EventPassEn = array("Successful Short Pass","Missed Short Pass","Successful long Pass","Missed long Pass","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul","Successful corner kick","Unsuccessful corner kick");
$EventPassAr = array("تمريره قصيره صحيحه","تمريره قصيره خاطئه","تمريره طويلة صحيحه","تمريره طويلة خاطئه","تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد","تنفيذ صحيح لضربة ركنية","تنفيذ خاطئ لضربة ركنية");
$EventDefEn = array("Tackle","Miss ball","Random clear","Correct clear","Huge mistake");
$EventDefAr = array("استخلاص كره","افتقاد كره","تشتيت كره عشوائي","تشتيت كره صحيح","خطأ فادح");
$EventGKEn = array("Save on target","Save off target","Penalty Saved","1 on 1 save");
$EventGKAr = array("صده داخل المرمى","صده خارج المرمى","منع تسجيل ضربة جزاء","منع انفراد");
$userPrivilage = array("Admin","coAdmin","Commentator","Analysist");

?>