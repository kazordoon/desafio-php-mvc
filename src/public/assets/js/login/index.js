import handleLoginForm from './handleLoginForm.js';

(function () {
  const form = document.forms['form-login'];

  form.addEventListener('submit', handleLoginForm);
})();
