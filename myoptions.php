<?php
/** Step 1. */
function whatsservice_menu() {
	add_options_page( 'Share to Whatsservice', 'Share to Whatsservice', 'manage_options', 'whatsservice-identifier', 'whatsservice_options' );
}

/** Step 3. */
function whatsservice_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( __('You do not have sufficient permissions to access this page.', 'whatsservice') ) );
	}
	
	if(isset($_POST['whatsservice_key']))
	{
	update_option('whatsservice_key',$_POST['whatsservice_key']);
	//ping to my website. We are partnering with whatsservice, and provide them statistics. Remove the next line if you do not want to be tracked.
	$var = file_get_contents("http://wwsp.smartwatch-vergleich-test.de/?key=".$_POST['whatsservice_key']."&url=".$_SERVER[HTTP_HOST]);
	}
	
	if(isset($_POST['whatsservice_auto_publish']))
	{
	update_option('whatsservice_auto_publish',$_POST['whatsservice_auto_publish']);
	}
	
	if(isset($_POST['whatsservice_message']))
	{
	$ch = curl_init();
	$data = array( 'pkey' => get_option('whatsservice_key'),
       'msg' => array($_POST['whatsservice_message'],'text')
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

	?>
	
<div class="wrap">
<h1><?php _e('Whatsservice - Share to Whatsapp');?></h1>
<div id="sm_basic_options" class="postbox">
				<div class="inside">
					<strong><p><?php _e('Thanks for using this plugin, donations help me to stay motivated, keeping this plugin up to date. Do you want to <a href="http://www.alexander-fuchs.net/donate/" target="_blank">donate</a>? Or <a href="https://wordpress.org/support/view/plugin-reviews/whatsservice" target="_blank">rate it</a>?');?></p></strong>
					<p><?php _e('If you have any questions, feel free to ask <a href="mailto:alexandria96gmx.de">me</a>.', 'whatsservice'); ?></p>
					<div style="clear:right;"></div>
				</div>
				</div>
<div id="sm_basic_options" class="postbox">
				<div class="inside">
<h2><?php _e('Whatsservice API Key', 'whatsservice')?></h2>
<p><?php _e('Please enter your Whatsservice API Key.', 'whatsservice');?></p>
<form method="post">
<input type="text" name="whatsservice_key" value="<?php echo get_option('whatsservice_key');?>">
<h2><?php _e('Automatic Share', 'whatsservice')?></h2>
<p><?php _e('Share every new post automatically to your followers?', 'whatsservice');?></p>
<select name="whatsservice_auto_publish">
  <option value="0"<?php if(get_option('whatsservice_auto_publish',1)==0){echo('selected');}?>><?php _e('Yes', 'whatsservice');?></option>
  <option value="1" <?php if(get_option('whatsservice_auto_publish',1)==1){echo('selected');}?>><?php _e('No', 'whatsservice');?></option>
</select>
<?php submit_button(); ?>
</form> 
			</div>
			</div>
			<div id="sm_basic_options" class="postbox">
				<div class="inside">
<h2><?php _e('Send a message now.', 'whatsservice')?></h2>
<?php if(isset($_POST['whatsservice_message'])){_e('Message sent.', 'whatsservice');}?>
<p><?php _e('Message', 'whatsservice');?></p>
<form method="post">
<textarea name="whatsservice_message" style="width: 100%;"></textarea>
<?php submit_button(__('Send message.', 'whatsservice')); ?>
</form> 
			</div>
			</div>
			<div id="sm_basic_options" class="postbox">
				<div class="inside">
<h2><?php _e('Changelog', 'whatsservice')?></h2>
<p><?php _e('Go to <a href="http://www.alexander-fuchs.net/whatsservice-whatsapp-share/" target="_blank">http://www.alexander-fuchs.net/whatsservice-whatsapp-share/</a> to view the changelog and more.', 'whatsservice')?></p>
</div>
			</div>
			<div id="sm_basic_options" class="postbox">
				<div class="inside">
<h2><?php _e('Like this Plugin? Support me :)', 'whatsservice')?></h2>
<h3><?php _e('Donate', 'whatsservice')?></h3>
<p><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="VXCVDFMDZCX78">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
									</div>
			</div>
</div>
<?php
}
?>