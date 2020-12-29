import onlyNumbers from './onlyNumbers.js';

export default function formatExpirationDate(value) {
  return onlyNumbers(value)
    .replace(/(\d{2})(\d)/, '$1/$2')
    .replace(/(\/\d{2})\d+?$/, '$1');
}
