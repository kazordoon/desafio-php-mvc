import onlyNumbers from './onlyNumbers.js';
import formatExpirationDate from './formatExpirationDate.js';
import handleCheckoutForm from './handleCheckoutForm.js';

(function () {
  const form = document.forms['form-checkout'];

  const creditCardNumberField = document.querySelector('#creditCardNumber');
  const creditCardExpirationDateField = document.querySelector('#creditCardExpirationDate');
  const creditCardCodeField = document.querySelector('#creditCardCode');

  creditCardNumberField.addEventListener('input', (event) => {
    event.target.value = onlyNumbers(event.target.value)
  });

  creditCardExpirationDateField.addEventListener('input', (event) => {
    event.target.value = formatExpirationDate(event.target.value);
  });

  creditCardCodeField.addEventListener('input', (event) => {
    event.target.value = onlyNumbers(event.target.value)
  });

  form.addEventListener('submit', handleCheckoutForm);
})();
