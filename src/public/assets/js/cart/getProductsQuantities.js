/**
 * @return id=quantidade;id=quantidade
 */
export default function getProductsQuantities(productsElements) {
  return productsElements.map((productElement) => {
    const productId = productElement.dataset.id;

    const productQuantityCell = [...productElement.children].find((child) => {
      return child.className.includes('product-quantity');
    });

    const productQuantity = parseInt(
      [...productQuantityCell.children]
      .find((child) => child.className === 'quantity-input').value
    );

    const product = `${productId}=${productQuantity}`;
    return product;
  }).join(';');
}
