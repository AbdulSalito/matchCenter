<script type="text/javascript">
		VAR putPicUrl = function(PicUrl) {
			document.getElementById("addCountry").flag.value = PicUrl;
		}
		</script>
<?php
$dir = $_GET['dirName'];

// open specified directory
$dirHandle = opendir($dir);
$returnstr = "";
echo "<div class=\"photo\">";
while ($file = readdir($dirHandle)) {
	// if not a subdirectory and if filename contains the string '.jpg'
	if(!is_dir($file) && strpos($file, '.gif')>0) {
		// update count and string of files to be returned
		//$returnstr .= '='.$file;    value==\"$dir/$file\"	putPicUrl(this.src);
		/*echo "<script type=\"text/javascript\">
		Var putPicUrl = function(PicUrl) {
			document.getElementById(\"flag\").value = PicUrl;
		}
		</script>";*/
		echo "<a href=\"javascript:putPicUrl('".$dir."/".$file."');\"><img src=\"$dir/$file\" alt=\"\">\n";
		echo "",basename($file),"</a>\n";
	}
}
//$returnstr .= '&';
echo "</div>\n";
//echo $returnstr;
closedir($dirHandle);
?>