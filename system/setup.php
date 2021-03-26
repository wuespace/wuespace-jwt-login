<?php
/*
 * Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
 */

require_once __DIR__ . '/../vendor/autoload.php';
define('CONFIG', json_decode(file_get_contents(__DIR__ . '/../data/config.json'), true));
define('REGISTERED_DOMAINS', json_decode(file_get_contents(__DIR__ . '/../data/registered-domains.json'), true));

require_once __DIR__ . '/auth/sign-in.php';

function isDomainRegistered($domain): bool {
	return in_array($domain, REGISTERED_DOMAINS, true);
}