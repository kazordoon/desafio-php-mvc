import generateErrorMessage from './utils/generateErrorMessage.js';
import UserValidator from './validators/UserValidator.js';

(function () {
  const form = document.forms['form-email'];

  form.addEventListener('submit', function (event) {
    const errors = [];

    const email = document.querySelector('#email').value;

    if (!email) {
      errors.push('Preencha o campo de email.');
    }

    const isAnInvalidEmail = !UserValidator.isAValidEmail(email);
    if (isAnInvalidEmail) {
      errors.push('O e-mail fornecido possui um formato inválido.');
    }    

    if (errors.length > 0) {
      generateErrorMessage(errors[0]);
      event.preventDefault();
    }
  });
})();
