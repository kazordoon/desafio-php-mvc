import handlePasswordForm from './handlePasswordForm.js';

(function () {
  const form = document.forms['form-password'];

  form.addEventListener('submit', handlePasswordForm);
})();
