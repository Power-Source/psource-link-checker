<?php
/*
 * Plugin Name: PS Link Checker
 * Plugin URI:  https://power-source.github.io/psource-link-checker/
 * Description: Überprüft Deine Seite auf fehlerhafte Links und fehlende Bilder und benachrichtigt Dich im Dashboard, falls gefunden.
 * Version:     1.0.7
 * Author:      PSOURCE
 * Author URI:  https://github.com/cp-psource
 * Text Domain: psource-link-checker
 * Domain Path: languages
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
Broken Link Checker is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Broken Link Checker is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Broken Link Checker. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
// PS Update Manager - Hinweis wenn nicht installiert
add_action( 'admin_notices', function() {
    // Prüfe ob Update Manager aktiv ist
    if ( ! function_exists( 'ps_register_product' ) && current_user_can( 'install_plugins' ) ) {
        $screen = get_current_screen();
        if ( $screen && in_array( $screen->id, array( 'plugins', 'plugins-network' ) ) ) {
            // Prüfe ob bereits installiert aber inaktiv
            $plugin_file = 'ps-update-manager/ps-update-manager.php';
            $all_plugins = get_plugins();
            $is_installed = isset( $all_plugins[ $plugin_file ] );
            
            echo '<div class="notice notice-warning is-dismissible"><p>';
            echo '<strong>PSOURCE MANAGER:</strong> ';
            
            if ( $is_installed ) {
                // Installiert aber inaktiv - Aktivierungs-Link
                $activate_url = wp_nonce_url(
                    admin_url( 'plugins.php?action=activate&plugin=' . urlencode( $plugin_file ) ),
                    'activate-plugin_' . $plugin_file
                );
                echo sprintf(
                    __( 'Aktiviere den <a href="%s">PS Update Manager</a> für automatische Updates von GitHub.', 'psource-chat' ),
                    esc_url( $activate_url )
                );
            } else {
                // Nicht installiert - Download-Link
                echo sprintf(
                    __( 'Installiere den <a href="%s" target="_blank">PS Update Manager</a> für automatische Updates aller PSource Plugins & Themes.', 'psource-chat' ),
                    'https://github.com/Power-Source/ps-update-manager/releases/latest'
                );
            }
            
            echo '</p></div>';
        }
    }
});


//Path to this file
if ( !defined('BLC_PLUGIN_FILE') ){
	define('BLC_PLUGIN_FILE', __FILE__);
}

//Path to the plugin's directory
if ( !defined('BLC_DIRECTORY') ){
	define('BLC_DIRECTORY', dirname(__FILE__));
}

//Load the actual plugin
require 'core/init.php';


