<?php
$read = 1;
$write = 2;
$readwrite = 16;
$local_admin = 32;
$global_admin = 64;

$jim = 96;
$mike = 16;

echo "Is Mike Allowed to edit? he has an access level of 16<BR>";
if($mike & 32)
{
	echo  'YES MIKE CAN EDIT';
} else {
	echo  'NO HE CANNOT';
}

echo "<BR><BR>Is Jim  Allowed to edit? he has an access level of 96<BR>";
if($jim & 32)
{
	echo  'YES JIM CAN EDIT';
} else {
	echo  'NO HE CANNOT';
}
?>