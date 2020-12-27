import generateErrorMessage from './utils/generateErrorMessage.js';
import UserValidator from './validators/UserValidator.js';

(function () {
  const form = document.forms['form-password'];

  form.addEventListener('submit', function (event) {
    const errors = [];

    const newPassword = document.querySelector('#newPassword').value;
    const newRepeatedPassword = document.querySelector('#repeatedPassword').value;

    const inputs = document.querySelectorAll('form[name=form-password] input');
    const hasEmptyFields = Array.prototype.some.call(
      inputs,
      (input) => input.value.length === 0
    );

    if (hasEmptyFields) {
      errors.push('Preencha todos os campos.');
    }

    const hasAnInvalidPasswordLength = !UserValidator.hasAValidPasswordLength(
      newPassword
    );
    if (hasAnInvalidPasswordLength) {
      errors.push('A senha deve possuir entre 8 e 50 carácteres.');
    }

    const passwordsAreDifferent = newPassword !== newRepeatedPassword;
    if (passwordsAreDifferent) {
      errors.push('As senhas não coincidem.');
    }   

    if (errors.length > 0) {
      generateErrorMessage(errors[0]);
      event.preventDefault();
    }
  });
})();
