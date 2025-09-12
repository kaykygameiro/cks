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

function cks_loop_shop_per_page() {
  return 6;
}
add_filter('loop_shop_per_page', 'cks_loop_shop_per_page');

function remove_some_body_class($classes) {
  $woo_class = array_search('woocommerce', $classes);
  $woopage_class = array_search('woocommerce-page', $classes);
  $search = in_array('archive', $classes) || in_array('product-template-default', $classes);
  if($woo_class || $woopage_class || $search) {
    unset($classes[$woo_class]);
    unset($classes[$woopage_class]);
  }
  return $classes;
}
add_filter('body_class', 'remove_some_body_class');

function format_products($products, $img_size = 'medium') {
  $products_final = [];
  foreach($products as $product) {
    $products_final[] = [
      'name' => $product->get_name(),
      'price' => $product->get_price_html(),
      'link' => $product->get_permalink(),
      'img' => wp_get_attachment_image_src($product->get_image_id(), $img_size)[0],
    ];
  }
  return $products_final;
}

// Função para exibir lista de produtos
function cks_product_list($products) { ?>
  <ul class="products-list">
    <?php foreach($products as $product) { ?>
      <li class="product-item">
        <a href="<?= $product['link']; ?>">
          <div class="product-info">
            <img src="<?= $product['img']; ?>" alt="<?= $product['name']; ?>">
            <h2><?= $product['name']; ?> - <span><?= $product['price']; ?></span></h2>
          </div>
          <div class="product-overlay">
            <span class="btn-link">Ver Mais</span>
          </div>
        </a>
      </li>
    <?php } ?>
  </ul>
<?php 
}

// Traduzir textos do WooCommerce
function cks_translate_woocommerce_texts($translated_text, $text, $domain) {
  // Só processa se for domínio WooCommerce
  if ($domain !== 'woocommerce') return $translated_text;
  // Evita loops e só traduz se necessário
  if ($translated_text === 'Estimated total') return 'Total';
  if ($translated_text === 'Subtotal') return 'Subtotal';
  if ($translated_text === 'Total') return 'Total';
  if ($translated_text === 'Proceed to checkout' || $translated_text === 'Continue to checkout') return 'Avançar para o pagamento';
  return $translated_text;
}
add_filter('gettext', 'cks_translate_woocommerce_texts', 10, 3);

// Filtro específico para blocos WooCommerce
function cks_translate_woocommerce_blocks($translated_text, $text, $domain) {
  // Só processa se for domínio dos blocos
  if ($domain !== 'woo-gutenberg-products-block') return $translated_text;
  if ($translated_text === 'Estimated total') return 'Total';
  if ($translated_text === 'estimated total') return 'total';
  if ($translated_text === 'Proceed to checkout' || $translated_text === 'Continue to checkout') return 'Avançar para o pagamento';
  return $translated_text;
}
add_filter('gettext', 'cks_translate_woocommerce_blocks', 20, 3);

// Adicionar JavaScript para traduzir textos dinamicamente
function cks_translate_estimated_total_js() {
  ?>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    function translateTexts() {
      // Selecionar todos os elementos que podem conter "Estimated total"
      const labels = document.querySelectorAll('.wc-block-components-totals-item__label, .cart-totals th, .shop_table th');
      
      labels.forEach(function(label) {
        if (label.textContent.includes('Estimated total')) {
          label.textContent = label.textContent.replace('Estimated total', 'Total');
        }
        if (label.textContent.includes('estimated total')) {
          label.textContent = label.textContent.replace('estimated total', 'total');
        }
      });
      
      // Traduzir botões de finalização
      const buttons = document.querySelectorAll('a.checkout-button, .wc-block-cart__submit-button, .wp-block-woocommerce-proceed-to-checkout-block a, .wc-proceed-to-checkout a');
      
      buttons.forEach(function(button) {
        if (button.textContent.includes('Proceed to checkout')) {
          button.textContent = button.textContent.replace('Proceed to checkout', 'Avançar para o pagamento');
        }
        if (button.textContent.includes('Continue to checkout')) {
          button.textContent = button.textContent.replace('Continue to checkout', 'Avançar para o pagamento');
        }
        if (button.textContent.includes('Continuar para finalização')) {
          button.textContent = button.textContent.replace('Continuar para finalização', 'Avançar para o pagamento');
        }
        if (button.textContent.includes('Finalizar compra')) {
          button.textContent = button.textContent.replace('Finalizar compra', 'Avançar para o pagamento');
        }
      });
    }
    
    // Executar na carga da página
    translateTexts();
    
    // Executar quando o DOM muda (para blocos dinâmicos)
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.type === 'childList') {
          translateTexts();
        }
      });
    });
    
    // Observar mudanças no carrinho
    const cartContainer = document.querySelector('.wc-block-cart, .woocommerce-cart');
    if (cartContainer) {
      observer.observe(cartContainer, {
        childList: true,
        subtree: true
      });
    }
  });
  </script>
  <?php
}
add_action('wp_footer', 'cks_translate_estimated_total_js');

?>