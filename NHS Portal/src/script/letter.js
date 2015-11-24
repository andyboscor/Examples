function addLine(){
	var div = document.createElement("div");
	var node = document.createElement("select");

	var counter = document.getElementById("counter").getAttribute("value");
	counter++;
	document.getElementById("counter").setAttribute("value", counter);

	node.setAttribute("id", "box" + counter);
	node.setAttribute("name", "box" + counter);
	node.setAttribute("onchange", "fetchSelectables(this)");

	var selectable = document.createElement("select");
	selectable.setAttribute("name", "select" + counter);
	selectable.setAttribute("id", "select" + counter);
	
	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            node.innerHTML = xmlhttp.responseText;
            document.getElementById("report_dropdowns").appendChild(div).appendChild(node);
			document.getElementById("report_dropdowns").appendChild(div).appendChild(selectable);
			fetchSelectables(node);
        }
    }
    xmlhttp.open("GET","src/php_libs/get_letter.php?new=",true);
    xmlhttp.send();
}

function fetchSelectables(element){
	var id = element.getAttribute("id");
	var value = element.options[element.selectedIndex].value;
	id = id[3];

	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("select" + id).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","src/php_libs/get_letter.php?box=" + value,true);
    xmlhttp.send();
}