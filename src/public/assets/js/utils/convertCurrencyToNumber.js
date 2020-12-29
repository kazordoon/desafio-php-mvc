export default function convertCurrencyToNumber(currency) {
  const numbers = currency.replace('R$', '').replace(/,/g, '.').split('.');
  const decimal = numbers[numbers.length - 1];
  const integer = numbers.slice(0, numbers.length - 1).join('');

  const value = parseFloat(`${integer}.${decimal}`);
  return value;
}
