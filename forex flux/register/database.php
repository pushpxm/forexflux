<?php

$host = "localhost";
$dbname = "exampleDB";
$username = "programmerhero";
$password = "yourpassword";

$mysqli = new mysqli($host,$username,$password,$dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;