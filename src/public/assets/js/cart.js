(function () {
  const deleteProductButtons = document.querySelectorAll('.product button.delete');
  const increaseProductQuantityButtons = document.querySelectorAll('.product .increase');
  const decreaseProductQuantityButtons = document.querySelectorAll('.product .decrease');
  const totalPriceElement = document.querySelector('#total-price');

  function increaseProductQuantity(event) {
    const productPriceElement = event.target.parentElement.previousElementSibling;
    const productQuantitiesElement = event.target.previousElementSibling;

    const productQuantities = parseInt(productQuantitiesElement.value, 10);
    const productPrice = parseFloat(productPriceElement.textContent);
    const increasedValue = productQuantities + 1;

    const maxQuantity = productQuantitiesElement.getAttribute('max');
    if (increasedValue > maxQuantity) {
      return;
    }

    let totalPrice = convertCurrencyToNumber(totalPriceElement.textContent);
    totalPrice += productPrice;
    totalPrice = formatPrice(totalPrice);

    totalPriceElement.textContent = totalPrice;

    productQuantitiesElement.value = increasedValue;
  }

  function decreaseProductQuantity(event) {
    const productPriceElement = event.target.parentElement.previousElementSibling;
    const productQuantitiesElement = event.target.nextElementSibling;

    const productQuantities = parseInt(productQuantitiesElement.value, 10);
    const productPrice = parseFloat(productPriceElement.textContent);
    const decreasedValue = productQuantities - 1;

    const minQuantity = productQuantitiesElement.getAttribute('min');
    if (decreasedValue < minQuantity) {
      return;
    }

    let totalPrice = convertCurrencyToNumber(totalPriceElement.textContent);
    totalPrice -= productPrice;
    totalPrice = formatPrice(totalPrice);

    totalPriceElement.textContent = totalPrice;

    productQuantitiesElement.value = decreasedValue;
  }

  function convertCurrencyToNumber(currency) {
    const numbers = currency.replace('R$', '').replace(/,/g, '.').split('.');
    const decimal = numbers[numbers.length - 1];
    const integer = numbers.slice(0, numbers.length - 1).join('');

    console.log(numbers);
    const value = parseFloat(`${integer}.${decimal}`);
    return value;
  }

  function formatPrice(number) {
    return Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(number);
  }

  function deleteProductFromSessionStorage(productId) {
    const productsIds = sessionStorage.getItem('productsIds')?.split(',');

    const productIdIndex = productsIds.findIndex(
      (productIdOnSessionStorage) => productIdOnSessionStorage === productId
    );

    productsIds.splice(productIdIndex, 1);

    sessionStorage.setItem('productsIds', productsIds.join(','));
  }

  async function deleteProduct(event) {
    const productElement = event.target.parentElement.parentElement;
    const productId = productElement.dataset.id;
    const productPrice = event.target.parentElement.previousElementSibling.textContent;

    try {
      await fetch(`/cart/${productId}`, { method: 'DELETE' });
    } catch (err) {
      console.log(err);
      alert('Não foi possível deletar este produto.');
    }

    decreateTotalPrice(productPrice);
    deleteProductFromSessionStorage(productId);
    productElement.remove();
  }

  function decreateTotalPrice(amount) {
    const totalPrice = totalPriceElement.textContent;

    let numericTotalPrice = convertCurrencyToNumber(totalPrice);
    numericTotalPrice -= amount;

    const formattedTotalPrice = formatPrice(numericTotalPrice);

    totalPriceElement.textContent = formattedTotalPrice;
  }

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
