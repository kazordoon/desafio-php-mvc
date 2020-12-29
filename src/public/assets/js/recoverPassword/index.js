import handlePasswordRecoveryForm from './handlePasswordRecoveryForm.js';

(function () {
  const form = document.forms['form-recover-password'];

  form.addEventListener('submit', handlePasswordRecoveryForm);
})();
