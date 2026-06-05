<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php bloginfo('name') ?> | <?php wp_title('|'); ?></title>

  <link rel="stylesheet" href="/wp-content/themes/cks/style.css" type="text/css">
  
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>


<?php 

$img_url = get_template_directory_uri() . '/img/';
$cart_count = 0;
if (function_exists('WC') && WC() && WC()->cart) {
  $cart_count = WC()->cart->get_cart_contents_count();
}
?>

<div class="site-benefits-bar">
  <div class="container site-benefits-bar__inner">
    <span>Entrega para todo o Brasil</span>
    <span>Pix e cartão</span>
    <span>Atendimento pelo WhatsApp</span>
    <span>Produtos para revenda</span>
  </div>
</div>

<header class="header container">
<a class="header-logo" href="/"><img src="<?= $img_url; ?>/cks.png" alt="CKS Cosméticos"></a>

<div class="busca">
  <form action="<?php bloginfo('url'); ?>/loja/" method="get">
    <input type="text" name="s" id="s" placeholder="Buscar produtos CKS" value="<?php 
    the_search_query(); ?>" />
    <input type="text" name="post_type" value="product" class="hidden" />
    <input type="submit" id="searchbutton" value="Buscar" />
  </form>

</div>

<nav class="conta">
<a href="/loja" class="loja">Loja</a>
<a href="/minha-conta" class="minha-conta">Minha Conta</a>
<a href="/carrinho" class="carrinho">Carrinho
  <?php if($cart_count)  { ?>
   <span class="carrinho-count"><?=$cart_count?></span>
  <?php } ?>

 
</a>
</nav>

</header>
