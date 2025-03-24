function userRegister(event) {
    event.preventDefault();
    const data = new FormData(event.target);
    const values = Object.fromEntries(data.entries());
    fetch('/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(values)
    })
    .then(response=>response.json())
    .then(data=> {
            if(!data.success) {
                document.getElementById('fname_error').textContent = data.errors.first_name;
                document.getElementById('lname_error').textContent = data.errors.last_name;
                document.getElementById('email_error').textContent = data.errors.error;
                document.getElementById('contact_error').textContent = data.errors.contact_number;
                document.getElementById('username_error').textContent = data.errors.username;
                document.getElementById('password_error').textContent = data.errors.password;
            } else {
                window.location.href = data.redirect;
            }
        })
    .catch(error=> console.error('Error', error));
}
