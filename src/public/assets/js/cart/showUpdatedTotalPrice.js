import formatPrice from '../utils/formatPrice.js';
import getTotalPrice from './getTotalPrice.js';

export default function showUpdatedTotalPrice() {
  const totalPriceElement = document.querySelector('#total-price');

  const formattedTotalPrice = formatPrice(getTotalPrice());
  totalPriceElement.textContent = formattedTotalPrice;
}
