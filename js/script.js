document.addEventListener("DOMContentLoaded", function () {
  function loadPhoneNumbers() {
    const phoneNumbersForm = document.forms.phoneNumberList;
    const phoneNumbersRows = phoneNumbersForm.querySelectorAll(".phone-number-row");

    fetch("http://localhost/php/submit.php", {
      method: "POST",
      body: new URLSearchParams({ phoneNumberList: "loadPhoneNumbers" }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        // Loop through existing rows and update them
        console.log(data);
        phoneNumbersRows.forEach((row, index) => {
          if (data[index]) {
            const input = row.querySelector('input[type="text"]');
            input.value = data[index].phone_number;
          } else {
            // Remove extra rows that don't have data
            row.remove();
          }
        });

        // Create new rows for any remaining data
        for (let i = phoneNumbersRows.length; i < data.length; i++) {
          const newRow = document.createElement("div");
          newRow.className = "phone-number-row";
          newRow.innerHTML = `
                    <input type="text" id="${data[i].phone_number}" value="${data[i].phone_number}" disabled>
                    <input type="submit" name="delete" value="Delete" onclick="deletePhoneNumber('${data[i].phone_number}')">
                `;
          phoneNumbersForm.appendChild(newRow);
        }
      })
      .catch((error) => console.log(error));
  }

  function addPhoneNumber(phoneNumber) {
    response = fetch("http://localhost/php/submit.php", {
      method: "POST",
      body: new URLSearchParams({ Add: "Add", phone: phoneNumber }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
      .then((response) => response.json()) // Parse the response as JSON
      .then((data) => {
        if (data) {
          loadPhoneNumbers();
          console.log(data);
          alert("Phone number added successfully");
        } else {
          alert("Failed to add phone number");
        }
      })
      .catch((error) => console.log(error));
  }

  const addPhoneNumberForm = document.querySelector(
    'form[name="addPhoneNumber"]'
  );
  addPhoneNumberForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const phoneNumberInput = addPhoneNumberForm.querySelector(
      'input[name="phone"]'
    );
    const newPhoneNumber = phoneNumberInput.value.trim(); // Changed "phoneNumberINput" to "phoneNumberInput"

    if (newPhoneNumber.length > 0) {
      addPhoneNumber(newPhoneNumber);
      phoneNumberInput.value = "";
    } else {
      alert("Please enter a valid phone number");
    }
  });

  function sendMessage(message) {
    fetch("../php/submit.php", {
      method: "POST",
      body: new URLSearchParams({ sendSMS: "sendSMS", message }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          alert(data.error);
        } else {
          alert("Message sent successfully");
        }
      })
      .catch((error) => console.log(error));
  }

  // Function to log out the user
  function logoutUser() {
    fetch("../php/submit.php", {
      method: "POST",
      body: new URLSearchParams({ Logout: "Logout" }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Redirect to the login page or perform other actions as needed
          window.location.href = "login.html";
        } else {
          alert("Logout failed. Please try again.");
        }
      })
      .catch((error) => console.error(error));
  }

  // Event listener for the "Send SMS" button
  document
    .querySelector('form[name="messageForm"]')
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const message = document.getElementById("message").value;
      sendMessage(message);
      // Optionally clear the message input field or perform other actions
      document.getElementById("message").value = "";
    });

  document
    .getElementById("logoutButton")
    .addEventListener("click", function () {
      logoutUser();
    });

  // Call the function to load phone numbers when the page loads
  loadPhoneNumbers();
});
