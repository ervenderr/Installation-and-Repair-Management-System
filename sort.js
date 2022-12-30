function sort() {
  // Get the selected option value
  var sortOption = document.getElementById("sort-select").value;

  // Get all the product elements
  var productElements = document.getElementsByClassName("product");
  var products = [];

  // Convert the product elements to an array
  for (var i = 0; i < productElements.length; i++) {
    products.push(productElements[i]);
  }

  // Sort the array based on the selected option
  if (sortOption == "price-asc") {
    products.sort(function (a, b) {
      var priceA = parseFloat(
        a.getElementsByClassName("product-price")[0].innerHTML.slice(1)
      );
      var priceB = parseFloat(
        b.getElementsByClassName("product-price")[0].innerHTML.slice(1)
      );
      return priceA - priceB;
    });
  } else if (sortOption == "price-desc") {
    products.sort(function (a, b) {
      var priceA = parseFloat(
        a.getElementsByClassName("product-price")[0].innerHTML.slice(1)
      );
      var priceB = parseFloat(
        b.getElementsByClassName("product-price")[0].innerHTML.slice(1)
      );
      return priceB - priceA;
    });
  } else if (sortOption == "name-asc") {
    products.sort(function (a, b) {
      var nameA = a.getElementsByTagName("h2")[0].innerHTML.toLowerCase();
      var nameB = b.getElementsByTagName("h2")[0].innerHTML.toLowerCase();
      if (nameA < nameB) {
        return -1;
      }
      if (nameA > nameB) {
        return 1;
      }
      return 0;
    });
  } else if (sortOption == "name-desc") {
    products.sort(function (a, b) {
      var nameA = a.getElementsByTagName("h2")[0].innerHTML.toLowerCase();
      var nameB = b.getElementsByTagName("h2")[0].innerHTML.toLowerCase();
      if (nameA > nameB) {
        return -1;
      }
      if (nameA < nameB) {
        return 1;
      }
      return 0;
    });
  }

  // Get the parent element that contains the products
  var parent = document.getElementsByClassName("row")[0];

  // Remove all the products from the page
  for (var i = 0; i < products.length; i++) {
    products[i].parentNode.removeChild(products[i]);
  }

  // Add the sorted products back to the page
  for (var i = 0; i < products.length; i++) {
    document.getElementsByClassName("row")[0].appendChild(products[i]);
  }
}
