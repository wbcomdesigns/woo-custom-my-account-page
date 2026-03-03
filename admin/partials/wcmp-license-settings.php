<?php
/**
 * License settings tab content.
 *
 * @link       www.wbcomdesigns.com
 * @since      1.7.0
 *
 * @package    Woo_Custom_My_Account_Page
 * @subpackage Woo_Custom_My_Account_Page/admin/partials
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug    = 'woo-custom-my-account-page';
$license = new EasyDigitalDownloads\Updater\Licensing\License( $slug, array( 'slug' => $slug, 'item_id' => 110615 ) );
$status  = get_option( $license->get_status_option_name() );

$license_key    = $license->get_license_key();
$license_status = ! empty( $status->license ) ? $status->license : 'inactive';
$expires        = ! empty( $status->expires ) ? $status->expires : '';
$item_name      = ! empty( $status->item_name ) ? $status->item_name : 'Custom My Account Page for WooCommerce';
$site_count     = ! empty( $status->site_count ) ? $status->site_count : '';
$license_limit  = ! empty( $status->license_limit ) ? $status->license_limit : '';

// Status badge.
$status_labels = array(
	'valid'               => __( 'Active', 'woo-custom-my-account-page' ),
	'active'              => __( 'Active', 'woo-custom-my-account-page' ),
	'inactive'            => __( 'Inactive', 'woo-custom-my-account-page' ),
	'expired'             => __( 'Expired', 'woo-custom-my-account-page' ),
	'disabled'            => __( 'Disabled', 'woo-custom-my-account-page' ),
	'revoked'             => __( 'Revoked', 'woo-custom-my-account-page' ),
	'invalid'             => __( 'Invalid', 'woo-custom-my-account-page' ),
	'site_inactive'       => __( 'Inactive on this site', 'woo-custom-my-account-page' ),
	'item_name_mismatch'  => __( 'Item mismatch', 'woo-custom-my-account-page' ),
	'no_activations_left' => __( 'No activations left', 'woo-custom-my-account-page' ),
);
$status_colors = array(
	'valid'    => '#00a32a',
	'active'   => '#00a32a',
	'expired'  => '#d63638',
	'revoked'  => '#d63638',
	'invalid'  => '#d63638',
	'disabled' => '#d63638',
);
$status_label = $status_labels[ $license_status ] ?? ucfirst( $license_status );
$status_color = $status_colors[ $license_status ] ?? '#996800';

$args = array(
	'id'        => $slug,
	'item_id'   => 110615,
	'slug'      => $slug,
	'name'      => 'Custom My Account Page for WooCommerce',
	'version'   => WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION,
	'license'   => $license,
	'messenger' => new EasyDigitalDownloads\Updater\Messenger(),
);
?>
<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3 class="wbcom-welcome-title"><?php esc_html_e( 'License', 'woo-custom-my-account-page' ); ?></h3>
		</div>
		<div class="wbcom-woo-sell-wrapper">
			<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">

				<div class="wcmp-license-section" style="padding: 20px 0;">

					<div class="wcmp-license-info" style="margin-bottom: 24px; padding: 16px 20px; background: #f6f7f7; border-left: 4px solid <?php echo esc_attr( $status_color ); ?>; border-radius: 2px;">
						<table style="border-collapse: collapse; width: 100%;">
							<tr>
								<td style="padding: 6px 12px 6px 0; font-weight: 600; width: 160px; vertical-align: top;"><?php esc_html_e( 'Product', 'woo-custom-my-account-page' ); ?></td>
								<td style="padding: 6px 0; vertical-align: top;"><?php echo esc_html( $item_name ); ?> <span style="color: #757575;">v<?php echo esc_html( WOO_CUSTOM_MY_ACCOUNT_PAGE_VERSION ); ?></span></td>
							</tr>
							<tr>
								<td style="padding: 6px 12px 6px 0; font-weight: 600; vertical-align: top;"><?php esc_html_e( 'Status', 'woo-custom-my-account-page' ); ?></td>
								<td style="padding: 6px 0; vertical-align: top;">
									<span style="display: inline-block; padding: 2px 10px; border-radius: 3px; font-size: 12px; font-weight: 600; color: #fff; background: <?php echo esc_attr( $status_color ); ?>;">
										<?php echo esc_html( $status_label ); ?>
									</span>
								</td>
							</tr>
							<?php if ( ! empty( $expires ) && 'lifetime' !== $expires ) : ?>
							<tr>
								<td style="padding: 6px 12px 6px 0; font-weight: 600; vertical-align: top;"><?php esc_html_e( 'Expires', 'woo-custom-my-account-page' ); ?></td>
								<td style="padding: 6px 0; vertical-align: top;"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $expires ) ) ); ?></td>
							</tr>
							<?php elseif ( 'lifetime' === $expires ) : ?>
							<tr>
								<td style="padding: 6px 12px 6px 0; font-weight: 600; vertical-align: top;"><?php esc_html_e( 'Expires', 'woo-custom-my-account-page' ); ?></td>
								<td style="padding: 6px 0; vertical-align: top;"><?php esc_html_e( 'Lifetime', 'woo-custom-my-account-page' ); ?></td>
							</tr>
							<?php endif; ?>
							<?php if ( ! empty( $site_count ) && ! empty( $license_limit ) ) : ?>
							<tr>
								<td style="padding: 6px 12px 6px 0; font-weight: 600; vertical-align: top;"><?php esc_html_e( 'Activations', 'woo-custom-my-account-page' ); ?></td>
								<td style="padding: 6px 0; vertical-align: top;">
									<?php
									printf(
										/* translators: %1$s: active site count, %2$s: license limit */
										esc_html__( '%1$s of %2$s sites', 'woo-custom-my-account-page' ),
										esc_html( $site_count ),
										esc_html( 0 == $license_limit ? __( 'Unlimited', 'woo-custom-my-account-page' ) : $license_limit )
									);
									?>
								</td>
							</tr>
							<?php endif; ?>
						</table>
					</div>

					<div class="wcmp-license-form">
						<?php EasyDigitalDownloads\Updater\Templates::load( 'license-control', $args ); ?>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
<?php
// Enqueue SDK JS/CSS for AJAX license activation/deactivation.
if ( class_exists( 'EasyDigitalDownloads\Updater\Registry' ) ) {
	$registry = EasyDigitalDownloads\Updater\Registry::instance();
	if ( $registry->offsetExists( $slug ) ) {
		$registry->offsetGet( $slug )->license_modal();
	}
}
