function registerUser() {
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const data = {
        username: username,
        email: email,
        password: password
    };

    fetch('/Chat-app/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.text())
    .then(result => {
        // Handle the response from the server
        console.log(result);  // You can replace this with your actual handling logic

        // For example, you might want to show a success message or redirect the user
        if (result === "Registration successful") {
            alert("Registration successful");
            // Redirect to another page or perform other actions
        } else {
            alert("Registration failed. Please try again.");  // Handle other cases accordingly
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function loginUser() {
    const loginUsername = document.getElementById("loginUsername").value;
    const loginPassword = document.getElementById("loginPassword").value;

    const data = {
        username: loginUsername,
        password: loginPassword
    };

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.text())
    .then(result => {
        // Handle the response from the server
        console.log(result);  // You can replace this with your actual handling logic
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


