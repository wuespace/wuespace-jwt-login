<?php
/*
 * Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
 */

use function wuespace\jwt\auth\signIn;

require_once 'system/setup.php';

if (isset($_GET['source']) && isDomainRegistered($_GET['source'])) {
	header('Access-Control-Allow-Origin: ' . $_GET['source']);
	header('Access-Control-Allow-Headers: *');

	if (isset($_POST['user'], $_POST['pass'])) {
		if ($token = signIn($_POST['user'], $_POST['pass'])) {
            echo $token;
		} else {
            http_response_code(401);
            echo 'Bad credentials';
		}
	} else {
		http_response_code(400);
		echo 'Please enter your user data first';
    }
} else {
    http_response_code(400);
}