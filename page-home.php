<?php
// Template name: Home
get_header(); ?>

<?php
$products_slide = wc_get_products([
  'limit' => 6,
  'tag' => ['slide'],
]);

$products_new = wc_get_products([
  'limit' => 6,
  'orderby' => 'date',
  'order' => 'DESC'
]);

$products_sales = wc_get_products([
  'limit' => 6,
  'meta_key' => 'total_sales',
  'orderby' => 'meta_value_num',
  'order' => 'DESC'
]);

$data = [];

$data['slide'] = format_products($products_slide, 'slide');
$data['lancamentos'] = format_products($products_new, 'medium');
$data['vendidos'] = format_products($products_sales, 'medium');
?>

<?php if(have_posts()) { while (have_posts()) { the_post(); ?>

<section class="slide-wrapper">
  <ul class="slide">
    <?php foreach($data['slide'] as $product) { ?>
    <li class="slide-item">
      <img src="<?= esc_url($product['img']); ?>" alt="<?= esc_attr($product['name']); ?>">
      <div class="slide-info">
        <span class="slide-preco"><?= $product['price']; ?></span>
        <h2 class="slide-nome"><?= esc_html($product['name']); ?></h2>
        <a class="btn-link" href="<?= esc_url($product['link']); ?>">Ver Produto</a>
      </div>
    </li>
    <?php } ?>
  </ul>
</section>

<section class="container home-product-section">
  <h1 class="subtitulo">Mais Vendidos</h1>
  <?php cks_product_list($data['vendidos']); ?>
</section>

<!-- Banner Revendedor -->
<section class="banner-revendedor">
  <a href="https://wa.me/5521964531822?text=Ol%C3%A1%2C+tenho+interesse+em+ser+revendedor+CKS" target="_blank" rel="noopener" title="Fale conosco no WhatsApp">
    <img src="<?= esc_url(get_template_directory_uri()); ?>/img/bannerRevendedor.png" alt="Seja um Revendedor CKS - clique aqui para saber mais">
  </a>
</section>

<section class="container home-product-section">
  <h1 class="subtitulo">Lançamentos</h1>
  <?php cks_product_list($data['lancamentos']); ?>

  <div class="ver-todos-container">
    <a href="/loja" class="btn-link">Ver todos os produtos</a>
  </div>
</section>

<section class="container home-about">
  <div class="home-about__content">
    <span>CKS Cosméticos</span>
    <h2>Sobre a CKS Cosméticos</h2>
    <p>A CKS Cosméticos oferece produtos capilares para cuidado, hidratação, reconstrução e finalização dos fios, com atendimento para clientes e revendedores.</p>
  </div>
</section>

<?php } } ?>

<?php get_footer(); ?>
