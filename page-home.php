<?php
// Template name: Home
get_header(); ?>

<pre>
<?php
function format_products($products, $img_size) {
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

$products_slide = wc_get_products([
  'limit' => 6,
  'tag' => ['slide'],
]);

$products_new = wc_get_products([
  'limit' => 9,
  'orderby' => 'date',
  'order' => 'DESC'
]);

$products_sales = wc_get_products([
  'limit' => 9,
  'meta_key' => 'total_sales',
  'orderby' => 'meta_value_num',
  'order' => 'DESC'
]);

$data = [];

$data['slide'] = format_products($products_slide, 'slide');
$data['lancamentos'] = format_products($products_new, 'medium');
$data['vendidos'] = format_products($products_sales, 'medium');

?>
</pre>
<?php if(have_posts()) { while (have_posts()) { the_post(); ?>

<!-- <ul class="vantagens">
  <li>Frete Grátis</li>
  <li>Troca Fácil</li>
  <li>Até 12x</li>
</ul> -->

<section class="slide-wrapper">
  <ul class="slide">
    <?php foreach($data['slide'] as $product) { ?>
    <li class="slide-item">
      <img src="<?= $product['img']; ?>" alt="<?= $product['name']; ?>">
      <div class="slide-info">
        <span class="slide-preco"><?= $product['price']; ?></span>
        <h2 class="slide-nome"><?= $product['name']; ?></h2>
        <a class="btn-link" href="<?= $product['link']; ?>">Ver Produto</a>
      </div>
    </li>
    <?php } ?>
  </ul>
</section>

<section class="container">
  <h1 class="subtitulo">Mais Vendidos</h1>
  <?php cks_product_list($data['vendidos']); ?>
</section>

<!-- Banner Revendedor -->
<section class="banner-revendedor">
  <a href="https://wa.me/5521964531822?text=Olá%2C+tenho+interesse+em+ser+revendedor+CKS" target="_blank" title="Fale conosco no WhatsApp">
    <img src="<?= get_template_directory_uri(); ?>/img/bannerRevendedor.png" alt="Seja um Revendedor CKS - clique aqui para saber mais">
  </a>
</section>


<section class="container">
  <h1 class="subtitulo">Lançamentos</h1>
  <?php cks_product_list($data['lancamentos']); ?>
</section>


<?php } } ?>

<?php get_footer(); ?>