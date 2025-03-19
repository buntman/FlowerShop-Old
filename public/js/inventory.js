function fetchProductDetails(id) {
    fetch('/inventory/item', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            document.getElementById('product-image').src = data.image_path;
            document.getElementById('product-name').textContent = data.name;
            document.getElementById('product-description').textContent = data.description;
            const price = data.price;
            const formattedPrice = `₱ ${price} ${"PHP"}`;
            document.getElementById('product-price').textContent = formattedPrice;
        })
    .catch(error=> console.error('Error', error));
}


function fetchProductToEdit(id) {
    fetch('/inventory/item/edit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            document.getElementById("edit-name").value = data.name;
            document.getElementById("edit-stocks").value = data.stock_quantity;
            document.getElementById("edit-description").textContent = data.description;
            document.getElementById("edit-price").value = data.price;
        })
    .catch(error=> console.error('Error', error));
}

function updateProductDetails(id) {
    event.preventDefault();
    const data = new FormData(event.target);
    const values = Object.fromEntries(data.entries());
    const requestBody = {id, ...values};

    fetch('/inventory/item/edit/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestBody)
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.result) {
                refreshItemDisplayed();
            }
        })
    .catch(error=> console.error('Error', error));
}

function deleteProduct(id) {
    fetch('/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                const table = document.getElementById('myTable');
                const row = table.querySelector(`tbody tr[data-id="${id}"]`);
                if(row) {
                    row.remove();
                    refreshItemDisplayed();
                }
            }
            console.log(data.message);
        })
    .catch(error=> console.error('Error', error));
}

function refreshItemDisplayed() {
    fetch('/inventory/item')
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                document.getElementById('product-image').src = data.product.image_path;
                document.getElementById('product-name').textContent = data.product.name;
                document.getElementById('product-description').textContent = data.product.description;
                const price = data.product.price;
                const formattedPrice = `₱ ${price} ${"PHP"}`;
                document.getElementById('product-price').textContent = formattedPrice;
            }
        })
    .catch(error=> console.error('Error', error));
}

