import handleNameForm from './handleNameForm.js';

(function () {
  const form = document.forms['form-name'];

  form.addEventListener('submit', handleNameForm);
})();
