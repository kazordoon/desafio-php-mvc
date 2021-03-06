import generateErrorMessage from '../utils/generateErrorMessage.js';
import UserValidator from '../validators/UserValidator.js';

export default function handleNameForm (event) {
  const errors = [];

  const name = document.querySelector('#name').value;

  if (!name) {
    errors.push('Preencha o campo do nome.');
  }

  const hasAnInvalidNameLength = !UserValidator.hasAValidNameLength(name);
  if (hasAnInvalidNameLength) {
    errors.push('Nome muito comprido, utilize apenas nome e sobrenome.');
  }

  if (errors.length > 0) {
    generateErrorMessage(errors[0]);
    event.preventDefault();
  }
}
