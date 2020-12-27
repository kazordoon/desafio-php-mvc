class UserValidator {
  /**
   * @param {string} email
   */
  static isAValidEmail(email) {
    const emailRegexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return emailRegexp.test(email);
  }

  /**
   * @param {string} password1
   * @param {string} password2
   */
  static areThePasswordsTheSame(password1, password2) {
    return password1 === password2;
  }

  /**
   * @param {string} password
   */
  static hasAValidPasswordLength(password) {
    const minLength = 8;
    const maxLength = 50;
    return password.length >= minLength && password.length <= maxLength;
  }
}

export default UserValidator;
