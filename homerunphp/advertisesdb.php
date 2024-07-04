<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//params to connect to the database
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "casamax";

//connection to database
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Database Connection Failed!");
}
