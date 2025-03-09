const delete_button = document.getElementById('delete-button');
const name = document.getElementById('product-name');

delete_button.addEventListener("click", () => {
    const product_name = name.textContent;
    sendNameToServer(product_name);
});

function sendNameToServer(product_name) {
    fetch('/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({product_name})
    })
    .then(response=>response.json())
    .then(data=> console.log(data))
    .catch(error=> console.error('Error', error));
}
