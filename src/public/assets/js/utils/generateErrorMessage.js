export default function generateErrorMessage(errorMessage) {
  let divError = document.querySelector("div.alert-danger");
  if (divError) {
    divError.remove();
  }

  divError = document.createElement("div");
  divError.classList.add("alert");
  divError.classList.add("alert-danger");

  const pError = document.createElement("p");
  const textError = document.createTextNode(errorMessage);
  pError.appendChild(textError);
  divError.appendChild(pError);

  document.body.prepend(divError);
}
