<?php

function env($get, $default = null) {
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	return (getenv($get)) ? getenv($get) : $default;
}
