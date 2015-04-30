<?php
/**
* Plugin Name: Whatsservice - Share to Whatsapp
* Plugin URI: http://www.alexander-fuchs.net/whatsservice-whatsapp-share/
* Description: This Plugin uses the Whatsservice API to automatically share Posts to your Whatsapp followers.
* Version: 1.0
* Author: Alexander Fuchs
* Author URI: http://www.alexander-fuchs.net
* License: GPL2
*/

/* Copyright 2014 Alexander Fuchs (email : Alexander-fuchs@hotmail.com) This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA */


//includes
require 'myoptions.php';


//autopublish
function whatsservice_auto_publish( $ID, $post ) {
    $title = $post->post_title;
    $permalink = get_permalink( $ID );
    $ch = curl_init();
	$data = array( 'pkey' => get_option('whatsservice_key'),
       'msg' => array($title."\n".$permalink,'text')
      );
	$data = http_build_query($data);
	curl_setopt($ch, CURLOPT_URL,'https://www.wss.li/api/');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($ch);
	$result = json_decode($content);
}



//init
add_action( 'plugins_loaded', 'whatsservice_init_textdomain' );
add_action( 'admin_menu', 'whatsservice_menu' );

if(get_option('whatsservice_auto_publish',1) == 0)
{
	add_action( 'publish_post', 'whatsservice_auto_publish', 10, 2 );
}

function whatsservice_init_textdomain()
{
//Localization
load_plugin_textdomain('whatsservice', false
			       , dirname(plugin_basename(__FILE__)));
}

?>