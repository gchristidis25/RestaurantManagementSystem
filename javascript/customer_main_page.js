function initializeGlider() {
    new Glide('.glide', {
      type: 'carousel',
      autoplay: 4000,
      perView: 1
    }).mount();
  }

function addLoginButtonFunctionality()
{
    let loginButton = document.getElementById("login-button");
    loginButton.addEventListener("click", openModal);
}

function openModal()
{
    const modalBackdrop = document.getElementById('loginModal')
    modalBackdrop.style.display = 'flex';
    modalBackdrop.addEventListener("click", closeModal);    
}

function closeModal()
{
    window.onclick = function(event) {
        const modal = document.getElementById('loginModal');
        if (event.target === modal) {
          modal.style.display = "none";
        }
      }
}

function addStaffLoginButtonFunctionality()
{
    const staffLoginButton = document.getElementById("staff-login-btn");
    staffLoginButton.addEventListener("click", () => {
        window.location.href="../staff_login_page.php";
    })
}

function addCustomerLoginButtonFunctionality()
{
    const customerLoginButton = document.getElementById("customer-login-btn");
    customerLoginButton.addEventListener("click", () => {
        window.location.href="../php/customer_login_page.php";
    })
}

function addRegisterButtonFunctionality()
{
    let registerButton = document.getElementById("register-button");
    registerButton.addEventListener("click", () => {
        window.location.href = "register_page.php"
    })
}

document.addEventListener("DOMContentLoaded", () => {
    initializeGlider();
    addLoginButtonFunctionality();
    addRegisterButtonFunctionality();
    addCustomerLoginButtonFunctionality();
    addStaffLoginButtonFunctionality();
    closeModal();
});