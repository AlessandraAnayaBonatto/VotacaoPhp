<?php

	$driver = 'mysql';
	$host = 'localhost';
	$dbname = 'trabalho';
	$user = 'root';
	$password = '';

	$db = new PDO("$driver:host=$host;dbname=$dbname",
					$user,$password);
?>