<?php
/**
 * Template Name: Contato
 */
get_header(); ?>

<h1 class="titulo">Contato</h1>

<main class="container page-contato-container">
    <div class="contato-grid">
        <section class="contato-info">
            <h2>Fale Conosco</h2>
            <p>Dúvidas sobre nossos produtos ou sobre seu pedido? Entre em contato por um de nossos canais oficiais.</p>
            
            <ul class="contato-lista">
                <li>
                    <strong>WhatsApp:</strong> 
                    <a href="https://wa.me/5521964531822" target="_blank">(21) 96453-1822</a>
                </li>
                <li>
                    <strong>Redes Sociais:</strong>
                    <div class="contato-social">
                        <a href="https://facebook.com/ckscosmeticos" target="_blank">Facebook</a> | 
                        <a href="https://www.instagram.com/cosmeticoscks/" target="_blank">Instagram</a>
                    </div>
                </li>
                <li>
                    <strong>Endereço:</strong><br>
                    <?php 
                        $countries = WC()->countries;
                        $base_address = $countries->get_base_address();
                        $base_city = $countries->get_base_city();
                        $base_state = $countries->get_base_state();
                        echo "$base_address, $base_city - $base_state";
                    ?>
                </li>
            </ul>

            <div class="contato-revenda-card">
                <h3>Seja um Revendedor</h3>
                <p>Interessado em revender Cks Cosméticos? Clique no botão abaixo para atendimento exclusivo.</p>
                <a href="https://wa.me/5521964531822?text=Olá%2C+tenho+interesse+em+ser+revendedor+CKS" class="btn-link" target="_blank">Quero Revender</a>
            </div>
        </section>

        <section class="contato-mapa">
            <h2>Nossa Localização</h2>
            <div class="mapa-container">
                <!-- Mapa Real Incorporado -->
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.2155706422784!2d-43.208139!3d-22.906417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x997f0224d9c73b%3A0xc3b5e43a9b1c7c4e!2sR.%20C%C3%A9sar%2C%20211%20-%20Rocha%2C%20Rio%20de%20Janeiro%20-%20RJ%2C%2020950-160!5e0!3m2!1spt-BR!2sbr!4v1710100000000!5m2!1spt-BR!2sbr" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>