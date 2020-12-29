export default class CreditCardValidator {
  static validateCreditCardNumber(creditCardNumber) {
    const numberRegex = /^\d+$/;
    return numberRegex.test(creditCardNumber);
  }

  static validateCreditCardExpirationDate(creditCardExpirationDate) {
    const expirationDateRegex = /^\d{2}\/\d{2}$/;
    return expirationDateRegex.test(creditCardExpirationDate);
  }

  static validateCreditCardCode(creditCardCode) {
    const codeRegex = /^\d{3}$/;
    return codeRegex.test(creditCardCode);
  }
}
