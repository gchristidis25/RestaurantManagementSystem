function addReturnButtonFunctionality()
{
    const returnButton = document.getElementById("return-button");
    returnButton.addEventListener("click", () => {
        location.href = "./main_page.php";
    })
}

document.addEventListener("click", () => {
    addReturnButtonFunctionality();
})