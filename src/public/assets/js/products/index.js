import addProductsToCart from './addProductsToCart.js';
import saveProduct from './saveProduct.js';

(function () {
  const links = document.querySelectorAll('.product a');
  const goToCartPageLink = document.querySelector('#go-to-cart');

  links.forEach((link) => {
    const productId = link.parentElement.dataset.id;
    link.addEventListener('click', (event) => saveProduct(event, productId));
  });

  goToCartPageLink.addEventListener('click', addProductsToCart);
})();
