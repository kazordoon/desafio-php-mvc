import convertCurrencyToNumber from '../utils/convertCurrencyToNumber.js';
import decreaseTotalPrice from './decreaseTotalPrice.js';
import deleteProductFromSessionStorage from './deleteProductFromSessionStorage.js';

export default async function deleteProduct(event) {
  const productElement = event.target.parentElement.parentElement;
  const productId = productElement.dataset.id;
  const productTotalPrice = event.target
    .parentElement
    .previousElementSibling
    .textContent;
  const numericProductTotalPrice = convertCurrencyToNumber(productTotalPrice);

  try {
    await fetch(`/cart/${productId}`, { method: 'DELETE' });
  } catch (err) {
    console.log(err);
    alert('Não foi possível deletar este produto.');
  }

  decreaseTotalPrice(numericProductTotalPrice);
  deleteProductFromSessionStorage(productId);
  productElement.remove();
}
