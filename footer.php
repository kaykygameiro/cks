<footer class="footer">
  <img src="<?= get_stylesheet_directory_uri(); ?>/img/cks.png" alt="Cks">
  <div class="container footer-info">
    <section>
      <h3>Páginas</h3>
      <?php 
        wp_nav_menu([
          'menu' => 'footer',
          'container' => 'nav',
          'container_class' => 'footer-menu'
        ]);
      ?>
    </section>

      <section>
      <h3>Pagamentos</h3>
      <ul>
        <li>Cartão de Crédito</li>
        <li>Boleto Bancário</li>
        <li>PagSeguro</li>
      </ul>
    </section>
    <section>
      <h3>Redes Sociais:</h3>
      <div class="footer-redes-icons">
        <a href="https://facebook.com/ckscosmeticos" target="_blank" title="Facebook">
          <img src="<?= get_template_directory_uri(); ?>/img/icons/facebook.svg" alt="Facebook">
        </a>
        <a href="https://instagram.com/ckscosmeticos" target="_blank" title="Instagram">
          <img src="<?= get_template_directory_uri(); ?>/img/icons/instagram.svg" alt="Instagram">
        </a>
        <a href="https://wa.me/5511999999999" target="_blank" title="WhatsApp">
          <img src="<?= get_template_directory_uri(); ?>/img/icons/whatsapp.svg" alt="WhatsApp">
        </a>
      </div>
    </section>
  
  </div>
  <?php
    $countries = WC()->countries;
    $base_address = $countries->get_base_address();
    $base_city = $countries->get_base_city();
    $base_state = $countries->get_base_state();
    $complete_address = "$base_address, $base_city, $base_state";
  ?>
  <small class="footer-copy">Cks Cosméticos &copy; <?= date('Y'); ?> - <?= $complete_address; ?></small>
</footer>
<?php wp_footer(); ?>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/slide.js"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/script.js"></script>
</body>
</html>