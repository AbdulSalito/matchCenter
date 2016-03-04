<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>MatchCenter </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/styleLive.css" />
</head>
<?php
	require_once('Functions.php');
include 'AdminPages/db_conn.php';

if (isset($_GET["match"])) {
	$matchIDGet = $_GET["match"];
	echo "<body onload=\"matchDetailsAJAX('$matchIDGet','result','1','result')";
	if (isset($_GET["Details"])) {
		if ($_GET["Details"] == "TextNPlayer") {
			echo "matchDetailsAJAX('$matchIDGet','playersList','simple','playerList');matchDetailsAJAX('$matchIDGet','text','1','Comments')\">";
			echo "<script type=\"text/javascript\">";
			echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','result','1','result')\", 2000 );";
			echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','playersList','simple','playerList')\", 2000 );";
			echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','text','1','Comments')\", 2000 );";
			echo "</script>";
			echo "<div id=\"result\"></div>";
			echo makeLinksLive($matchIDGet);
			echo "<div id=\"playerList\"></div>";
			echo "<div id=\"Comments\"></div>";
		}
		elseif ($_GET["Details"] == "FullStat") {
			echo "matchDetailsAJAX('$matchIDGet','playersList','full','FullPlayer');\">";
			echo "<div id=\"result\"></div>";
			echo makeLinksLive($matchIDGet);
			echo "<div id=\"FullPlayer\"></div>";
			echo "<script type=\"text/javascript\">";
			echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','result','1','result')\", 2000 );";
			echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','playersList','full','FullPlayer')\", 2000 );";
			echo "</script>";
		}
	}
	else {
		echo "matchDetailsAJAX('$matchIDGet','playersList','simple','playerList');matchDetailsAJAX('$matchIDGet','text','1','Comments')\">";
		echo "<script type=\"text/javascript\">";
		echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','result','1','result')\", 2000 );";
		echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','playersList','simple','playerList')\", 2000 );";
		echo "window.setInterval(\"matchDetailsAJAX('$matchIDGet','text','1','Comments')\", 2000 );";
		echo "</script>";
		echo "<div id=\"result\"></div>";
		echo makeLinksLive($matchIDGet);
		echo "<div id=\"playerList\"></div>";
		echo "<div id=\"Comments\"></div>";
	}
	echo "<script type=\"text/javascript\" src=\"js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"js/getSec.js\"></script>\n";
	/*echo "<script type=\"text/javascript\" src=\"js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"js/test.js\"></script>\n";
	echo "	<td><a href=\"javascript:addComp('CompFrame');\">add Competition</a></td>\n";
	echo "<iframe id=\"CompFrame\" src=\"javascript:false;\" scrolling=\"no\" frameborder=\"0\"></iframe>";*/
	//echo "<div id=\"all\">";

	//echo "</div>";
	//HideDiv('playerListFull');HideDiv('commentsFull');HideDiv('info');
	/*echo "<div id=\"playerListFull\" class=\"mainDiv\"></div>";
	echo "<div id=\"commentsFull\" class=\"mainDiv\"></div>";
	echo "<div id=\"info\"></div>";*/
}

?>
	</body>
</html>