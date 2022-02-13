// const formater = new Intl.NumberFormat('en-NG', {
//     style: 'currency',
//     currency: 'NGN',
//     maximumFractionDigits: 0,
// })

// function nairaFormat(number) {
//     console.log('inside nairaFormat function')
//     //document.write('₦'.number)
//     if (formater.format(number) != null) {
//         document.write(formater.format(number));
//     } else {
//         document.write(number);
//     }
//     //return '₦'.formater.format(number);
// }

// function nairaFormatR(number) {
//     console.log('inside nairaFormatR function')
//     //document.write(formater.format(number));
//     //return '₦'.number;
//     if (formater.format(number) != null) {
//         return formater.format(number);
//     } else {
//         return '₦'.number;
//     }
// }

var topCartInfoCount = document.getElementById('top_product_summary_count');
var topCartInfoTotal = document.getElementById('top_product_summary_total');
var sideCartInfoCount = document.getElementById('side_product_summary_count');
var midCartInfoCount = document.getElementById('mid_product_summary_count');
var sideCartInfoTotal = document.getElementById('side_product_summary_total');

var productTable = document.querySelector('#product_table tbody');

topCartInfoCount.innerHTML = getProductCount();
topCartInfoTotal.innerHTML = nairaFormatR(getTotalPrice());
sideCartInfoCount.innerHTML = getProductCount();
sideCartInfoTotal.innerHTML = nairaFormatR(getTotalPrice());
var cartToggleButton;


loadCartSummary();
showItemsAlreadyInCart(getProductsInLocalStorage());

function getProductData(image, discount, title, price, id, quantity, tax) {

    // create a small array to hold the product info
    const productInfo = {
        image: image,
        discount: discount,
        title: title,
        price: price,
        quantity: quantity,
        id: id,
        tax: tax
    }

    // add the product info array to the others previously created
    if (!validateProductId(id)) {
        insertProductIntoLocalStorage(productInfo);

    } else {
        window.alert('Product is already in cart. If you want to increase the quantity, go to the cart page.');
        //console.log('working');
        showItemsAlreadyInCart(getProductsInLocalStorage());
    }
}

function validateProductId(productId) {
    var found = false;
    let productsLS;
    // get all the products in localstorage
    productsLS = getProductsInLocalStorage();
    // this following loop simply scans through the products list and checks if any of the items are equal to the id passed into the function
    productsLS.forEach(function (productLS, index) {
        if (productLS.id === productId) {
            found = true;
        }
    });
    return found;
}

function insertProductIntoLocalStorage(product) {
    let mainProducts;

    // get all the items inside the local storage and set it to mainProducts
    mainProducts = getProductsInLocalStorage();

    //     const row = document.createElement('tr');
    //   row.innerHTML = `
    //   <td>${product.title}</td>
    //   <td>${product.price}</td>
    //   <td>${product.quantity}</td>
    //   <td>
    //   <a href="#" class="borrar-curso" data-id="${curso.id}">X</a>
    //   </td>
    //   `;

    // then add the newly clicked product into the mainProducts storage
    mainProducts.push(product);
    localStorage.setItem('products', JSON.stringify(mainProducts));
    //console.log('succesful');
    //console.log(localStorage.getItem('products'));
    //showItemsAlreadyInCart(getProductsInLocalStorage());
    setFrontendItems();
    // window.alert('Product has been added to cart');
}

function getProductsInLocalStorage() {
    let productsLS;
    if (localStorage.getItem('products') === null) {
        productsLS = [];
    } else {
        // sets the items inside the localStorage to productsLS array
        productsLS = JSON.parse(localStorage.getItem('products'));
    }
    return productsLS;
}

function clearLocalStorage() {
    localStorage.clear();
}

function deleteCartItem(productId) {
    let productsLS;
    // get all the products in localstorage
    productsLS = getProductsInLocalStorage();
    // this following loop simply scans through the products list and checks if any of the items are equal to the id passed into the function
    productsLS.forEach(function (productLS, index) {
        if (productLS.id === productId) {
            productsLS.splice(index, 1);
        }
    });
    // after everything, add the products back to local storage
    localStorage.setItem('products', JSON.stringify(productsLS));
    loadCartSummary();
    setFrontendItems();
}

function getTotalPrice() {
    var total = 0;
    let productsLS = getProductsInLocalStorage();
    for (var i = 0; i < productsLS.length; i++) {
        total += (productsLS[i].quantity * productsLS[i].price);
    }
    //console.log(productsLS[0]['price']);
    //console.log(total);
    return total;
}

function getProductCount() {
    let productsLS = getProductsInLocalStorage();
    //console.log(total);
    return productsLS.length;
}

function setFrontendItems() {
    if (topCartInfoCount != null) {
        topCartInfoCount.innerHTML = getProductCount();
    }

    if (topCartInfoTotal != null) {
        topCartInfoTotal.innerHTML = nairaFormatR(getTotalPrice());
    }

    if (midCartInfoCount != null) {
        midCartInfoCount.innerHTML = getProductCount();
    }

    if (sideCartInfoCount != null) {
        sideCartInfoCount.innerHTML = getProductCount();
    }

    if (sideCartInfoTotal != null) {
        sideCartInfoTotal.innerHTML = nairaFormatR(getTotalPrice());
    }
    
    showItemsAlreadyInCart(getProductsInLocalStorage());
}

function loadCartSummary() {
    var totalVal = 0;
    var totalDiscountVal = 0;
    var totalTaxVal = 0;
    var grossTotalVal = 0;

    var tax = 0;
    var discount = 0;

    clearProductTable();
    let productLS = getProductsInLocalStorage();

    for (var i = 0; i < productLS.length; i++) {
        // total += productLS[i]['price'];
        discount = productLS[i].discount * productLS[i].quantity
        tax = productLS[i].tax * productLS[i].quantity;
        var itemTotal = (productLS[i].quantity * productLS[i].price) + tax - discount;

        var row = document.createElement('tr');
        row.innerHTML = `
    <td> <img width="60" src="product_images/${productLS[i].image}" alt="" /></td>

      <td>${productLS[i].title}</td>

      <td>
      <div class="input-append"><input class="span1" style="max-width:34px" disabled placeholder="${productLS[i].quantity}" id="appendedInputButtons" size="16" type="text">
      <button class="btn" type="button" onclick="reduceQuantity(${productLS[i].id});"><i class="icon-minus"></i></button>
      <button class="btn" type="button" onclick="increaseQuantity(${productLS[i].id});"><i class="icon-plus"></i></button>
      <button class="btn btn-danger" type="button" onclick="deleteCartItem(${productLS[i].id});"><i class="icon-remove icon-white"></i></button> 
      </div>
  </td>

      <td>${nairaFormatR(productLS[i].price)}</td>
      <td>${nairaFormatR(discount)}</td>
      <td>${nairaFormatR(tax)}</td>
      <td>${nairaFormatR(itemTotal)}</td>
      `;
        if (productTable != null) {
            productTable.appendChild(row);
        }

        totalVal += productLS[i].price * productLS[i].quantity;
        totalDiscountVal += discount;
        totalTaxVal += tax;

    }
    grossTotalVal = totalVal - totalDiscountVal + totalTaxVal;

    var totalRow = document.createElement('tr');
    var totalDiscountRow = document.createElement('tr');
    var totalTaxRow = document.createElement('tr');
    var grossTotalRow = document.createElement('tr');

    totalRow.innerHTML = `<td colspan = "6" style = "text-align:right"> Total Price: </td><td> ${nairaFormatR(totalVal)}</td> `;
    totalDiscountRow.innerHTML = `<td colspan="6" style="text-align:right">Total Discount: </td><td> ${nairaFormatR(totalDiscountVal)}</td>`;
    totalTaxRow.innerHTML = `<td colspan="6" style="text-align:right">Total Tax: </td><td> ${nairaFormatR(totalTaxVal)}</td>`;
    grossTotalRow.innerHTML = `<td colspan="6" style="text-align:right"><strong>TOTAL (${nairaFormatR(totalVal)} - ${nairaFormatR(totalDiscountVal)} + ${nairaFormatR(totalTaxVal)}) =</strong></td><td class="label label-important" style="display:block"> <strong> ${nairaFormatR(grossTotalVal)} </strong></td>`;

    if (productTable != null) {
        productTable.appendChild(totalRow);
        productTable.appendChild(totalDiscountRow);
        productTable.appendChild(totalTaxRow);
        productTable.appendChild(grossTotalRow);
    }
}

function clearProductTable() {

    // forma lenta
    // listaCursos.innerHTML = '';
    // forma rapida (recomendada)
    if (productTable != null) {


        while (productTable.firstChild) {
            productTable.removeChild(productTable.firstChild);
        }
    }
}

function deleteAllCartItems() {

    clearProductTable();

    // Vaciar Local Storage
    console.log('sucessfully cleared')
    clearLocalStorage();
    setFrontendItems();
    return false;
}

function reduceQuantity(productId) {
    let productsLS;
    // get all the products in localstorage
    productsLS = getProductsInLocalStorage();
    // this following loop simply scans through the products list and checks if any of the items are equal to the id passed into the function
    productsLS.forEach(function (productLS, index) {
        if (productLS.id === productId) {
            if (productLS.quantity > 1) {
                productLS.quantity--;

            }
        }
    });
    // after everything, add the products back to local storage
    localStorage.setItem('products', JSON.stringify(productsLS));
    loadCartSummary();
    setFrontendItems();
}

function increaseQuantity(productId) {
    let productsLS;
    // get all the products in localstorage
    productsLS = getProductsInLocalStorage();
    // this following loop simply scans through the products list and checks if any of the items are equal to the id passed into the function
    productsLS.forEach(function (productLS, index) {
        if (productLS.id === productId) {
            productLS.quantity++;
        }
    });
    // after everything, add the products back to local storage
    localStorage.setItem('products', JSON.stringify(productsLS));

    loadCartSummary();
    setFrontendItems();

}

function getGrossTotalPrice() {
    var totalVal = 0;
    var totalDiscountVal = 0;
    var totalTaxVal = 0;
    var grossTotalVal = 0;

    var tax = 0;
    var discount = 0;

    let productLS = getProductsInLocalStorage();

    for (var i = 0; i < productLS.length; i++) {
        // total += productLS[i]['price'];
        discount = productLS[i].discount * productLS[i].quantity
        tax = productLS[i].tax * productLS[i].quantity;
        var itemTotal = (productLS[i].quantity * productLS[i].price) + tax - discount;

        totalVal += productLS[i].price * productLS[i].quantity;
        totalDiscountVal += discount;
        totalTaxVal += tax;

    }
    grossTotalVal = totalVal - totalDiscountVal + totalTaxVal;
    return grossTotalVal;
}

function showItemsAlreadyInCart(productLS) {
    console.log('test 1 passed');
    //let productLS = getProductsInLocalStorage();

    //console.log(productLS.length);
    //console.log(productLS[0].title);

    for (var i = 0; i < productLS.length; i++) {
        console.log('test 2 passed')
        // total += productLS[i]['price'];
        productInCart = productLS[i].id;
        productInCart = productInCart.toString();
        //console.log(productInCart);
        cartToggleButtonId = 'cartToggleButton' + productInCart;
        console.log(cartToggleButtonId);
        cartToggleButton = document.getElementById(cartToggleButtonId);
        console.log(cartToggleButton);

        if (cartToggleButton != null) {
            console.log('button found.');
            cartToggleButton.style.display = 'none';

        }

        //console.log('cartToggleButton' + productInCart);
        // if(cartToggleButton.style.display == 'none'){
        //     console.log('button hidden.')
        // console.log('test 3 passed.')
        // }else{
        //     console.log('button not succesfully hidden.')
        //     console.log('test 3 failed.')
        // }
        console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>')
    }
}

function getJsonFromObject(productsObject) {
    return JSON.stringify(productsObject);
}

// const formater = new Intl.NumberFormat('en-NG',
//     {
//         style: 'currency',
//         currency: 'NGN',
//         maximumFractionDigits: 0,
//     })

// function nairaFormat(number) {
//     console.log('inside nairaFormat function')
//     document.write(formater.format(number));
//     //return 
// }


var number = 1000000;
console.log('about to use formatter');
console.log(formater.format(number));
