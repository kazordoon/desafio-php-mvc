import generateErrorMessage from '../utils/generateErrorMessage.js';
import CreditCardValidator from '../validators/CreditCardValidator.js';

export default function handleCheckOutForm(event) {
  const errors = [];

  const {
    creditCardNumber,
    creditCardExpirationDate,
    creditCardCode,
  } = event.target;

  const inputs = document.querySelectorAll('form[name=form-checkout] input');
  const hasEmptyFields = Array.prototype.some.call(
    inputs,
    (input) => input.value.length === 0
  );

  if (hasEmptyFields) {
    errors.push('Preencha todos os campos.');
  }

  const isAnInvalidCreditCardNumber = !(
    CreditCardValidator.validateCreditCardNumber(creditCardNumber.value)
  );
  if (isAnInvalidCreditCardNumber) {
    errors.push('Número do cartão de crédito inválido.');
  }

  const isAnInvalidCreditCardExpirationDate = !(
    CreditCardValidator.validateCreditCardExpirationDate(creditCardExpirationDate.value)
  );
  if (isAnInvalidCreditCardExpirationDate) {
    errors.push('Data de expiração do cartão de crédito inválido.');
  }

  const isAnInvalidCreditCardCode = !(
    CreditCardValidator.validateCreditCardCode(creditCardCode.value)
  );
  if (isAnInvalidCreditCardCode) {
    errors.push('Código do cartão de crédito inválido.');
  }

  if (errors.length > 0) {
    generateErrorMessage(errors[0]);
    event.preventDefault();
  }
}
