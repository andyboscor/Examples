function sizeBox(id){
    for (var i = 0; i < id.length; i++) {
        if(id[i] == 1){
            height = 382;
            document.getElementById("dashboard_box" + id[i]).style.height = height + "px";
            height = window.innerHeight - 120 - 40 - 20 - height;
            document.getElementById("dashboard_box" + id[i + 1]).style.height = height + "px";
        } else if(id[i + 1] == 1){
            height = 382;
            document.getElementById("dashboard_box" + id[i + 1]).style.height = height + "px";
            height = window.innerHeight - 120 - 40 - 20 - height;
            document.getElementById("dashboard_box" + id[i]).style.height = height + "px";
        } else {
            if(document.getElementById("dashboard_box" + id[i + 1])){
                var freeheight = window.innerHeight - 120 - 40 - 20;
                var topheight = document.getElementById("dashboard_box" + id[i]).offsetHeight;
                var bottomheight = document.getElementById("dashboard_box" + id[i + 1]).offsetHeight;

                var ratio = bottomheight / (topheight + bottomheight);
                bottomheight = Math.floor(freeheight * ratio);
                topheight = freeheight - bottomheight;
                if(topheight < 150){
                    topheight = 150;
                    bottomheight = freeheight - topheight;
                } else if(bottomheight < 150){
                    bottomheight = 150;
                    topheight = freeheight - bottomheight;
                }
                document.getElementById("dashboard_box" + id[i]).style.height = topheight + "px";
                document.getElementById("dashboard_box" + id[i + 1]).style.height = bottomheight + "px";
            } else {
                var freeheight = window.innerHeight - 120 - 40 - 20;
                var height = document.getElementById("dashboard_box" + id[i]).offsetHeight;
                if(height > freeheight){
                    document.getElementById("dashboard_box" + id[i]).style.height = freeheight + "px";
                } else {
                    document.getElementById("dashboard_box" + id[i]).style.height = height + "px";
                }
            }
        }
        i++;
    }
}

function expandTextBox(ele){
    ele.style.maxHeight = "9000px";
}

function collapseTextBox(ele){
    ele.style.maxHeight = "100px";
}

function glowTable(ele){
    var id = ele.id.split('_');
    row = id[3][0];
    col = id[3][1];
    var id_pre = id[0] + '_' + id[1] + '_' + id[2] + '_';
    for(i = 1; i <= col; i++){
        document.getElementById(id_pre + row + i).style.backgroundColor = "#E0E0E0";
    }
    for(i = 1; i <= row; i++){
        document.getElementById(id_pre + i + col).style.backgroundColor = "#E0E0E0";
    }
    
    document.getElementById(id_pre + row + col).style.backgroundColor = "#C8C8C8";
}

function clearTable(ele){
    var id = ele.id.split('_');
    row = id[3][0];
    col = id[3][1];
    var id_pre = id[0] + '_' + id[1] + '_' + id[2] + '_';
    for(i = 1; i <= col; i++){
        document.getElementById(id_pre + row + i).style.backgroundColor = "#ECECEC";
    }
    for(i = 1; i <= row; i++){
        document.getElementById(id_pre + i + col).style.backgroundColor = "#ECECEC";
    }
}

//Box specific functions

//Functions for Imaging box
function updateImagingReport(id){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("dashboard_structure_imaging_report").innerHTML = xmlhttp.responseText;
            var i = 0;
            if(!document.getElementById("dashboard_box_imaging_report" + i)){
                document.getElementById("dashboard_structure_imaging_date").innerHTML = "";
                return;
            }

            while(document.getElementById("dashboard_box_imaging_report" + i).style.display == "none"){
                i++;
            }

            document.getElementById("dashboard_structure_imaging_date").innerHTML = document.getElementById("dashboard_box_imaging_report" + i).getAttribute('date');
            checkImagingDate(-1);
        }
    }
    xmlhttp.open("GET","src/php_libs/get_imaging.php?category=" + id,true);
    xmlhttp.send();
}

function checkImagingDate(id){
    if(id == -1){
        document.getElementById("dashboard_structure_imaging_date_next").style.display = "none";
        if(document.getElementById("dashboard_box_imaging_report1")){
            document.getElementById("dashboard_structure_imaging_date_back").style.display = "inline";
        } else {
            document.getElementById("dashboard_structure_imaging_date_back").style.display = "none";
        }
        return;
    }

    if(document.getElementById("dashboard_box_imaging_report" + (id - 1))){
        document.getElementById("dashboard_structure_imaging_date_back").style.display = "inline";
    } else {
        document.getElementById("dashboard_structure_imaging_date_back").style.display = "none";
    }

    if(document.getElementById("dashboard_box_imaging_report" + (id + 1))){
        document.getElementById("dashboard_structure_imaging_date_next").style.display = "inline";
    } else {
        document.getElementById("dashboard_structure_imaging_date_next").style.display = "none";
    }
}

function updateImagingCategory(id){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("dashboard_structure_imaging_categories").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","src/php_libs/get_imaging.php?selectable=" + id,true);
    xmlhttp.send();
}

function updateImagingDate(to){
    var i = 0;
    if(!document.getElementById("dashboard_box_imaging_report" + i)){
        return;
    }

    while(document.getElementById("dashboard_box_imaging_report" + i).style.display == "none"){
        i++;
    }

    if (to == -1) {
        if(document.getElementById("dashboard_box_imaging_report" + (i - 1))){
            document.getElementById("dashboard_box_imaging_report" + i).style.display = "none";
            document.getElementById("dashboard_box_imaging_report" + (i - 1)).style.display = "block";
            document.getElementById("dashboard_structure_imaging_date").innerHTML = document.getElementById("dashboard_box_imaging_report" + (i - 1)).getAttribute('date');
            checkImagingDate(i - 1);
        }
    } else if (to == 1){
        if(document.getElementById("dashboard_box_imaging_report" + (i + 1))){
            document.getElementById("dashboard_box_imaging_report" + i).style.display = "none";
            document.getElementById("dashboard_box_imaging_report" + (i + 1)).style.display = "block";
            document.getElementById("dashboard_structure_imaging_date").innerHTML = document.getElementById("dashboard_box_imaging_report" + (i + 1)).getAttribute('date');
            checkImagingDate(i + 1);
        }
    }
}

function saveProblemList(){
    var content = document.getElementById("dashboard_problem_list_textarea").value;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("dashboard_problem_list_status").innerHTML = "Saved";
            setTimeout(function() {
                document.getElementById("dashboard_problem_list_status").innerHTML = "";
            }, 1000);
        }
    }
    xmlhttp.open("GET","src/php_libs/update_problem_list.php?content=" + content,true);
    xmlhttp.send();
}