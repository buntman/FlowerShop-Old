function deleteAccount(id) {
    fetch('/admin-manage-account/delete-account', {
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
                }
            }
            console.log(data.message);
        })
    .catch(error=> console.error('Error', error));
}
