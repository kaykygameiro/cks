<?php

function cks_add_woocommerce_support() {
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'cks_add_woocommerce_support');

// CSS carregado manualmente no header.php
// function cks_css() {
//   wp_enqueue_style('cks-style', get_template_directory_uri() . '/style.css', [], '1.0.0');
// }
// add_action('wp_enqueue_scripts', 'cks_css');


function mudar_classe_preco() {
  return 'price';
}
add_filter('woocommerce_product_price_class', 'mudar_classe_preco');

function adicionar_antes_do_produto() {
  echo '<div class="minha-classe">';
}
add_action('woocommerce_single_product_summary', 'adicionar_antes_do_produto', -1);

function adicionar_antes_do_produto_2() {
  echo '</div>';
}
add_action('woocommerce_single_product_summary', 'adicionar_antes_do_produto_2', 20);

function cks_custom_images(){
  update_option('medium_crop',1);
}
add_action('after_setup_theme', 'cks_custom_images');

?>