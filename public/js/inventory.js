const table = document.getElementById('myTable');
const rows = table.querySelectorAll('tbody tr');

rows.forEach(row => {
    row.addEventListener("click", fetchName);
});

function fetchName() {
    const row = event.currentTarget;
    const column = row.querySelectorAll('td');
    const product_name = column[2].textContent;
    sendProductDetails(product_name);
}

function sendProductDetails(product_name) {
    fetch('/inventory', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({product_name})
    })
    .then(response=>response.json())
    .then(data=> {
            document.getElementById('product-image').src = data.image_path;
            document.getElementById('product-name').textContent = data.name;
            document.getElementById('product-description').textContent = data.description;
            document.getElementById('product-price').textContent = data.price;
        })
    .catch(error=> console.error('Error', error));
}




