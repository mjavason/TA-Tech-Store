


var topCartInfoCount = document.getElementById('top_product_summary_count');

var jsonCategories = document.getElementById('productcategoryjson');
var jsonColors = document.getElementById('productcolorjson');
var jsonSpecs = document.getElementById('productspecjson');

clearLocalStorage();
clearProductTable();

loadProductInfoTable('spec');
loadProductInfoTable('category');
loadProductInfoTable('color');
//clearLocalStorage();

// CREATE
function createProductData(titleinputid, valueinputid, productInfo) {
    // create a small array to hold the product info

    var addSpecInput = document.getElementById(titleinputid);
    var addSpecInput2 = document.getElementById(valueinputid);

    var vaddSpecInput = document.getElementById(titleinputid);
    var vaddSpecInput2 = document.getElementById(valueinputid);

    addSpecInput = addSpecInput.value.toUpperCase().trim();

    if (productInfo == "spec") {
        addSpecInput2 = addSpecInput2.value.toUpperCase().trim();
    } else {
        addSpecInput2 = "-"
    }


    const SpecInfo = {
        title: addSpecInput,
        value: addSpecInput2
    }



    // add the product info array to the others previously created
    if (!validateProductId(addSpecInput, productInfo)) {

        if (addSpecInput == "" || addSpecInput2 == "") {
            window.alert('text field empty');
        } else {
            insertProductIntoLocalStorage(SpecInfo, productInfo);
            vaddSpecInput.value = "";
            if (vaddSpecInput2 != null) {
                vaddSpecInput2.value = "";
            }
        }

    } else {
        window.alert(addSpecInput + ' already added bro, delete last one to update');
    }
    console.log(getProductsInLocalStorage(productInfo));
    loadProductInfoTable(productInfo);

}

function validateProductId(titlename, prodInfo) {
    var found = false;
    let productsLS;
    // get all the products in localstorage
    productsLS = getProductsInLocalStorage(prodInfo);
    // this following loop simply scans through the products list and checks if any of the items are equal to the id passed into the function
    productsLS.forEach(function (productLS, index) {
        if (productLS.title === titlename) {
            found = true;
        }
    });

    return found;
}

function insertProductIntoLocalStorage(product, prodInfo) {
    let mainProducts;

    // get all the items inside the local storage and set it to mainProducts
    mainProducts = getProductsInLocalStorage(prodInfo);

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
    switch (prodInfo) {
        case 'spec':

            localStorage.setItem('specifications', JSON.stringify(mainProducts));
            console.log('succesfully added to local storage');
            //console.log(localStorage.getItem('specifications'));
            break;

        case 'color':
            localStorage.setItem('colors', JSON.stringify(mainProducts));
            console.log('succesfully added to local storage');
            //console.log(localStorage.getItem('colors'));
            break;

        case 'category':
            localStorage.setItem('categories', JSON.stringify(mainProducts));
            console.log('succesfully added to local storage');
            // console.log(localStorage.getItem('categories'));
            break;

        // default:
        //     console.log('storage to be gotten not specified.');

    }

    //setFrontendItems();
    // window.alert(mainProducts);
}


// READ
function getProductsInLocalStorage(productInfo) {
    let productsLS;

    switch (productInfo) {
        case 'spec':
            if (localStorage.getItem('specifications') === null) {
                productsLS = [];
            } else {
                // sets the items inside the localStorage to productsLS array
                productsLS = JSON.parse(localStorage.getItem('specifications'));
            }
            break;


        case 'color':
            if (localStorage.getItem('colors') === null) {
                productsLS = [];
            } else {
                // sets the items inside the localStorage to productsLS array
                productsLS = JSON.parse(localStorage.getItem('colors'));
            }
            break;


        case 'category':
            if (localStorage.getItem('categories') === null) {
                productsLS = [];
            } else {
                // sets the items inside the localStorage to productsLS array
                productsLS = JSON.parse(localStorage.getItem('categories'));
            }
            break;

        //default: productsLS = [];
    }

    return productsLS;

}

function loadProductInfoTable(prodInfo) {

    switch (prodInfo) {
        case 'spec':
            var productTable = document.querySelector('#spectable tbody');
            break;

        case 'color':
            var productTable = document.querySelector('#colortable tbody');
            break;

        case 'category':
            var productTable = document.querySelector('#categorytable tbody');
            break;

        // default:
        //     console.log('storage to be gotten not specified.');

    }

    clearProductTable(prodInfo);
    let productLS = getProductsInLocalStorage(prodInfo);

    for (var i = 0; i < productLS.length; i++) {

        var row = document.createElement('tr');
        row.innerHTML = `

        <td>${productLS[i].title}</td>
        <td>${productLS[i].value}</td>
        <td><button onclick="deleteProductInfoItem('${productLS[i].title}', '${prodInfo}');" type="button"><i class="btn fa fa-trash"></i></button></td>
      `;
        productTable.appendChild(row);
    }
    setFrontendItems();
}

function setFrontendItems() {
    spec = getProductsInLocalStorage('spec');
    color = getProductsInLocalStorage('color');
    category = getProductsInLocalStorage('category');

    jsonSpecs.value = JSON.stringify(spec, 't', 3);
    jsonCategories.value = JSON.stringify(category, 't', 3);
    jsonColors.value = JSON.stringify(color, 't', 3);
}


//UPDATE


//DELETE
function clearLocalStorage() {
    localStorage.clear();
}

function clearProductTable(prodInfo) {

    switch (prodInfo) {
        case 'spec':
            var productTable = document.querySelector('#spectable tbody');
            break;

        case 'color':
            var productTable = document.querySelector('#colortable tbody');
            break;

        case 'category':
            var productTable = document.querySelector('#categorytable tbody');
            break;

        // default:
        //     console.log('storage to be gotten not specified.');

    }

    while (productTable.firstChild) {
        productTable.removeChild(productTable.firstChild);
    }
}

function deleteProductInfoItem(productTitle, prodInfo) {
    let productsLS;
    // get all the products in localstorage
    productsLS = getProductsInLocalStorage(prodInfo);
    // this following loop simply scans through the products list and checks if any of the items are equal to the id passed into the function
    productsLS.forEach(function (productLS, index) {
        if (productLS.title === productTitle) {
            productsLS.splice(index, 1);
        }
    });
    // after everything, add the products back to local storage
    switch (prodInfo) {
        case 'spec':
            localStorage.setItem('specifications', JSON.stringify(productsLS));
            break;

        case 'color':
            localStorage.setItem('colors', JSON.stringify(productsLS));
            break;

        case 'category':
            localStorage.setItem('categories', JSON.stringify(productsLS));
            break;

        // default:
        //     console.log('storage to be gotten not specified.');

    }

    loadProductInfoTable(prodInfo);
    //setFrontendItems();
}