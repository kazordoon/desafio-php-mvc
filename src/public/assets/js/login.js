import generateErrorMessage from './utils/generateErrorMessage.js';

(function () {
  const form = document.forms['form-login'];

  form.addEventListener('submit', function (event) {
    const email = document.querySelector('#email').value;
    const password = document.querySelector('#password').value;

    if (!email || !password) {
      generateErrorMessage('Preencha todos os campos.');
      event.preventDefault();
    }
  });
})();
