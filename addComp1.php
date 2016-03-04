<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>non</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');

echo "<form id = \"addCity\" action = \"addCompCon.php\" method = \"post\">\n"; //onsubmit=\"ExFile('addCompCon.php');\"
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\"> إضافة بطولة </td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>الاسم بالعربي</td>\n";
echo "	<td><input type=\"text\" name=\"NameAr\" id=\"NameAr\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>الاسم بالانجليزي</td>\n";
echo "	<td><input type=\"text\" name=\"NameEn\" id=\"NameEn\"></td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>نظام البطولة</td>\n";
echo "	<td>\n";
echo makeCompSys();
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td>الدولة</td>\n";
echo "	<td>\n";
echo makeNationList("Name","");
echo "	</td></tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\" onclick=\"ExFile('addCompCon.php');\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";

?>
	</body>
</html>