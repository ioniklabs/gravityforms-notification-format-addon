<?php

/*
  Plugin Name: GravityForms Notification Format Addon
  Plugin URI: https://github.com/ioniklabs/gravityforms-notification-format-addon
  Description: 
  Author: Ionik Labs
  Author URI: http://www.ioniklabs.com
  Version: 0.1
 */

if ( !class_exists( 'gf_notification_format_addon' ) ) {

	class gf_notification_format_addon {

		public function __construct() {

			add_filter( 'gform_notification_ui_settings', array( $this, 'gfnf_notification_settings' ), 10, 3 );
			add_filter( 'gform_pre_notification_save', array( $this, 'gfnf_notification_save' ), 10, 2 );
			add_filter( 'gform_notification', array( $this, 'gfnf_notification' ), 10, 3 );

		}

		/**
		 * add options to the notification settings page
		 */
		public static function gfnf_notification_settings( $ui_settings, $notification, $form ) {

			$gfnf_plaintext = rgar( $notification, 'gfnf_plaintext' );

			ob_start();
			?>
				<tr>
					<th>
						<label>GravityForms Notification Format Options</label>
					</th>
					<td>
						<input type="checkbox" id="gfnf_plaintext" <?php if( $gfnf_plaintext ) { ?>checked="checked"<?php } ?> name="gfnf_plaintext" value="1" >
						<label for="gfnf_plaintext" >Send notification as <i>Plain Text</i></label>
					</td>
				</tr>
			<!-- / Notification Format -->
			<?php
			$ui_settings['gf_notification_format'] = ob_get_clean();

			return $ui_settings;
		}

		/**
		 * save notification
		 */
		public static function gfnf_notification_save( $notification, $form ) {

			$gfnf_plaintext = rgpost( 'gfnf_plaintext' );

			$notification['gfnf_plaintext'] = ( $gfnf_plaintext ? '1' : '0' );

			return $notification;

		}

		/**
		 * sending the notification
		 */
		public static function gfnf_notification( $notification, $form, $entry ) {

			$gfnf_plaintext = rgar( $notification, 'gfnf_plaintext' );

			if ( $gfnf_plaintext ) {
				$notification['message_format'] = 'text';
			}

			return $notification;

		}

	}

	new gf_notification_format_addon();

}