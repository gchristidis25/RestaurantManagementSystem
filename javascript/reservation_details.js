function getCustomerID()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "customerID")
        {
            return Number(decodeURIComponent(value));
        }
    }
    return null;
}

function getGuests()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "numberOfGuests")
        {
            return Number(decodeURIComponent(value));
        }
    }
    return null;
}

function getChosenDate()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "reservationDate")
        {
            return decodeURIComponent(value);
        }
    }
    return null;
}

function getStartTime()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "startTime")
        {
            return decodeURIComponent(value);
        }
    }
    return null;
}

function getEndTime()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "endTime")
        {
            return decodeURIComponent(value);
        }
    }
    return null;
}

async function createReservation()
{
    const customerID = getCustomerID();
    const numberGuests = getGuests();
    const date = getChosenDate();
    const startTime = getStartTime();
    const endTime = getEndTime();
    const reservationDetails = document.getElementById("reservation-details").value;

    const data = {
        customerID: customerID,
        numberGuests: numberGuests,
        date: date,
        startTime: startTime,
        endTime: endTime,
        reservationDetails: reservationDetails
    };

    console.log(data);

    const API_URL = "http://localhost:80/RestaurantManagementSystem/api/reservation_api.php";
    await fetch(API_URL, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    });
}

function addSubmitButtonFunctionality()
{
    const submitButton = document.getElementById("submit");
    submitButton.addEventListener("click", async(event) => {
        event.preventDefault();
        await createReservation();
        // window.location.href = "reservation_submitted.php";
    })
}

document.addEventListener("click", addSubmitButtonFunctionality)