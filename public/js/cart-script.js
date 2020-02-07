var shoppingCart = (function () {

  cart = [];

  // Constructor
  function Item(id, name, date, price) {
    this.id = id;
    this.name = name;
    this.date = date;
    this.price = price;
  }
  function saveCart() {
    sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
  }

  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
  }
  if (sessionStorage.getItem("shoppingCart") != null) {
    loadCart();
  }



  var obj = {};

  // Add to cart
  obj.addItemToCart = function (id, name, date, price) {
    for (var item in cart) {
      if (cart[item].name === name) {
        var mymodal = $('#modalAlertDanger');
        mymodal.find('.body').text("L'item a déjà été rajouté au panier");
        mymodal.modal('show');

        saveCart();
        return;
      }
    }
    var item = new Item(id, name, date, price);
    cart.push(item);

    var mymodal = $('#modalAlertSuccess');
    mymodal.find('.body').text('Item rajouté au panier');
    mymodal.modal('show');
    saveCart();
  };

  // Remove item from cart
  obj.removeItemFromCart = function (name) {
    for (var item in cart) {
      if (cart[item].name === name) {
        cart.splice(item, 1);
      }
      break;
    }

    saveCart();
  };

  // Clear cart
  obj.clearCart = function () {
    cart = [];
    saveCart();
  };

  // Count cart
  obj.totalCount = function () {
    var totalCount = 0;
    for (var item in cart) {
      totalCount += 1;
    }
    return totalCount;
  };

  // Remove all items from cart
  obj.removeItemFromCartAll = function (name) {
    for (var item in cart) {
      if (cart[item].name === name) {
        cart.splice(item, 1);
        break;
      }
    }
    saveCart();
  };


  // Total cart
  obj.totalCart = function () {
    var totalCart = 0;
    for (var item in cart) {
      if (cart[item].price != '') {
        totalCart += Number(cart[item].price);
      }
    }
    return Number(totalCart.toFixed(2));
  };

  // List cart
  obj.listCart = function () {
    var cartCopy = [];
    for (i in cart) {
      item = cart[i];
      itemCopy = {};
      for (p in item) {
        itemCopy[p] = item[p];
      }
      itemCopy.total = 12;
      cartCopy.push(itemCopy)
    }
    return cartCopy;
  };

  return obj;
})();


// *****************************************
// Triggers / Events
// *****************************************


// Add item
function setOnclick() {
  setTimeout(function() {
    $('.add-to-cart').click(function (event) {
      event.preventDefault();
      var id = $(this).data('id');
      var date = $(this).data('date');
      var name = $(this).data('name');
      var price = $(this).data('price');
      shoppingCart.addItemToCart(id, name, date, price);
      displayCart();
    });
  }, 1000);
}

setOnclick();



// Clear items
$('.clear-cart').click(function () {
  shoppingCart.clearCart();
  displayCart();
});


function displayCart() {
  var cartArray = shoppingCart.listCart();
  $('.show-cart').html('')
  for (var i in cartArray) {
    let url = new URL(window.location.origin + '/cartrow')
    url.searchParams.set('id', cartArray[i].id)
    url.searchParams.set('name', cartArray[i].name)
    url.searchParams.set('date', cartArray[i].date)
    url.searchParams.set('price', cartArray[i].price)
    $.ajax({
      url: url.href,
      method: 'GET',
      success: (data) => {
        $('.show-cart').append(data)
      }
    })
  }
  $('.total-cart').html(shoppingCart.totalCart());
  $('.total-count').html(shoppingCart.totalCount());
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function (event) {
  var name = $(this).data('name');
  shoppingCart.removeItemFromCartAll(name);
  displayCart();
})

displayCart();
