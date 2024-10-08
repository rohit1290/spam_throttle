<?php
require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/events.php';

return [
	'plugin' => [
		'name' => 'Spam Throttle',
		'version' => '6.0',
		'dependencies' => [],
	],
	'bootstrap' => SpamThrottle::class,
	'actions' => [
		'spam_throttle/unsuspend' => [],
	],
];
