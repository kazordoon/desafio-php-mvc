import getProductsIds from './getProductsIds.js';

export default function saveProduct(event, productId) {
  const productsIds = getProductsIds();

  const isTheProductAlreadySaved = productsIds.includes(productId);
  if (isTheProductAlreadySaved) {
    return;
  }

  productsIds.push(productId);
  sessionStorage.setItem('productsIds', productsIds);

  const successMessage = document.createElement('p');
  successMessage.textContent = 'Adicionado';
  successMessage.className = 'highlight-success';

  event.target.replaceWith(successMessage);
}
