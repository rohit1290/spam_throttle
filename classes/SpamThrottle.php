<?php
use Elgg\DefaultPluginBootstrap;

class SpamThrottle extends DefaultPluginBootstrap {

  public function init() {

    elgg_register_event_handler('create', 'all', 'create_check');
  	
  	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'hover_menu', 1000);
  	elgg_register_plugin_hook_handler('spam_throttle', 'entity_count:global', 'global_messages_count_correction');
  	elgg_register_plugin_hook_handler('spam_throttle', 'entity_count', 'messages_count_correction');
  }
  
  public function activate() {
    $version = (int) elgg_get_plugin_setting('version', PLUGIN_ID);
    if (!$version) {
    	elgg_get_plugin_from_id(PLUGIN_ID)->setSetting('version', PLUGIN_VERSION);
    }
  }
}