<?php

/**
  * Configuration for database connection
  *
  */

$host       = "localhost";
$port       = "8080";
$username   = "root";
$password   = "root";
$dbname     = "test"; // will use later
$dsn        = "mysql:host=$host;port=$port;dbname=$dbname"; // will use later
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );