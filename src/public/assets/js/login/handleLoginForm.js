import generateErrorMessage from '../utils/generateErrorMessage.js';

export default function handleLoginForm(event) {
  const email = document.querySelector('#email').value;
  const password = document.querySelector('#password').value;

  if (!email || !password) {
    generateErrorMessage('Preencha todos os campos.');
    event.preventDefault();
  }
}
