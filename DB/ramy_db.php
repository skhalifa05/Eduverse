<?php

$servername = "localhost";
$dBUsername = "u960723315_geeksupport";
$dBPassword = "Geeksupport2023";
$dBName = "u960723315_Ramy";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection Failed".mysqli_connect_error());
}
