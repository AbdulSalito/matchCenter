<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>Alhilalclub MatchCenter </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/style1.css" />
</head>
<?php
require_once('AFunctions.php');
include 'db_conn.php';
//echo loginSys();
if (isset($_GET['sec'])) {
	$sec = $_GET['sec'];
	echo "<body onload=\"CityExFile('getIndex.php','$sec','All','showAdmin')\">";
} else {
	echo "<body>";
}

echo "<div id=\"outerarea\">";
echo "<div id=\"innerarea\">";
echo "<div id = \"header\">";
echo "<img src=\"../images/header.jpg\" align=\"left\">";
echo "<img src=\"../images/headerAr.jpg\" align=\"right\">";
echo "</div>";
echo makeMenu();
echo "<div id = \"maincontent\">\n";
echo "<table  class=\"mcenter\">\n";

$type = $_COOKIE['username'];

if($type < 32 AND $type != 0) {
	echo "	<tr>\n";
	echo "	<td colspan=\"3\"> <a href=\"index.php?sec=matches\">مباريات</a> </td>\n";
	echo "	<td colspan=\"3\"> <a href=\"index.php?sec=user\">خيارات العضو</a> </td>\n";
	echo "	</tr>\n";

}
elseif ($type == 0) {
	echo "	<tr>\n";
	echo "	<td colspan=\"6\"> عضوية موقوفة .. الرجاء مراسلة الإدارة</td>\n";
	echo "	</tr>\n";
}
elseif ($type < 96) {
	echo "	<tr>\n";
	echo "	<td> <a href=\"index.php?sec=players\">لاعبين</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=managers\">مدربين</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=chairmen\">إداريين</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=referee\">حكام</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=clubs\">أندية</a> </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td> <a href=\"index.php?sec=stadium\">ملاعب</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=country\">دول (جنسيات)</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=city\">مدن</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=matches\">مباريات</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=user\">اعضاء موقع</a> </td>\n";
	echo "	</tr>\n";
}
else {
	echo "	<tr>\n";
	echo "	<td> <a href=\"index.php?sec=players\">لاعبين</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=managers\">مدربين</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=chairmen\">إداريين</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=referee\">حكام</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=clubs\">أندية</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=stadium\">ملاعب</a> </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td> <a href=\"index.php?sec=country\">دول (جنسيات)</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=city\">مدن</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=comp\">مسابقات</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=matches\">مباريات</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=inSeason\">موسم</a> </td>\n";
	echo "	<td> <a href=\"index.php?sec=user\">اعضاء موقع</a> </td>\n";
	echo "	</tr>\n";
}
//echo "	<td> <a href=\"javascript:CityExFile('getIndex.php','country','All','showAdmin');\">دول (جنسيات)</a> </td>\n";
echo "	<tr>\n";
echo "	<td colspan=\"6\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"6\"><div id=\"showAdmin\"></div></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "</table>";
echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
echo "</div>";
// making footer
echo makeFooter();
?>