import handleRegistrationForm from './handleRegistrationForm.js';

(function () {
  const form = document.forms['form-register'];

  form.addEventListener('submit', handleRegistrationForm);
})();
