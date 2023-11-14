<?php
/*
Plugin Name: (EAN, NCM, GTIN) Product Fields
Description: Adiciona campos personalizados (EAN, NCM, GTIN) aos produtos do WooCommerce.
Version: 1.1
Author: Nickolas Mariano
*/

if (!defined('ABSPATH')) {
    exit;
}

// Adiciona os campos personalizados aos produtos
function adicionar_campos_personalizados() {
    // Adiciona campo EAN
    woocommerce_wp_text_input(
        array(
            'id'          => '_ean',
            'label'       => 'EAN',
            'placeholder' => 'Digite o código EAN',
            'desc_tip'    => 'true',
        )
    );

    // Adiciona campo NCM
    woocommerce_wp_text_input(
        array(
            'id'          => '_ncm',
            'label'       => 'NCM',
            'placeholder' => 'Digite o código NCM',
            'desc_tip'    => 'true',
        )
    );

    // Adiciona campo TT
    woocommerce_wp_text_input(
        array(
            'id'          => '_tt',
            'label'       => 'TT',
            'placeholder' => 'Digite o código TT',
            'desc_tip'    => 'true',
        )
    );
}

add_action('woocommerce_product_options_general_product_data', 'adicionar_campos_personalizados');

// Salva os valores dos campos personalizados
function salvar_campos_personalizados($post_id) {
    // Salva valor do campo EAN
    $ean = sanitize_text_field($_POST['_ean']);
    update_post_meta($post_id, '_ean', $ean);

    // Salva valor do campo NCM
    $ncm = sanitize_text_field($_POST['_ncm']);
    update_post_meta($post_id, '_ncm', $ncm);

    // Salva valor do campo TT
    $tt = sanitize_text_field($_POST['_tt']);
    update_post_meta($post_id, '_tt', $tt);
}

add_action('woocommerce_process_product_meta', 'salvar_campos_personalizados');

// Exibe os campos personalizados nos detalhes do produto
function exibir_campos_personalizados() {
    global $product;

    // Obtém valores dos campos EAN, NCM e TT
    $ean = get_post_meta($product->get_id(), '_ean', true);
    $ncm = get_post_meta($product->get_id(), '_ncm', true);
    $tt  = get_post_meta($product->get_id(), '_tt', true);

    // Exibe os valores
    echo '<p><strong>EAN:</strong> ' . esc_html($ean) . '</p>';
    echo '<p><strong>NCM:</strong> ' . esc_html($ncm) . '</p>';
    echo '<p><strong>TT:</strong> ' . esc_html($tt) . '</p>';
}

add_action('woocommerce_single_product_summary', 'exibir_campos_personalizados', 25);