import generateErrorMessage from '../utils/generateErrorMessage.js';
import UserValidator from '../validators/UserValidator.js';

export default function handlePasswordResetForm(event) {
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

  const hasAnInvalidPasswordLength = !UserValidator.hasAValidPasswordLength(
    password
  );
  if (hasAnInvalidPasswordLength) {
    errors.push('A senha deve possuir entre 8 e 50 carácteres.');
  }

  const passwordsAreDifferent = password !== repeatedPassword;
  if (passwordsAreDifferent) {
    errors.push('As senhas não coincidem.');
  }

  if (errors.length > 0) {
    generateErrorMessage(errors[0]);
    event.preventDefault();
  }
}
