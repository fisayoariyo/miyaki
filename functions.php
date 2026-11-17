<?php
/**
 * Miyaki theme bootstrap.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

define( 'MIYAKI_VERSION', '2.0.1' );
define( 'MIYAKI_DIR', get_template_directory() );
define( 'MIYAKI_URI', get_template_directory_uri() );

require_once MIYAKI_DIR . '/inc/setup.php';
require_once MIYAKI_DIR . '/inc/enqueue.php';
require_once MIYAKI_DIR . '/inc/customizer.php';
require_once MIYAKI_DIR . '/inc/woocommerce.php';
require_once MIYAKI_DIR . '/inc/account.php';
require_once MIYAKI_DIR . '/inc/elementor.php';
require_once MIYAKI_DIR . '/inc/demo-import.php';
require_once MIYAKI_DIR . '/inc/template-tags.php';
require_once MIYAKI_DIR . '/inc/mega-menu.php';
require_once MIYAKI_DIR . '/inc/quick-view.php';
