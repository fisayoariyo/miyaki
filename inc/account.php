<?php
/**
 * WooCommerce customer account support.
 *
 * @package Miyaki
 */

defined( 'ABSPATH' ) || exit;

/**
 * Recommend account settings on theme switch.
 */
function miyaki_configure_account_settings() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	update_option( 'woocommerce_enable_myaccount_registration', 'yes' );
	update_option( 'woocommerce_registration_generate_username', 'yes' );
	update_option( 'woocommerce_registration_generate_password', 'yes' );
}
add_action( 'after_switch_theme', 'miyaki_configure_account_settings' );

/**
 * Account page intro for guests.
 */
function miyaki_account_guest_intro() {
	if ( is_user_logged_in() || ! is_account_page() ) {
		return;
	}
	?>
	<div class="account-intro reveal">
		<span class="section-label"><? esc_html_e( 'Your account', 'miyaki' ); ?></span>
		<p class="account-intro__text"><? esc_html_e( 'Create an account to track orders, save addresses, and manage returns.', 'miyaki' ); ?></p>
	</div>
	<?php
}
add_action( 'woocommerce_before_customer_login_form', 'miyaki_account_guest_intro', 5 );

/**
 * Dashboard welcome message.
 */
function miyaki_account_dashboard_welcome() {
	$user = wp_get_current_user();
	?>
	<div class="account-welcome reveal">
		<h2 class="account-welcome__title">
			<?php
			printf(
				/* translators: %s: customer display name */
				esc_html__( 'Hello, %s', 'miyaki' ),
				esc_html( $user->display_name ? $user->display_name : $user->user_login )
			);
			?>
		</h2>
		<p class="account-welcome__text">
			<?php esc_html_e( 'From your account dashboard you can view recent orders, manage addresses, and edit your details.', 'miyaki' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'woocommerce_account_dashboard', 'miyaki_account_dashboard_welcome', 5 );
