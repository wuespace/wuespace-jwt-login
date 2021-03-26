<?php
/*
 * Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
 */

namespace wuespace\jwt\auth;

use Firebase\JWT\JWT;

/**
 * @param string $username
 * @param string $password
 * @return string | bool Token, if login is valid, or <code>false</code>, if it is invalid
 */
function signIn(string $username, string $password)
{
	$filepath = sprintf("%s/../../data/users/%s.json", __DIR__, urlencode($username));

	if (file_exists($filepath) && $json = file_get_contents($filepath)) {
		$data = json_decode($json, true);
		if (password_verify($password, $data['password'])) {
			return getToken($username, $data['data']);
		}
	}

	return false;
}

function getToken(string $username, array $data): string {
	$key = file_get_contents(
		__DIR__ . '/../../data/keys/key'
	);

// We want to sign the following claims
	$claims = [
		'nbf' => time(),        // Not before
		'iat' => time(),        // Issued at
		'exp' => time() + CONFIG['token_expire_after'], // Expires at
		'iss' => 'login.wuespace.de',          // Issuer
		'aud' => ['*.wuespace.de', 'https://wp.pabloklaschka.de/'],         // Audience
		'sub' => $username,   // Subject
		'data' => $data // additional information
	];

	return JWT::encode(
		$claims,                      // The payload or claims to sign
		$key,                         // The key used to sign
	'RS256'
	);
}