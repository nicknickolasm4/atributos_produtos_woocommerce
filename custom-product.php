<?php
/**
 * Plugin Name:         Product Fields (Nickolas Mariano)
 * Plugin URI:           https://github.com/nicknickolasm4/atributos_produtos_woocommerce
 * Description:          Adiciona campos personalizados (EAN, NCM, GTIN) aos produtos do WooCommerce.
 * Author:               Nickolas Mariano
 * Author URI:           https://github.com/nicknickolasm4/
 * Version:              1.0.0
 * License:              GPLv2 or later
 * WC requires at least: 3.3.0
 * WC tested up to:      8.8.1
 *
 * This plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this plugin. If not, see
 * <https://www.gnu.org/licenses/gpl-2.0.txt>.
 *
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

    // Adiciona campo GTIN
    woocommerce_wp_text_input(
        array(
            'id'          => '_gtin',
            'label'       => 'GTIN',
            'placeholder' => 'Digite o código GTIN',
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

    // Salva valor do campo GTIN
    $gtin = sanitize_text_field($_POST['_gtin']);
    update_post_meta($post_id, '_gtin', $gtin);
}

add_action('woocommerce_process_product_meta', 'salvar_campos_personalizados');

// Exibe os campos personalizados nos detalhes do produto
function exibir_campos_personalizados() {
    global $product;

    // Obtém valores dos campos EAN, NCM e TT
    $ean = get_post_meta($product->get_id(), '_ean', true);
    $ncm = get_post_meta($product->get_id(), '_ncm', true);
    $gtin  = get_post_meta($product->get_id(), '_gtin', true);

    // Exibe os valores
    echo '<p><strong>EAN:</strong> ' . esc_html($ean) . '</p>';
    echo '<p><strong>NCM:</strong> ' . esc_html($ncm) . '</p>';
    echo '<p><strong>GTIN:</strong> ' . esc_html($gtin) . '</p>';
}

add_action('woocommerce_single_product_summary', 'exibir_campos_personalizados', 25);
