import getProductsQuantities from './getProductsQuantities.js';

export default async function sendProductsQuantitiesToCart() {
  const productsElements = [...document.querySelectorAll('.product')];
  let productsQuantities = getProductsQuantities(productsElements);

  const formData = new FormData();
  formData.append('products', productsQuantities);

  try {
    await fetch('/cart/add_quantity', {
      method: 'POST',
      body: formData,
    });
  } catch (err) {
    alert('Não foi possível finalizar o pedido.');
  }

  location.href = '/checkout';
}
