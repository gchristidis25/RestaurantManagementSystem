function saveForm()
{
    document.getElementById('reservation-form').addEventListener('submit', (event) => {
    event.preventDefault();

    const customerID = document.querySelector(".container").id;
    document.cookie = `customerID=${customerID}; path=/; max-age=${60*60}`;

    const date = document.getElementById('date').value;
    document.cookie = `reservationDate=${date}; path=/; max-age=${60*60}`;

    const numGuests = document.getElementById("num-guests").value;
    document.cookie = `numberOfGuests=${numGuests}; path=/; max-age=${60*60}`;
    });
}

function addSubmitButtonFunctionality()
{
    const submitButton = document.getElementById("submit");
    submitButton.addEventListener("click", () => {
        window.location.href = "timeslots.php";
    });
}

function addReturnButtonFunctionality() {
  const returnButton = document.getElementById("return-button");
  returnButton.addEventListener("click", () => {
    location.href = "../php/customer_dashboard.php";
  });
}

document.addEventListener("DOMContentLoaded", () => {
    saveForm();
    addSubmitButtonFunctionality();
    addReturnButtonFunctionality();
});


