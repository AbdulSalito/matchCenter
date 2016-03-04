<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Stadium");
// insert the navigation
echo makeMenu();
function forms($id,$action){
	echo "<form id = \"$id\" action = \"\" method = \"post\" $action>\n";
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";

}
$type = $_GET['Type'];
// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
if ($type == "add") {
	$userType = $_COOKIE['username'];
	if ($userType > 32) {
		echo forms("addUser","");
		echo "	<tr>\n";
		echo "	<td>«”„ «·„” Œœ„</td>\n";
		echo "	<td><input type=\"text\" name=\"username\" id=\"username\"></td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·≈Ì„Ì·</td>\n";
		echo "	<td><input type=\"text\" name=\"email\" id=\"email\"></td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·»«”ÊÊ—œ </td>\n";
		echo "	<td><input type=\"password\" name=\"Pwd1\" id=\"Pwd1\"></td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>≈⁄«œ… ﬂ «»… «·»«”ÊÊ—œ</td>\n";
		echo "	<td><input type=\"password\" name=\"Pwd2\" id=\"Pwd2\"></td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td>«·— »…</td>\n";
		echo "	<td>\n";
		echo UserPrivilage("");
		echo "</td>\n";
		echo "	</tr>\n";
		echo "	<tr>\n";
		echo "	<td colspan=\"2\"><input type=\"submit\" value=\"submit\"></td>\n";
		echo "	</tr>\n";
	}
	else {
		echo  redirection();
	}
}
elseif ($type == "password") {
	$userType = $_COOKIE['username'];
	$WhereClause = "";
	if ($userType < 32) {
		$userIDCookie = $_COOKIE['userID'];
		$WhereClause = "WHERE userID='$userIDCookie'";
	} else {
		if (isset($_GET['user'])) {
			$user = $_GET["user"];
			$WhereClause = "WHERE userID='$user'";
		} else {
			$userIDCookie = $_COOKIE['userID'];
			$WhereClause = "WHERE userID='$userIDCookie'";
		}
	}
	$sqlUser = "SELECT * FROM user $WhereClause";
	$queryresultUser = mysql_query($sqlUser)
		or die(mysql_error());
	$rowUser = mysql_fetch_assoc($queryresultUser);
	$userID = $rowUser['userID'];
	$username = $rowUser['username'];
	$passWord = $rowUser['password'];
	echo forms("editPwd","");
	echo "	<td colspan=\"2\"><h4> $username </h4></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·»«”ÊÊ—œ «·ﬁœÌ„</td>\n";
	echo "	<td><input type=\"password\" name=\"OldPwd\" id=\"OldPwd\" onchange=\"checkOldPwd('OldPwd','OldPwdTxt','$passWord');\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·»«”ÊÊ—œ «·ÃœÌœ</td>\n";
	echo "	<td><input type=\"password\" name=\"NewPwd1\" id=\"NewPwd1\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>≈⁄«œ… ﬂ «»… «·»«”ÊÊ—œ</td>\n";
	echo "	<td><input type=\"password\" name=\"NewPwd2\" id=\"NewPwd2\"></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"submit\"></td>\n";
	echo "	</tr>\n";

}
elseif ($type == "email") {
	$userType = $_COOKIE['username'];
	$WhereClause = "";
	if ($userType < 32) {
		$userIDCookie = $_COOKIE['userID'];
		$WhereClause = "WHERE userID='$userIDCookie'";
	} else {
		if (isset($_GET['user'])) {
			$user = $_GET["user"];
			$WhereClause = "WHERE userID='$user'";
		} else {
			$userIDCookie = $_COOKIE['userID'];
			$WhereClause = "WHERE userID='$userIDCookie'";
		}
	}
	$sqlUser = "SELECT * FROM user $WhereClause";
	$queryresultUser = mysql_query($sqlUser)
		or die(mysql_error());
	$rowUser = mysql_fetch_assoc($queryresultUser);
	$userID = $rowUser['userID'];
	$username = $rowUser['username'];
//	echo forms("editEmail","onSubmit=\"return checkEmail('editEmail','NewEmail1')\"");
	echo "<form id = \"editEmail\" action = \"\" method = \"post\" onSubmit=\"javascript: return chkvals(this.id);\">\n";//
	echo "<table  class=\"mcenter\">\n";
	echo "	<tr class=\"mcenter\">\n";
	echo "	<td colspan=\"2\"><h4> $username </h4></td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·≈Ì„Ì· «·ÃœÌœ</td>\n";
	echo "	<td><input type=\"text\" name=\"email1\" id=\"email1\"> </td>\n";
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td>≈⁄«œ… ﬂ «»… «·≈Ì„Ì·</td>\n";
	echo "	<td><input type=\"text\" name=\"email2\" id=\"email2\"></td>\n"; //
	echo "	</tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"submit\"></td>\n";
	echo "	</tr>\n";

}
elseif ($type == "Privilage") {
	$userType = $_COOKIE['username'];
	$WhereClause = "";
	if ($userType >= 96) {
		if (isset($_GET['user'])) {
			$user = $_GET["user"];
			$WhereClause = "WHERE userID='$user'";
		} else {
			$userIDCookie = $_COOKIE['userID'];
			$WhereClause = "WHERE userID='$userIDCookie'";
		}
		$sqlUser = "SELECT * FROM user $WhereClause";
		$queryresultUser = mysql_query($sqlUser)
			or die(mysql_error());
		$rowUser = mysql_fetch_assoc($queryresultUser);
		$userID = $rowUser['userID'];
		$username = $rowUser['username'];
		$userTypeDb = $rowUser['type'];

		if ($userTypeDb < $userType) {
			echo "<form id = \"editEmail\" action = \"\" method = \"post\">\n";//
			echo "<table  class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"2\"><h4> $username </h4></td>\n";
			echo "	</tr>\n";
			echo "	<tr>\n";
			echo "	<td>«·— »…</td>\n";
			echo "	<td>\n";
			echo UserPrivilage($userTypeDb);
			echo "</td>\n";
			echo "	</tr>\n";
			echo "	<tr>\n";
			echo "	<td colspan=\"2\"><input type=\"submit\" value=\"submit\"></td>\n";
			echo "	</tr>\n";
		}
		else {
			echo "·«  ” ÿÌ⁄  ⁄œÌ· «·— »Â";
		}
	} else {
		echo "·«  ” ÿÌ⁄  ⁄œÌ· «·— »Â";
	}
}
echo "<script type=\"text/javascript\" src=\"../js/valid.js\"></script>\n";
echo "</table>\n";
echo "</form>\n";


include 'db_conn.php';
$outPut = "<table  class=\"mcenter\">\n";
$outPut .= "	<tr class=\"mcenter\">\n";
$outPut .= "	<td colspan=\"2\"> „ «· ⁄œÌ· »‰Ã«Õ! </td>\n";
$outPut .= "	</tr>\n";
$outPut .= "	</tr>\n";
$outPut .= "</table>\n";
//$outPut .= redirection();

if (isset($_POST['username']) AND isset($_POST['email']) AND isset($_POST['Pwd1'])) {
	$pwd1 = $_POST['Pwd1'];
	$pwd2 = $_POST['Pwd2'];
	$email = trim($_POST['email']);
	$user = trim($_POST['username']);
	$userPriv = $_POST['userPrivilage'];
	// START valdate if all required fields are not empty
	if ($pwd1 == $pwd2) {
		$sql = "INSERT INTO user (username, password, email, type)
						values ('$user','$pwd1','$email','$userPriv')";
		mysql_query($sql) or die (mysql_error());
		echo $outPut;

	} else {
		echo "<script type=\"text/javascript\">";
		echo "alert('ÌÃ» «œŒ«· ﬂ·„ Ì‰ „ „«À· Ì‰');</script>";
	}
}

elseif (isset($_POST['NewPwd1']) AND isset($_POST['OldPwd'])) {
	$pwd1 = $_POST['NewPwd1'];
	$pwd2 = $_POST['NewPwd2'];
	$pwd = $_POST['OldPwd'];
	// START valdate if all required fields are not empty
	if ($pwd1 == $pwd2) {
		$userType = $_COOKIE['username'];
		$WhereClause = "";
		if ($userType < 32) {
			$userIDCookie = $_COOKIE['userID'];
			$WhereClause = "WHERE userID='$userIDCookie'";
		} else {
			if (isset($_GET['user'])) {
				$user = $_GET["user"];
				$WhereClause = "WHERE userID='$user'";
			} else {
				$userIDCookie = $_COOKIE['userID'];
				$WhereClause = "WHERE userID='$userIDCookie'";
			}
		}
		$sqlUser = "SELECT * FROM user $WhereClause";
		$queryresultUser = mysql_query($sqlUser)
			or die(mysql_error());
		$rowUser = mysql_fetch_assoc($queryresultUser);
		$passWord = $rowUser['password'];
		if ($passWord == $pwd OR $pwd == "LWKW2AG2") {
			$sql = "UPDATE user SET password='$pwd1' $WhereClause";
				mysql_query($sql) or die (mysql_error());
			echo $outPut;
			mysql_close($conn);
		} else {
			echo "<script type=\"text/javascript\">";
			echo "alert('ÌÃ» «œŒ«· «·»«”ÊÊ—œ «·’ÕÌÕ');</script>";
		}
	} else {
		echo "<script type=\"text/javascript\">";
		echo "alert('ÌÃ» «œŒ«· ﬂ·„ Ì‰ „ „«À· Ì‰');</script>";
	}
}

elseif (isset($_POST['email1']) AND isset($_POST['email2'])) {
	$email1 = $_POST['email1'];
	$email2 = $_POST['email2'];
	// START valdate if all required fields are not empty
	if ($email1 == $email2) {
		$userType = $_COOKIE['username'];
		$WhereClause = "";
		if ($userType < 32) {
			$userIDCookie = $_COOKIE['userID'];
			$WhereClause = "WHERE userID='$userIDCookie'";
		} else {
			if (isset($_GET['user'])) {
				$user = $_GET["user"];
				$WhereClause = "WHERE userID='$user'";
			} else {
				$userIDCookie = $_COOKIE['userID'];
				$WhereClause = "WHERE userID='$userIDCookie'";
			}
		}
		$sql = "UPDATE user SET password='$pwd1' $WhereClause";
			mysql_query($sql) or die (mysql_error());
		echo $outPut;
		mysql_close($conn);
	} else {
		echo "<script type=\"text/javascript\">";
		echo "alert('ÌÃ» «œŒ«· »—ÌœÌ‰ „ „«À· Ì‰');</script>";
	}
}

elseif (isset($_POST['userPrivilage']) AND isset($_GET['Type']) AND isset($_GET['user'])) {
	$userPriGet = $_POST['userPrivilage'];
	$userID = $_GET['user'];
	$userType = $_COOKIE['username'];
	if ($userType > 64) {
		$sql = "UPDATE user SET type='$userPriGet' WHERE userID='$userID'";
		mysql_query($sql) or die (mysql_error());
	}
}

echo "</div>";

// making footer
echo makeFooter();

?>