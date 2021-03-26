<?php
/*
 * Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
 */

$newUsername = getenv('NEW_USERNAME');
$newPassword = getenv('NEW_PASSWORD');

if (!is_string($newUsername) || !is_string($newPassword)) {
	die('NEW_USERNAME and PASS environment variables need to be set.');
}

$username = $newUsername;
if (file_exists(__DIR__ . "/users/$username.json"))
	die("User already exists. File $username.json already exists in users folder.");

$passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

$array = [
	'password' => $passwordHash,
	'data' => ['type' => 'member']
];
$jsonString = json_encode($array, JSON_PRETTY_PRINT);

if (file_put_contents(__DIR__ . "/users/$username.json", $jsonString)) {
	echo "User $username created successfully.";
} else {
	die("User couldn't be created. An error occured while writing to users/$username.json. Please check user permissions.");
}
