<?php

/*$serverName = "localhost";
$dbUsername = "u593024502_Codeology";
$dbPassword = "C.obs1.1";
$dbName = "u593024502_Attend_system";*/
$serverName = "localhost";
$dbUsername = "u960723315_BS_2022";
$dbPassword = "Brightside123";
$dbName = "u960723315_BrightSideSys";

$conn = new mysqli();
$conn->connect($serverName, $dbUsername, $dbPassword, $dbName);

//if conn failed
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}