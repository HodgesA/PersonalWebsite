const cart = [];

function addToCart(name, price, quantity) {
  for (let i = 0; i < cart.length; i++) {
    if (cart[i].name === name) {
      cart[i].quantity += quantity;
      return;
    }
  }
  const item = { name, price, quantity };
  cart.push(item);
}

function renderCart() {
  const cartList = document.querySelector(".cart");
  cartList.innerHTML = "";
  let total = 0;
  for (let i = 0; i < cart.length; i++) {
    const item = cart[i];
    const li = document.createElement("li");
    li.textContent = `${item.name} quantity ${item.quantity} - $${item.price.toFixed(2)}`;
    cartList.appendChild(li);
    total += item.price * item.quantity;
  }
  const totalElement = document.querySelector(".total");
  totalElement.textContent = `total: $${total.toFixed(2)}`;
}

const addToCartButtons = document.querySelectorAll(".item_add");
for (let i = 0; i < addToCartButtons.length; i++) {
  const button = addToCartButtons[i];
  button.addEventListener("click", function() {
    const name = button.dataset.name;
    const price = parseFloat(button.dataset.price);
    const qty = parseInt(document.querySelector(`#${button.parentElement.querySelector('input[type="number"]').id}`).value);
    addToCart(name, price, qty);
    renderCart();
  });
}

const resetCartButton = document.querySelector(".reset");
resetCartButton.addEventListener("click", function() {
  cart.length = 0;
  renderCart();
});

const purchaseCartButton = document.querySelector(".purchase");
purchaseCartButton.addEventListener("click", function() {
  if (cart.length === 0) {
    alert("your cart is empty");
    return;
  }
  alert("thank you for your purchase");
  cart.length = 0;
  renderCart();
});