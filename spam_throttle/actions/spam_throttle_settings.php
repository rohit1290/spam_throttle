<?php

// only allow admins to post
action_gatekeeper();
admin_gatekeeper();

global $CONFIG;

$settings = get_input('settings');
$exempt = get_input('exempt');

// save settings
foreach($settings as $name => $value){
	if($name != "consequence"){
		(int)$value;
		if(empty($value) || spam_throttle_posint($value)){
			elgg_set_plugin_setting($name, $value, 'spam_throttle');
		}
		else{
			// set error for individual fields
			$error = TRUE;
			register_error(sprintf(elgg_echo('spam_throttle:settings:notint'), $name));
		}
	}
}

foreach($settings['consequence'] as $type => $consequence){
	elgg_set_plugin_setting($type.'_consequence', $consequence, 'spam_throttle');
}

// save exemptions
if(is_array($exempt)){
	elgg_set_plugin_setting('exempt', serialize($exempt), 'spam_throttle');
}

if(!$error){
	// set success message
	system_message(elgg_echo('spam_throttle:settings:success'));
}

forward(REFERER);