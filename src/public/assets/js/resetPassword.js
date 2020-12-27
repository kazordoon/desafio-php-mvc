import generateErrorMessage from './utils/generateErrorMessage.js';
import UserValidator from './validators/UserValidator.js';

(function () {
  const form = document.forms['form-reset-password'];

  form.addEventListener('submit', function (event) {
    const errors = [];

    const password = document.querySelector('#password').value;
    const repeatedPassword = document.querySelector('#repeatedPassword').value;

    const inputs = document.querySelectorAll(
      'form[name=form-reset-password] input'
    );
    const hasEmptyFields = Array.prototype.some.call(
      inputs,
      (input) => input.value.length === 0
    );

    if (hasEmptyFields) {
      errors.push('Preencha todos os campos.');
    }

    const passwordsAreDifferent = !UserValidator.areThePasswordsTheSame(
      password,
      repeatedPassword
    );
    if (passwordsAreDifferent) {
      errors.push('As senhas não coincidem.');
    }

    if (errors.length > 0) {
      generateErrorMessage(errors[0]);
      event.preventDefault();
    }
  });
})();
