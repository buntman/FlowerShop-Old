function fetchUser(id) {
    const table = document.getElementById("myTable");
    const row = table.querySelector(`tbody tr[data-id="${id}"]`);
    table.querySelectorAll('tbody tr[data-id]').forEach(r => r.classList.remove('table-active'));
    if (row) {
        row.classList.add("table-active");
    }
}

function activateStatus() {
    const row = document.querySelector('tr.table-active');
    const id = row.dataset.id;
    fetch('/admin/manage-account/edit-status/activate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                fetchUpdatedUserDetails(id);
            }
        })
    .catch(error=> console.error('Error', error));
}

function deactivateStatus() {
    const row = document.querySelector('tr.table-active');
    const id = row.dataset.id;
    fetch('/admin/manage-account/edit-status/deactivate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                fetchUpdatedUserDetails(id);
            }
        })
    .catch(error=> console.error('Error', error));
}

function fetchUpdatedUserDetails(id) {
    fetch('/admin/manage-account/edit-status/update', {
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
                    const cells = row.cells;
                    cells[4].innerText = data.status;
                    alert("User status successfully updated!");
                }
            }
        })
    .catch(error=> console.error('Error', error));
}
