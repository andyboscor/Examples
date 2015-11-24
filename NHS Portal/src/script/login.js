function clearInput(element, original){
    if(element.value == original){
        element.value = "";
        element.style.color = "#222222";
    }
}

function checkInput(element, original){
    if(element.value == ""){
        element.value = original;
        element.style.color = "#8A909A";
    }
}