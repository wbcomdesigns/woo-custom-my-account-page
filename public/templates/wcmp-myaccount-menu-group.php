<?php
/**
 * MY ACCOUNT TEMPLATE MENU ITEM
 *
 * @since 2.0.0
 */
?>

<li class="<?php echo implode( ' ', $classes ) ?>">

    <a href="#" class="group-opener">
        <?php if( ! empty( $options['icon'] ) ) :
            // prevent double fa-
            $icon = strpos( $options['icon'], 'fa-' ) === false ? 'fa-' . $options['icon'] : $options['icon']; ?>
            <i class="fa <?php echo $icon; ?>"></i>
        <?php endif; ?>
        <?php echo $options['label'] ?>
        <i class="opener fa <?php echo $class_icon ?>"></i>
    </a>

    <ul class="myaccount-submenu" <?php echo $options['open'] == 'yes' ? '' : 'style="display:none"'; ?>>
        <?php foreach( $options['children'] as $child => $child_options ) {
            /**
             * Print single endpoint
             */
            do_action('wcmp_print_single_endpoint', $child, $child_options );
        } ?>
    </ul>
</li>