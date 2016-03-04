<?php
session_start();
require_once('AFunctions.php');
echo makeHeader("Admin");


echo "<div id = \"maincontent\">";
echo "<form id = \"login\" action = \"\" method = \"post\">";
echo "<table  class=\"mcenter\">";
echo "<tr class=\"mcenter\">";
echo "<td colspan=\"2\"> Login </td>";
echo "</tr>";
echo "<tr>";
echo "<td>username</td>";
echo "<td><input type=\"text\" name=\"user\" id=\"user\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Password</td>";
echo "<td><input type=\"password\" name=\"pwd\" id=\"pwd\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=\"2\"><input type=\"submit\" value=\"login\"></td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</div>";

echo makeFooter();

if (isset($_POST['user'])) {

	include 'db_conn.php';
	$sql = "SELECT * FROM user";
	$queryresult = mysql_query($sql)
				or die(mysql_error());

	// fill the table
	while ($row = mysql_fetch_assoc($queryresult)) {
		$username = $row['username'];
		$password = $row['password'];
		if($_POST['user'] == $username){
			if ( $_POST['pwd'] == $password ) {
				$type = $row['type'];
				$userID = $row['userID'];
				//$_SESSION['type'] = $row['type'];
				$expire=time()+60*60*24*30;
				setcookie("username", $type, $expire);
				setcookie("userID", $userID, $expire);
				//$_SESSION['user'] = $row['username'];
				header('Location: index.php');
				exit;
			} else {
				//	header('Location: index.php');
				echo "<script type=\"text/javascript\">";
				echo "alert('Wrong Password, Please Try Again')";
				echo "</script>";

			}
		}
	}
}

?>