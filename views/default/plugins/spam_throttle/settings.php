<?php

/*
 * 	This is the form to set the plugin settings
 */


// preamble & explanation
echo elgg_echo('spam_throttle:explanation') . "<br><br>";
echo elgg_echo('spam_throttle:consequence:explanation');
echo "<ul><li><b>" . elgg_echo('spam_throttle:nothing') . "</b> - " . elgg_echo('spam_throttle:nothing:explained') . "<br></li>";
echo "<li><b>" . elgg_echo('spam_throttle:suspend') . "</b> - " . elgg_echo('spam_throttle:suspend:explained') . "<br></li>";
echo "<li><b>" . elgg_echo('spam_throttle:ban') . "</b> - " . elgg_echo('spam_throttle:ban:explained') . "<br></li>";
echo "<li><b>" . elgg_echo('spam_throttle:delete') . "</b> - " . elgg_echo('spam_throttle:delete:explained') . "</li></ul><br>";

// globals
$title = elgg_echo('spam_throttle:settings:global');

$body = elgg_view_field([
	'#type' => 'text',
	'name' => 'params[global_limit]',
	'value' => $vars['entity']->global_limit,
	'#help' => elgg_echo('spam_throttle:helptext:limit', array(elgg_echo('spam_throttle:new_content'))),
]);

$body .= elgg_view_field([
	'#type' => 'text',
	'name' => 'params[global_time]',
	'value' => $vars['entity']->global_time,
	'#help' => elgg_echo('spam_throttle:helptext:time'),
]);

// action to perform if threshold is broken
$body .= elgg_view_field([
	'#type' => 'select',
	'name' => 'params[global_consequence]',
	'value' => $vars['entity']->global_consequence ? $vars['entity']->global_consequence : 'suspend',
	'options_values' => array(
		'nothing' => elgg_echo('spam_throttle:nothing'),
		'suspend' => elgg_echo('spam_throttle:suspend'),
		'ban' => elgg_echo('spam_throttle:ban'),
		'delete' => elgg_echo('spam_throttle:delete')
	),
	'#help' => elgg_echo('spam_throttle:consequence:title', array(elgg_echo('spam_throttle:global'))),
]);
echo elgg_view_module('main', $title, $body);



// loop through all of our object subtypes
$registered_types = elgg_entity_types_with_capability('searchable');
$registered_types['object'][] = 'messages';

foreach ($registered_types as $type => $subtypes) {
	if ($subtypes) {
		foreach ($subtypes as $subtype) {
			$title = elgg_echo('spam_throttle:settings:subtype', array(elgg_echo("item:{$type}:{$subtype}")));
			
			$attr = $type . ':' . $subtype . '_limit';
			$body = elgg_view_field([
				'#type' => 'text',
				'name' => "params[{$attr}]",
				'value' => $vars['entity']->$attr,
				'#help' => elgg_echo('spam_throttle:helptext:limit', array(elgg_echo("item:{$type}:{$subtype}"))),
			]);

			$attr = $type . ':' . $subtype . '_time';
			$body .= elgg_view_field([
				'#type' => 'text',
				'name' => "params[{$attr}]",
				'value' => $vars['entity']->$attr,
				'#help' => elgg_echo('spam_throttle:helptext:time'),
			]);
		
			// action to perform if threshold is broken
			$attr = $type . ':' . $subtype . '_consequence';
			$body .= elgg_view_field([
				'#type' => 'select',
				'name' => "params[{$attr}]",
				'value' => $vars['entity']->$attr ? $vars['entity']->$attr : 'suspend',
				'options_values' => array(
					'nothing' => elgg_echo('spam_throttle:nothing'),
					'suspend' => elgg_echo('spam_throttle:suspend'),
					'ban' => elgg_echo('spam_throttle:ban'),
					'delete' => elgg_echo('spam_throttle:delete')
				),
				'#help' => elgg_echo('spam_throttle:consequence:title', array(elgg_echo("item:{$type}:{$subtype}"))),
			]);
			echo elgg_view_module('main', $title, $body);
		}
	}
	else {
		$title = elgg_echo('spam_throttle:settings:subtype', array(ucfirst($type)));

		$attr = $type . '_limit';
		$body = elgg_view_field([
			'#type' => 'text',
			'name' => "params[{$attr}]",
			'value' => $vars['entity']->$attr,
			'#help' => elgg_echo('spam_throttle:helptext:limit', array(ucfirst($type))),
		]);

		$attr = $type . '_time';
		$body .= elgg_view_field([
			'#type' => 'text',
			'name' => "params[{$attr}]",
			'value' => $vars['entity']->$attr,
			'#help' => elgg_echo('spam_throttle:helptext:time'),
		]);
		
		// action to perform if threshold is broken
		$attr = $type . '_consequence';
		$body .= elgg_view_field([
			'#type' => 'select',
			'name' => "params[{$attr}]",
			'value' => $vars['entity']->$attr ? $vars['entity']->$attr : 'suspend',
			'options_values' => array(
				'nothing' => elgg_echo('spam_throttle:nothing'),
				'suspend' => elgg_echo('spam_throttle:suspend'),
				'ban' => elgg_echo('spam_throttle:ban'),
				'delete' => elgg_echo('spam_throttle:delete')
			),
			'#help' => elgg_echo('spam_throttle:consequence:title', array(ucfirst($type))),
		]);
		
		echo elgg_view_module('main', $title, $body);
	}
}


// length of time of a suspension
echo elgg_view_field([
	'#label' => elgg_echo('spam_throttle:suspensiontime'),
	'#type' => 'text',
	'name' => 'params[suspensiontime]',
	'value' => isset($vars['entity']->suspensiontime) ? $vars['entity']->suspensiontime : 24,
	'#help' => elgg_echo('spam_throttle:helptext:suspensiontime'),
]);

// period for reporting, once in x hours to pre
echo elgg_view_field([
	'#label' => elgg_echo('spam_throttle:reporttime'),
	'#type' => 'text',
	'name' => 'params[reporttime]',
	'value' => isset($vars['entity']->reporttime) ? $vars['entity']->reporttime : 24,
	'#help' => elgg_echo('spam_throttle:helptext:reporttime'),
]);

?>