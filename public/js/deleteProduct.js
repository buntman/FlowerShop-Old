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
    .then(data=> {
            if(data.success) {
                document.getElementById('product-image').remove();
                document.getElementById('product-name').remove();
                document.getElementById('product-description').remove();
                document.getElementById('product-price').remove();
            }
            console.log(data.message);
        })
    .catch(error=> console.error('Error', error));
}
