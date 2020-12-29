import handlePasswordResetForm from './handlePasswordResetForm.js';

(function () {
  const form = document.forms['form-reset-password'];

  form.addEventListener('submit', handlePasswordResetForm);
})();
