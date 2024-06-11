<?php

// Database configuration
$host = 'localhost'; // host name
$username = 'root'; // database username
$password = ''; // database password
$database = 'listproducts'; // database name

// Create database connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}