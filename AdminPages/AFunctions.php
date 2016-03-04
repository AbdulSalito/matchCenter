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
<link rel="stylesheet" type="text/css" href="../css/style1.css" />
</head>
<body>
<div id="outerarea">
<div id="innerarea">
<div id = "header">
<img src="../images/header.jpg" align="left">
<img src="../images/headerAr.jpg" align="right">
</div>
HEAD;
	$headContent .="\n";
	return $headContent;
}

function loginSys(){
	require 'loginconfirm.php';
	if (isset($_SESSION['MCadminlogin'])) {
		echo "<a href=\"logout.php\">LogOut</a>";
	} else {
		echo "<a href=\"login.php\">LogIn</a>";
	}
}

function makeMenu() {
	require 'loginconfirm.php';
	if (isset($_COOKIE['username'])) {
		$userIDCookie = $_COOKIE['userID'];
		$ahref = "logout.php";
		$label = "تسجيل خروج";

		$sqlUser = "SELECT * FROM user WHERE userID='$userIDCookie'";
		$queryresultUser = mysql_query($sqlUser)
			or die(mysql_error());
		$rowUser = mysql_fetch_assoc($queryresultUser);
		$userName = "مرحبا بك يا ". $rowUser['username'];

	}
	else {
		$ahref = "login.php";
		$label = "تسجيل دخول";
		$userName = "";
	}

	$menuContent = <<<MENU
	<div id = "navigation">
<table class="linkstbl">
	<tr>
		<td class="links"><a class="nav" href = "index.php">الرئيسية </a></td>
		<td class="links"></td>
		<td class="links"></td>
		<td class="links"></td>
		<td class="links">$userName </td>
		<td class="links"> <a class="nav" href = "$ahref ">$label </a></td>
	</tr>
</table>
</div>
MENU;
	$menuContent .= "\n";
	return $menuContent;
}

function makeLinksLive($matchIDGet) {
	$LinksLiveContent = <<<LinksLive
	<div id = "links">
<table class="linkstbl">
	<tr>
		<td class="links"></td>
	</tr>
</table>
</div>
LinksLive;
	$LinksLiveContent .= "\n";
	return $LinksLiveContent;
}
//<a class="nav" href="../mailto:alse3loo@gmail.com">السعلو</a>
function makeFooter() {
	$footContent = <<< FOOT
	<div id = "footer">
	<font align="center">MatchCenter 1.0</font><br />
	<font align="left">تطوير </font>
	<font align="right">Developed by <a class="nav" href="../mailto:alse3loo@gmail.com">alse3loo</a></font>
	</div>
	</div>
	</div>
	</body>
	</html>
FOOT;
	return $footContent;
}

function redirection(){
	echo "<p><a href=\"index.php\">back to Modify page</a></p>\n";
}

function getImagesJS() {
	$JScript = <<< JS
<script type="text/javascript">
		var putPicUrl = function(PicUrl,targetID) {
			document.getElementById(""+targetID+"").value = PicUrl;
		}
		</script>
JS;
	return $JScript;
}

function getImages($dir,$height){
	$heightMussre = " style=\"height:";
	$heightMussre .= $height;
	$heightMussre .= "px;\"";
	$dirUp = "../$dir";
	$dirHandle = opendir($dirUp);
	$returnstr = "";
	echo "<div";
	echo $heightMussre;
	echo " id=\"flagsContent\">"; //class=\"photo\"
	while ($file = readdir($dirHandle)) {
		if(!is_dir($file) && strpos($file, '.gif')>0) {
			echo "<a href=\"javascript:putPicUrl('".$file."','$dir');\"><img src=\"../$dir/$file\" alt=\"\">\n";
			echo "",basename($file),"</a> || \n";
		}
	}
	echo "</div>\n";
	closedir($dirHandle);
}

function getImagesKits($dir,$targetID,$Season){

	$dirUp = "../$dir/$Season";
	$dirHandle = opendir($dirUp);
	$returnstr = "";
	echo "<div style=\"height:150px;\" id=\"flagsContent\">"; //class=\"photo\"
	while ($file = readdir($dirHandle)) {
		if(!is_dir($file) && strpos($file, '.gif')>0) {
			echo "<a href=\"javascript:putPicUrl('".$file."','$targetID');\"><img src=\"../$dir/$Season/$file\" alt=\"\">\n";
			echo "",basename($file),"</a> || \n";
		}
	}
	echo "</div>\n";
	closedir($dirHandle);
}

function getColorPicker($fieldID) {
	$Colors = <<< Clr
<script type="text/javascript">
function GetColor(TeamColor, fieldID){
	document.getElementById(fieldID).value = TeamColor;
	document.getElementById(fieldID).style.backgroundColor = "#"+TeamColor;
}
</script>
<table border="1" width="130" height="30">
	<tr>
		<td bgcolor="#FFFFFF" id="FFFFFF" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#0000FF" id="0000FF" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#008000" id="008000" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#FF0000" id="FF0000" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#FFFF00" id="FFFF00" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#808080" id="808080" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="#000000" id="000000" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#800000" id="800000" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#000080" id="000080" onclick="GetColor(this.id,'$fieldID');" > &nbsp;</td>
		<td bgcolor="#66CCFF" id="66CCFF" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#FF6600" id="FF6600" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
		<td bgcolor="#993300" id="993300" onclick="GetColor(this.id,'$fieldID');" >&nbsp;</td>
	</tr>
</table>
Clr;
	return $Colors;
}

function makeCountryList() {
$output = "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";

	include 'db_conn.php';
	$sql = "SELECT * FROM nationality ORDER BY nationalityNameAr";
	$queryresult = mysql_query($sql)
	or die(mysql_error());

	$output .= "<select name = \"country\" id =\"country\" onchange=\"CityExFile('getCity.php','country',this.value,'cityList')\">";
	$output .= "<option value=\"\"> </option>\n";
	while ($row = mysql_fetch_assoc($queryresult)) {
		$natID = $row['nationalityID'];
		$nationalityName = $row['nationalityNameAr'];

		$output .= "<option value=\"$natID\">$nationalityName</option>\n";
	}
	// close the select box
	$output .="</select>";
	$output .= "<div id=\"cityList\"></div>";
	echo $output;
	mysql_free_result($queryresult);
	mysql_close($conn);

}

function makeCountryListEdit($cityIdSelect) {
	$output = "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";

	include 'db_conn.php';
	$sql = "SELECT * FROM nationality ORDER BY nationalityNameAr";
	$queryresult = mysql_query($sql)
		or die(mysql_error());

	$output .= "<select name = \"country\" id =\"country\" onchange=\"CityExFile('getCity.php','country',this.value,'cityList')\">";
	$output .= "<option value=\"\"> </option>\n";
	while ($row = mysql_fetch_assoc($queryresult)) {
		$natID = $row['nationalityID'];
		$nationalityName = $row['nationalityNameAr'];

		$output .= "<option value=\"$natID\">$nationalityName</option>\n";
	}
	// close the select box
	$output .="</select>";
	$output .= "<div id=\"cityList\">";
	$output .= "<select name = \"city\" id =\"city\">";
	$sqlcity = "SELECT * FROM city ";
	$queryresultcity = mysql_query($sqlcity)
		or die(mysql_error());
	while ($rowCity = mysql_fetch_assoc($queryresultcity)) {
		$cityID = $rowCity['cityID'];
		$cityNameAr = $rowCity['cityNameAr'];
		if ($cityID == $cityIdSelect) {
			$output .= "<option selected=\"selected\" value=\"$cityID\">$cityNameAr</option>\n";
		} else {
			$output .= "<option value=\"$cityID\">$cityNameAr</option>\n";
		}
	}
	$output .= "</select>";
	mysql_free_result($queryresultcity);
	$output .= "</div>";
	echo $output;
	mysql_free_result($queryresult);
	mysql_close($conn);

}

function makeStadiumList($selectedElement,$cityWhere) {
	$output = "";
	include 'db_conn.php';
	if (trim($cityWhere) != "") {
		$whereClause = "WHERE stadiumCity='$cityWhere'";
	} else {
		$whereClause = "";
	}
	$sql = "SELECT * FROM stadiums $whereClause";
	$queryresult = mysql_query($sql)
		or die(mysql_error());

	$output .= "<select name = \"stadium\" id =\"stadium\">";
	//$output .= "<option value=\"\"> </option>\n";
	while ($row = mysql_fetch_assoc($queryresult)) {
		$stadID = $row['stadiumID'];
		$stadName = $row['stadiumNameAr'];
		$stadCity = $row['stadiumCity'];

		if ($selectedElement == $stadID) {
			$output .= "<option  selected=\"selected\" value=\"$stadID\">$stadName - ".CityNameAr($stadCity)."</option>\n";
		} else {
			$output .= "<option value=\"$stadID\">$stadName - ".CityNameAr($stadCity)."</option>\n";
		}
	}
	// close the select box
	$output .="</select>";
	echo $output;
	mysql_free_result($queryresult);
	mysql_close($conn);

}

function makeNationList($type,$SelectedElement) {
	include 'db_conn.php';
	if ($type ==  "Adj") {
		$sql = "SELECT * FROM nationality ORDER BY nationalityAdjAr";
			$queryresult = mysql_query($sql)
						or die(mysql_error());
		$output = "<select name = \"nation\" id =\"nation\">";
		$output .= "<option value=\"0\"> </option>\n";
		while ($row = mysql_fetch_assoc($queryresult)) {
			$natID = $row['nationalityID'];
			$nationalityAdj = $row['nationalityAdjAr'];
			if ($SelectedElement == $natID) {
				$output .= "<option selected=\"selected\" value=\"$natID\">$nationalityAdj</option>\n";
			} else {
				$output .= "<option value=\"$natID\">$nationalityAdj</option>\n";
			}
		}
	}
	else {
		$sql = "SELECT * FROM nationality ORDER BY nationalityNameAr";
		$queryresult = mysql_query($sql)
						or die(mysql_error());
		$output = "<select name = \"nation\" id =\"nation\">";
		$output .= "<option value=\"0\"> </option>\n";
		while ($row = mysql_fetch_assoc($queryresult)) {
			$natID = $row['nationalityID'];
			$nationalityName = $row['nationalityNameAr'];
			if ($SelectedElement == $natID) {
				$output .= "<option selected=\"selected\" value=\"$natID\">$nationalityName</option>\n";
			} else {
				$output .= "<option value=\"$natID\">$nationalityName</option>\n";
			}
		}
	}
	$output .="</select>";
	echo $output;
	mysql_free_result($queryresult);
	mysql_close($conn);
}

function makePosition($SelectedElement) {
	global $positionAr;
	$outputPos = "<select name = \"positionList\" id =\"positionList\">";
	for( $i = 0 ; $i < count($positionAr) ; $i++){
		if ($SelectedElement == $i) {
			$outputPos .= "<option selected=\"selected\" value=\"$i\">".$positionAr[$i]."</option>\n";
		} else {
			$outputPos .= "<option value=\"$i\">".$positionAr[$i]."</option>\n";
		}
	}
	$outputPos .="</select>";
	echo $outputPos;
}

function makeHieght($SelectedElement) {
	$outputHght = "<select name = \"HieghtList\" id =\"HieghtList\">";
	for( $i = 150 ; $i < 200 ; $i++){
		if ($i == $SelectedElement) {
			$outputHght .= "<option value=\"$i\" selected=\"selected\">$i</option>\n";
		}
		$outputHght .= "<option value=\"$i\">$i</option>\n";
	}
	$outputHght .="</select>";
	echo $outputHght;
}

function makeLevel($SelectedElement) {
	global $LevelAr;
	$outputLev = "<select name = \"levelList\" id =\"levelList\">";
	for( $i = 0 ; $i < count($LevelAr) ; $i++){
		if ($SelectedElement == $i) {
			$outputLev .= "<option selected=\"selected\" value=\"$i\">".$LevelAr[$i]."</option>\n";
		} else {
			$outputLev .= "<option value=\"$i\">".$LevelAr[$i]."</option>\n";
		}
	}
	$outputLev .="</select>";
	echo $outputLev;
}

function makeAdmin($SelectedElement) {
	global $AdminAr;
	$outputAdm = "<select name = \"adminList\" id =\"adminList\">";
	for( $i = 0 ; $i < count($AdminAr) ; $i++){
		if ($SelectedElement == $i) {
			$outputAdm .= "<option selected=\"selected\" value=\"$i\">".$AdminAr[$i]."</option>\n";
		} else {
			$outputAdm .= "<option value=\"$i\">".$AdminAr[$i]."</option>\n";
		}
	}
	$outputAdm .="</select>";
	echo $outputAdm;
}

function makeTeamSelector($SelectName,$SelectedElement) {
	echo "<select name = \"$SelectName\" id =\"$SelectName\">";
	echo "	<option value=\"\"> </option>";
	include 'db_conn.php';
	$sqlMatch = "SELECT * FROM teams";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$teamID = $rowMatch['teamID'];
		$teamNameAr = $rowMatch['teamNameAr'];
		$teamCity = $rowMatch['teamCity'];
		if ($SelectedElement == $teamID) {
			echo "	<option selected=\"selected\" value=\"$teamID\">$teamNameAr - ".CityNameAr($teamCity)."</option>";
		} else {
			echo "	<option value=\"$teamID\">$teamNameAr - ".CityNameAr($teamCity)."</option>";
		}
	}
	mysql_free_result($queryresultMatch);
	echo "	</select>\n";
}

function makeCompSys($SelectedElement) {
	global $CompSysAr;
	$outputCom = "<select name = \"compList\" id =\"compList\">";
	for( $i = 0 ; $i < count($CompSysAr) ; $i++){
		if ($SelectedElement == $i) {
			$outputCom .= "<option selected=\"selected\" value=\"$i\">".$CompSysAr[$i]."</option>\n";
		} else {
			$outputCom .= "<option value=\"$i\">".$CompSysAr[$i]."</option>\n";
		}
	}
	$outputCom .="</select>";
	echo $outputCom;
}

function makeRefList($SelectedElement) {
	global $refClassAr;
	$outputRef = "<select name = \"refList\" id =\"refList\">";
	for( $i = 0 ; $i < count($refClassAr) ; $i++){
		if ($SelectedElement == $i) {
			$outputRef .= "<option selected=\"selected\" value=\"$i\">".$refClassAr[$i]."</option>\n";
		} else {
			$outputRef .= "<option value=\"$i\">".$refClassAr[$i]."</option>\n";
		}
	}
	$outputRef .="</select>";
	echo $outputRef;
}

function makeSesType() {
	global $SeasonTypeAr;
	$outputRef = "<option value=\"\"> </option>\n";
	for( $i = 0 ; $i < count($SeasonTypeAr) ; $i++){
		$outputRef .= "<option value=\"$i\">".$SeasonTypeAr[$i]."</option>\n";
	}
	$outputRef .="</select>";
	echo $outputRef;
}

function makePlayerNum($selectedNum) {
	$outputPn = "<select name = \"PlayerNum\" id =\"PlayerNum\">";
	$outputPn .= "<option value=\"\"> </option>\n";
	for( $i = 1 ; $i < 100 ; $i++){
		if ($selectedNum == $i) {
			$outputPn .= "<option value=\"$i\" selected=\"selected\">$i</option>\n";
		}
		$outputPn .= "<option value=\"$i\">$i</option>\n";
	}
	$outputPn .="</select>";
	echo $outputPn;
}

function selectedLimit($LimitationCount) {
	$JScriptCB = <<< CheckBoxJS
<script type="text/javascript">
<!--
//initial checkCount of zero
var checkCount=0

//maximum number of allowed checked boxes
var maxChecks= $LimitationCount

function setChecks(obj){
//increment/decrement checkCount
	if(obj.checked){
	checkCount=checkCount+1
	}else{
	checkCount=checkCount-1
	}
//if they checked a 4th box, uncheck the box, then decrement checkcount and pop alert
	if (checkCount>maxChecks){
	obj.checked=false
	checkCount=checkCount-1
	alert('you may only choose up to '+maxChecks+' options')
	}
}
function hightLight(obj,id) {
	if(obj.checked){
		document.getElementById(id).style.backgroundColor = "#CCE4FF";
	}else{
		document.getElementById(id).style.backgroundColor = "#fff";
	}
}
//-->
</script>
CheckBoxJS;
	return $JScriptCB;
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
	return "$NatioName <img border=\"0\" src=\"../flags/$NatioFlag\">";
	mysql_free_result($queryresultNation);
	//echo "	<td>$NatioName <img border=\"0\" src=\"../flags/$NatioFlag\">";
}

function UserPrivilage($SelectedElement){
	global $userPrivilage;
	$outputLev = "<select name = \"userPrivilage\" id =\"userPrivilage\">";
	//for( $i = 0 ; $i < count($userPrivilage) ; $i++){
	foreach($userPrivilage as $key => $value){
		if ($value == 0 AND $SelectedElement == "") {

		}
		elseif ($SelectedElement == $value) {
			$outputLev .= "<option selected=\"selected\" value=\"$value\">$key</option>\n";
		} else {
			$outputLev .= "<option value=\"$value\">$key</option>\n";
		}
	}
	$outputLev .="</select>";
	echo $outputLev;
}


$positionEn = array("Goal Keeper","Defender","FullBack","Defensive Midfielder","Midfielder","Forward");
$positionAr = array("حارس مرمى","مدافع","ظهير","محور","وسط","مهاجم");
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
$EventSimpleLiveAr = array("تعليق","تبديل","هدف","كرت أصفر", "كرت أحمر","تمريرة هدف","ضربة جزاء");
$PenaltiesAr = array("","تسبب في ضربة جزاء","سجل ضربة جزاء","اضاع ضربة جزاء");
$GoalAr = array("هدف" => 0 , "هدف عكسي" => 5);
//$EventAdvEn = array("Shot on target","Shot off target","Penalty scored","Penalty missed","Foul conceded","Foul Given","Penalty kick conceded","Penalty kick given","Successful Short Pass","Missed Short Pass","Successful long Pass","Missed long Pass","Tackle","Miss ball","Random clear","Correct clear","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul","Successful corner kick","Unsuccessful corner kick","Huge mistake");
//$EventAdvAr = array("تسديدة داخل المرمى","تسديدة خارج المرمى","ضربة جزاء مسجله","ضربة جزاء مهدرة","خطأ مكتسب","خطأ مسبب","ضربة جزاء مكتسبه","ضربة جزاء مسببه","تمريره قصيره صحيحه","تمريره قصيره خاطئه","تمريره طويلة صحيحه","تمريره طويلة خاطئه","استخلاص كره","افتقاد كره","تشتيت كره عشوائي","تشتيت كره صحيح","تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد","تنفيذ صحيح لضربة ركنية","تنفيذ خاطئ لضربة ركنية","خطأ فادح");
$EventAdvanceEn = array("Shots","Fouls","'Set pieces","Passes","Defence","GoalKeepers");
$EventAdvanceAr = array("تسديدات","أخطاء","كرات ثابته","تمريرات","دفاع","حارس");
$EventShotEn = array("Shot on target","Shot off target","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul");
$EventShotAr = array("تسديدة داخل المرمى","تسديدة خارج المرمى","تسديد على المرمى لخطأ قريب","تسديد خارج المرمى لخطأ قريب","تسديد على المرمى لخطأ بعيد","تسديد خارج المرمى لخطأ بعيد");
$EventfoulEn = array("Foul conceded","Foul Given","Penalty kick conceded","Penalty kick given","Offside");
$EventfoulAr = array("خطأ مكتسب","خطأ مسبب","ضربة جزاء مكتسبه","ضربة جزاء مسببه","تسلل");
$EventSetEn = array("Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul","Successful corner kick","Unsuccessful corner kick");
$EventSetAr = array("تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد","تنفيذ صحيح لضربة ركنية","تنفيذ خاطئ لضربة ركنية");
$EventPassEn = array("Successful Short Pass","Missed Short Pass","Successful long Pass","Missed long Pass","Nearby successful taken foul","Nearby unsuccessful taken foul","Far successful taken foul","Far unsuccessful taken foul","Successful corner kick","Unsuccessful corner kick");
$EventPassAr = array("تمريره قصيره صحيحه","تمريره قصيره خاطئه","تمريره طويلة صحيحه","تمريره طويلة خاطئه","تنفيذ صحيح لخطأ قريب","تنفيذ خاطئ لخطأ قريب","تنفيذ صحيح لخطأ بعيد","تنفيذ خاطئ لخطأ بعيد","تنفيذ صحيح لضربة ركنية","تنفيذ خاطئ لضربة ركنية");
$EventDefEn = array("Tackle","Miss ball","Random clear","Correct clear","Huge mistake");
$EventDefAr = array("استخلاص كره","افتقاد كره","تشتيت كره عشوائي","تشتيت كره صحيح","خطأ فادح");
$EventGKEn = array("Save on target","Save off target","Penalty Saved","1 on 1 save");
$EventGKAr = array("صده داخل المرمى","صده خارج المرمى","منع تسجيل ضربة جزاء","منع انفراد","خروج صحيح","خروج خاطئ");

$userPrivilage = array("Admin" => 96,"CoAdmin" => 64,"Commentator" => 16,"banned" => 0);

?>