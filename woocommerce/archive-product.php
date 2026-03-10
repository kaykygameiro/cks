<?php get_header(); ?>
<?php
$products = [];
if(have_posts()) { while(have_posts()) { the_post();
  $products[] = wc_get_product(get_the_ID());
} }

$data = [];
$data['products'] = format_products($products);
?>

<h1 class="titulo">Loja</h1>

<article class="container products-archive">
  <main>
    <?php if($data['products'][0]) { ?>
      <?php cks_product_list($data['products']); ?>
      <?= get_the_posts_pagination(); ?>
    <?php } else { ?>
      <p>Nenhum resultado para a sua busca.</p>
    <?php } ?>
  </main>
</article>

<?php get_footer(); ?>