function userLogin(event) {
    event.preventDefault();
    const data = new FormData(event.target);
    const values = Object.fromEntries(data.entries());
    fetch('/employee/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(values)
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.authorized === false) {
                window.location.href = data.redirect;
            }
            if(!data.success) {
                document.getElementById('username-error').textContent = data.errors.username;
                document.getElementById('password-error').textContent = data.errors.password;
            } else {
                window.location.href = data.redirect;
            }
        })
    .catch(error=> console.error('Error', error));
}
