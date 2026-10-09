(function ($) {
  'use strict';

  // Seletores exclusivos da galeria própria; a galeria nativa não é interceptada.
  $(function () {
    document.querySelectorAll('.product-gallery[data-gallery="gallery"]').forEach(function (gallery) {
      const main = gallery.querySelector('[data-gallery="main"]');
      if (!main) return;
      const thumbs = Array.from(gallery.querySelectorAll('button[data-gallery="list"]'));
      const original = { src: main.getAttribute('src'), srcset: main.getAttribute('srcset') || '', alt: main.alt };

      function show(image, selected) {
        main.removeAttribute('srcset');
        main.src = image.src;
        if (image.srcset) main.setAttribute('srcset', image.srcset);
        main.alt = image.alt || original.alt;
        thumbs.forEach(function (thumb) {
          thumb.setAttribute('aria-pressed', String(thumb === selected));
        });
      }

      thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
          show({ src: thumb.dataset.src, srcset: thumb.dataset.srcset }, thumb);
        });
      });

      // WooCommerce continua responsável por preço, estoque e envio do formulário.
      $(gallery.closest('main.product')).find('form.variations_form')
        .on('found_variation.cksGallery', function (event, variation) {
          const image = variation && variation.image;
          if (image && image.src) {
            show({ src: image.src, srcset: image.srcset, alt: image.alt });
          } else {
            show(original, thumbs[0]);
          }
        })
        .on('reset_image.cksGallery', function () {
          show(original, thumbs[0]);
        });
    });
  });
})(jQuery);
