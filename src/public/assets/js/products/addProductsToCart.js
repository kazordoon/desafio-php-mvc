import getProductsIds from './getProductsIds.js';

export default async function addProductsToCart() {
  const productsIds = getProductsIds();
  const formData = new FormData();
  formData.append('productsIds', productsIds.join(','));

  try {
    await fetch('/cart', {
      method: 'POST',
      body: formData,
    });

    location.href = '/cart';
  } catch (err) {
    alert('Não foi possível adicionar este produto ao carrinho.');
  }
}
