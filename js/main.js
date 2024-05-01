"use strict";
//permet de faire la validation de formulaire avec bootstrap
window.addEventListener('load', init, false);

let form;

function init() 
{
    form = document.querySelector('.needs-validation');
    form.addEventListener('submit', valider, false);
}

function valider(event) 
{
    if (form.checkValidity() === false) 
    {
        event.preventDefault();
    }
    form.classList.add('was-validated');     
    
}