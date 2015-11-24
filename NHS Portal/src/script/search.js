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

function glowTable(ele){
    row = ele.id.charAt(20);
    document.getElementById("search_result_table_" + row).style.backgroundColor = "rgba(33, 33, 33, 0.1)";
}

function clearTable(ele){
    row = ele.id.charAt(20);
    document.getElementById("search_result_table_" + row).style.backgroundColor = "transparent";
}

function updateTable(input){
    var xmlhttp = new XMLHttpRequest();
    
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                data = xmlhttp.responseText;
                document.getElementById("search_result_table").innerHTML = data;
            }
        }
        xmlhttp.open("GET", "./src/php_libs/search_pred.php?keywords=" + input.value , true);
        xmlhttp.send();
}