document.addEventListener('DOMContentLoaded', displayCompleteOrder);

function updateOrderStatus(id) {
    fetch('/designer/dashboard/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                const row  = document.querySelector(`div[data-id="${id}"]`);
                if(row) {
                    row.remove();
                    displayCompleteOrder();
                }
            }
        })
    .catch(error=> console.error('Error', error));
}

function displayCompleteOrder() {
    fetch('/designer/dashboard/complete')
    .then(response=>response.json())
    .then(data=> {
                const template = document.getElementById('card');
                const container = document.getElementById('container');
                container.innerHTML = '';
            data.forEach(item =>{
                const clone = template.cloneNode(true);
                clone.style.display = 'flex'; // make visible
                clone.querySelector('.product_image').src = item.product_image;
                clone.querySelector('.product_name').textContent = item.product_name;
                clone.querySelector('.order_id').textContent = item.id;
                clone.querySelector('.customer_name').textContent = item.customer_name;
                clone.querySelector('.pickup_schedule').textContent = `${item.pickup_date} ${item.pickup_time}`;
                const statusVal = clone.querySelector('.status');
                statusVal.textContent = item.status;
                statusVal.classList.add(`status-${item.status.toLowerCase().replace(/ /g, '-')}`);
                container.appendChild(clone);
            });
        })
    .catch(error=> console.error('Error', error));
}

