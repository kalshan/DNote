<?php
/*
Plugin Name: Double Note
Description: Adds two custom text fields to the order notes section in WooCommerce and saves them to the database.
Version: 1.0.0
Author: Your Name
Author URI: Your Website
*/

// Add the custom fields to the order notes section in WooCommerce
function double_note_add_fields($order) {
    $field1_value = get_post_meta($order->get_id(), '_double_note_field1', true);
    $field2_value = get_post_meta($order->get_id(), '_double_note_field2', true);

    echo '<div class="order_notes_double_note">';
    woocommerce_wp_text_input(array(
        'id'          => '_double_note_field1',
        'label'       => 'Add note ',
        'placeholder' => 'Enter Field 1',
        'value'       => $field1_value,
    ));

    woocommerce_wp_text_input(array(
        'id'          => '_double_note_field2',
        'label'       => 'Add note 2',
        'placeholder' => 'Enter Field 2',
        'value'       => $field2_value,
        'custom_attributes' => array('style' => 'display: none;'),
    ));

    echo '<button id="show_field2_button" class="button">+</button>';
    echo '</div>';

    // JavaScript to show/hide the second field
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#show_field2_button').click(function() {
                $('#_double_note_field2').toggle();
            });
        });
    </script>
    <?php
}
add_action('woocommerce_admin_order_data_after_order_details', 'double_note_add_fields', 10, 1);

// Save the custom fields to the database
function double_note_save_fields($order_id) {
    if (!empty($_POST['_double_note_field1'])) {
        update_post_meta($order_id, '_double_note_field1', sanitize_text_field($_POST['_double_note_field1']));
    }
    if (!empty($_POST['_double_note_field2'])) {
        update_post_meta($order_id, '_double_note_field2', sanitize_text_field($_POST['_double_note_field2']));
    }
}
add_action('woocommerce_process_shop_order_meta', 'double_note_save_fields');