function ajax(url, method, data, callback) {
    var xmlhttp; //ajax对象
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (method == "GET") {
        var query = "";
        if (data != "") {
            query = "?";
            for (var i in data) {
                query += (i + "=" + data[i] + "&");
            }
            query = query.replace(/&$/, "");
        }
        xmlhttp.open(method, url + query, true);
        xmlhttp.send();
    }
    if (method == "POST" && data != "") {
        var query = "";
        for (var i in data) {
            query += (i + "=" + data[i] + "&");
        }
        query = query.replace(/&$/, "");
        xmlhttp.open(method, url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(query);
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                callback(xmlhttp.responseText);
            } else {
                callback(xmlhttp.status);
            }
        }
    }
}