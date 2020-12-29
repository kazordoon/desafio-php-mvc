export default function getProductsIds() {
  const hasProductsIdsOnSessionStorage = Boolean(
    sessionStorage.getItem('productsIds')
  );
  let productsIds = [];
  if (hasProductsIdsOnSessionStorage) {
    productsIds = sessionStorage.getItem('productsIds').split(',');
  }

  return productsIds;
}
