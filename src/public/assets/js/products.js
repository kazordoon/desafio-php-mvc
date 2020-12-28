(function () {
  const hasProductsIdsOnSessionStorage = Boolean(
    sessionStorage.getItem('productsIds')
  );
  let productsIds = [];
  if (hasProductsIdsOnSessionStorage) {
    productsIds = sessionStorage.getItem('productsIds').split(',');
  }
  
  const links = document.querySelectorAll('.product a');
  const goToCartPageLink = document.querySelector('#go-to-cart');

  function saveProduct(productId) {
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

  async function addProductsToCart() {
    const formData = new FormData();
    formData.append('productsIds', productsIds.join(','));

    try {
      await fetch('/cart', {
        method: 'POST',
        body: formData,
      });

      location.href = '/cart';
    } catch (err) {
      alert('Não foi possível adicionar este produto ao estoque.');
    }
  }

  links.forEach((link) => {
    const productId = link.parentElement.dataset.id;
    link.addEventListener('click', () => saveProduct(productId));
  });

  goToCartPageLink.addEventListener('click', addProductsToCart);
})();
