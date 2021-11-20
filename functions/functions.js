var topCartInfoCount = document.getElementById('top_product_summary_count');
var topCartInfoTotal = document.getElementById('top_product_summary_total');
var sideCartInfoCount = document.getElementById('side_product_summary_count');
var sideCartInfoTotal = document.getElementById('side_product_summary_total');
var productTable = document.querySelector('#product_table tbody');

topCartInfoCount.innerHTML = getProductCount();
topCartInfoTotal.innerHTML = getTotalPrice();
sideCartInfoCount.innerHTML = getProductCount();
sideCartInfoTotal.innerHTML = getTotalPrice();

function getProductData(title, price, id, quantity) {
    // create a small array to hold the product info
    const productInfo = {
        title: title,
        price: price,
        quantity: quantity,
        id: id
    }

    // add the product info array to the others previously created
    insertProductIntoLocalStorage(productInfo);
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
    console.log('succesful');
    console.log(localStorage.getItem('products'));
    setFrontendItems();
    window.alert('Product has been added to cart');
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

function deleteItemInLocalStorage(productId) {
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
}

function getTotalPrice() {
    var total = 0;
    let productsLS = getProductsInLocalStorage();
    for (var i = 0; i < productsLS.length; i++) {
        total += productsLS[i]['price'];
    }
    //console.log(productsLS[0]['price']);
    //console.log(total);
    return total;
}

function getProductCount() {
    let productsLS = getProductsInLocalStorage();
    console.log(productsLS.length);
    //console.log(total);
    return productsLS.length;
}

function setFrontendItems() {
    topCartInfoCount.innerHTML = getProductCount();
    topCartInfoTotal.innerHTML = getTotalPrice();
    sideCartInfoCount.innerHTML = getProductCount();
    sideCartInfoTotal.innerHTML = getTotalPrice();
}

function loadCartSummary() {
    let productsLS = getProductsInLocalStorage();

    for (var i = 0; i < productsLS.length; i++) {
        // total += productsLS[i]['price'];
        var item_total = (productls[i].quantity) * ((productls[i].price) - (productls[i].discount));
        const row = document.createElement('tr');
        row.innerHTML = `
    <td>${productsLS[i].image}</td>
      <td>${productsLS[i].title}</td>

      <td>
      <div class="input-append"><input class="span1" style="max-width:34px" placeholder="${productls[i].quantity}" id="appendedInputButtons" size="16" type="text">
      <button class="btn" type="button" onclick="reduceQuantity(${productLS[i].id});"><i class="icon-minus"></i></button>
      <button class="btn" type="button" onclick="increaseQuantity(${productLS[i].id});"><i class="icon-plus"></i></button>
      <button class="btn btn-danger" type="button" onclick="removeProduct(${productLS[i].id});"><i class="icon-remove icon-white"></i></button> 
      </div>
  </td>

      <td>${productLS[i].price}</td>
      <td>${productls[i].discount}</td>
      <td>${productls[i].tax}</td>
      <td>${productls[i].total}</td>
      
      <td>
      <a href="#" class="borrar-curso" data-id="${curso.id}">X</a>
      </td>
      `;
    }

}

function clearProductTable(){
    
        // forma lenta
        // listaCursos.innerHTML = '';
        // forma rapida (recomendada)
        while(productTable.firstChild) {
          productTable.removeChild(productTable.firstChild);
        }
      
        // Vaciar Local Storage
        console.log('sucessfully cleared')
        clearLocalStorage();
        setFrontendItems();
        return false;
}