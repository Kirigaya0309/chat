const form = document.querySelector('.login form'),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault(); // prevent form submission
}

continueBtn.onclick = () =>{
    //start Ajax
    let xhr = new XMLHttpRequest(); // create XML object
    xhr.open("POST", "php/login.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data == "success "){
                    location.href = "user.php";
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }

    let formData = new FormData(form); //create new form data object
    xhr.send(formData); //sending the form data to php
}