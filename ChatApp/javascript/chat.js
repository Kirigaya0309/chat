const form = document.querySelector(".typing-area"),
inputField = document.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); // prevent form submission
}

sendBtn.onclick = () =>{
    let xhr = new XMLHttpRequest(); // create XML object
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = ""; //once message is inserted into database then leave blank the text field
            }
        }
    }

    let formData = new FormData(form); //create new form data object
    xhr.send(formData); //sending the form data to php
}

setInterval(() => {
    //start Ajax
    let xhr = new XMLHttpRequest(); // create XML object
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data;
            }
        }
    }

    let formData = new FormData(form); //create new form data object
    xhr.send(formData); //sending the form data to php
}, 500) //this function runs every 500ms