import convertCurrencyToNumber from '../utils/convertCurrencyToNumber.js';
import formatPrice from '../utils/formatPrice.js';

export default function decreaseTotalPrice(amount) {
  const totalPriceElement = document.querySelector('#total-price');
  const totalPrice = totalPriceElement.textContent;

  let numericTotalPrice = convertCurrencyToNumber(totalPrice);
  numericTotalPrice -= amount;

  const formattedTotalPrice = formatPrice(numericTotalPrice);

  totalPriceElement.textContent = formattedTotalPrice;
}
