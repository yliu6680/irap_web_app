<?php
$dBServername = "52.73.44.205";
$dBUsername = "userinfo";
$dBPassword = "2019liuBidmcIRAP*";
$dBName = "irapdb";

// Create connection
$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
