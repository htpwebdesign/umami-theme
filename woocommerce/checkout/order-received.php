<?php
/**
 * "Order received" message.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-received.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 *
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;
?>

<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
    <?php
    // Default message
    $message = esc_html__( 'Thank you. Your order has been received. Our orders should take up to 30-45 minutes to complete, but during peak hours it could take up to an hour.', 'woocommerce' );

    if ( $order ) {
        // Get shipping method ID
        $shipping_method = '';
        foreach ( $order->get_items('shipping') as $item_id => $shipping_item ) {
            $shipping_method = $shipping_item->get_method_id();
        }

        // Customize message based on shipping method
        if ( $shipping_method == 'local_pickup' ) {
            $message = esc_html__( 'Thank you for your order! Your items will be ready for pickup in 15 minutes, but during peak hours it may take up to 45 minutes. We thank you for your patience.', 'woocommerce' );
        } elseif ( $shipping_method == 'free_shipping' ) {
            $message = esc_html__( 'Thank you for your order! Your items will be delivered to you in 30 to 45 minutes, but during peak hours it may take up to 1 hour. We thank you for your patience.', 'woocommerce' );
        }
    }

    /**
     * Filter the message shown after a checkout is complete.
     *
     * @since 2.2.0
     *
     * @param string         $message The message.
     * @param WC_Order|false $order   The order created during checkout, or false if order data is not available.
     */
    $message = apply_filters(
        'woocommerce_thankyou_order_received_text',
        $message,
        $order
    );

    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo $message;
    ?>
</p>
