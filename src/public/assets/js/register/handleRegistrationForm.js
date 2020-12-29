import generateErrorMessage from '../utils/generateErrorMessage.js';
import UserValidator from '../validators/UserValidator.js';

export default function handleRegistrationForm(event) {
  const errors = [];

  const inputs = document.querySelectorAll('form[name=form-register] input');
  const hasEmptyFields = Array.prototype.some.call(
    inputs,
    (input) => input.value.length === 0
  );

  if (hasEmptyFields) {
    errors.push('Preencha todos os campos.');
  }

  const email = document.querySelector('#email').value;
  const password = document.querySelector('#password').value;
  const repeatedPassword = document.querySelector('#repeatedPassword').value;

  const isAnInvalidEmail = !UserValidator.isAValidEmail(email);
  if (isAnInvalidEmail) {
    errors.push('O e-mail fornecido possui um formato inválido.');
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
