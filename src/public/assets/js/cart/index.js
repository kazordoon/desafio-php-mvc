import increaseProductQuantity from './increaseProductQuantity.js';
import decreaseProductQuantity from './decreaseProductQuantity.js';
import deleteProduct from './deleteProduct.js';
import sendProductsQuantitiesToCart from './sendProductsQuantitiesToCart.js';

(function () {
  const goToCheckoutPageButton = document.querySelector('#go-to-checkout');
  const deleteProductButtons = document.querySelectorAll('.product button.delete');
  const increaseProductQuantityButtons = document.querySelectorAll('.product .increase');
  const decreaseProductQuantityButtons = document.querySelectorAll('.product .decrease');

  goToCheckoutPageButton.addEventListener('click', sendProductsQuantitiesToCart);

  increaseProductQuantityButtons.forEach((button) => {
    button.addEventListener('click', increaseProductQuantity);
  });

  decreaseProductQuantityButtons.forEach((button) => {
    button.addEventListener('click', decreaseProductQuantity);
  });

  deleteProductButtons.forEach((button) => {
    button.addEventListener('click', deleteProduct);
  });
})();
