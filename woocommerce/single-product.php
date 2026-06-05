<?php get_header(); ?>

<?php
  function format_single_product($id, $img_size = 'large') {
    $product = wc_get_product($id);

    $gallery_ids = $product->get_gallery_image_ids();
    $gallery = [];
    if($gallery_ids) {
      foreach($gallery_ids as $img_id) {
        $image = wp_get_attachment_image_src($img_id, $img_size);
        if($image) {
          $gallery[] = $image[0];
        }
      }
    }

    $main_image = wp_get_attachment_image_src($product->get_image_id(), $img_size);

    $stock_html = wc_get_stock_html($product);
    if(!$stock_html) {
      $stock_html = $product->is_in_stock() ? '<p class="stock in-stock">Em estoque</p>' : '<p class="stock out-of-stock">Fora de estoque</p>';
    }

    return [
      'id' => $id,
      'name' => $product->get_name(),
      'price' => $product->get_price_html(),
      'link' => $product->get_permalink(),
      'sku' => $product->get_sku(),
      'description' => $product->get_description(),
      'short_description' => $product->get_short_description(),
      'stock_html' => $stock_html,
      'img' => $main_image ? $main_image[0] : wc_placeholder_img_src($img_size),
      'gallery' => $gallery,
    ];
  }
?>

<div class="container breadcrumb">
  <?php woocommerce_breadcrumb(['delimiter' => ' > ']); ?>
</div>

<div class="container notificacao">
  <?php wc_print_notices(); ?>
</div>

<main class="container product">
<?php
  if(have_posts()) { while(have_posts()) { the_post();
  $produto = format_single_product(get_the_ID());
?>
  <div class="product-gallery <?= empty($produto['gallery']) ? 'product-gallery--single' : ''; ?>" data-gallery="gallery">
    <?php if(!empty($produto['gallery'])) { ?>
      <div class="product-gallery-list">
        <?php foreach($produto['gallery'] as $img) { ?>
          <img data-gallery="list" src="<?= esc_url($img); ?>" alt="<?= esc_attr($produto['name']); ?>">
        <?php } ?>
      </div>
    <?php } ?>
    <div class="produto-gallery-main">
      <img data-gallery="main" src="<?= esc_url($produto['img']); ?>" alt="<?= esc_attr($produto['name']); ?>">
    </div>
  </div>

  <div class="product-detail">
    <?php if($produto['sku']) { ?>
      <small class="product-sku">SKU <?= esc_html($produto['sku']); ?></small>
    <?php } ?>

    <h1><?= esc_html($produto['name']); ?></h1>
    <p class="product-price"><?= $produto['price']; ?></p>

    <?php if($produto['stock_html']) { ?>
      <div class="product-stock"><?= $produto['stock_html']; ?></div>
    <?php } ?>

    <?php woocommerce_template_single_add_to_cart(); ?>

    <div class="product-trust">
      <span>Pix e cartão</span>
      <span>Entrega para todo o Brasil</span>
      <span>Atendimento via WhatsApp</span>
    </div>

    <?php if($produto['short_description']) { ?>
      <div class="product-intro"><?= wp_kses_post(wpautop($produto['short_description'])); ?></div>
    <?php } ?>

    <section class="product-description">
      <h2>Descrição</h2>
      <div class="product-description__content">
        <?= wp_kses_post(wpautop($produto['description'])); ?>
      </div>
    </section>
  </div>
<?php } } ?>
</main>

<?php
  $related_ids = wc_get_related_products($produto['id'], 6);
  $related_products = [];
  foreach($related_ids as $product_id) {
    $related_products[] = wc_get_product($product_id);
  }
  $related = format_products($related_products);
?>

<section class="container-separador product-related">
  <div class="container">
    <h2 class="subtitulo">Relacionados</h2>
    <?php cks_product_list($related); ?>
  </div>
</section>

<?php get_footer(); ?>
