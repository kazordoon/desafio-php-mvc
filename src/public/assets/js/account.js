(function () {
  const nameChangeLink = document.querySelector('#change-name');
  const emailChangeLink = document.querySelector('#change-email');
  const passwordChangeLink = document.querySelector('#change-password');

  function changeName() {
    const name = document.querySelector('#name');

    name.removeAttribute('readonly');
    name.focus();
  }

  function changeEmail() {
    const email = document.querySelector('#email');
  }

  function changePassword() {
    const password = document.querySelector('#password');
  }

  nameChangeLink.addEventListener('click', changeName);
  emailChangeLink.addEventListener('click', changeEmail);
  passwordChangeLink.addEventListener('click', changePassword);
})();