import handleEmailForm from './handleEmailForm.js';

(function () {
  const form = document.forms['form-email'];

  form.addEventListener('submit', handleEmailForm);
})();
