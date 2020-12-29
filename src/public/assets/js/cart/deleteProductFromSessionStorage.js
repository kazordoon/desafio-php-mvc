export default function deleteProductFromSessionStorage(productId) {
  const productsIds = sessionStorage.getItem('productsIds')?.split(',');

  const productIdIndex = productsIds.findIndex(
    (productIdOnSessionStorage) => productIdOnSessionStorage === productId
  );

  productsIds.splice(productIdIndex, 1);

  sessionStorage.setItem('productsIds', productsIds.join(','));
}
