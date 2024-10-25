

function textFill(elem) {
  const parent = elem.parentElement;
  const parentStyles = window.getComputedStyle(parent);
  const parentWidth = parseFloat(parentStyles.width);
  const fontSizeInEm = parentWidth / 53; // Assuming the base font size is 53px
  elem.style.fontSize = `${fontSizeInEm}em`;
}

document.addEventListener('DOMContentLoaded', () => {
  const elem = document.querySelector('.b1 div p');
  if (elem) {
    textFill(elem);
  }
});