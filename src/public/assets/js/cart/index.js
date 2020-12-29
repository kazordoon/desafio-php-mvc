import increaseProductQuantity from './increaseProductQuantity.js';
import decreaseProductQuantity from './decreaseProductQuantity.js';
import deleteProduct from './deleteProduct.js';

(function () {
  const deleteProductButtons = document.querySelectorAll('.product button.delete');
  const increaseProductQuantityButtons = document.querySelectorAll('.product .increase');
  const decreaseProductQuantityButtons = document.querySelectorAll('.product .decrease');

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
