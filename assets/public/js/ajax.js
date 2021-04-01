/* ---------------------------- */
/* XMLHTTPRequest Enable 	*/
/* ---------------------------- */
function createObject() {
    var request_type;
    
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        request_type = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        request_type = new XMLHttpRequest();
    }
    return request_type;
}

var http = createObject();

/* -------------------------- */
/* SEARCH					 */
/* -------------------------- */

function suggestExpertise() {
    department_id = document.getElementById('department').value;
    // Set te random number to add to URL request
    var base_url = "http://localhost:8888/rms/index.php/document/get_expertiseName";
    nocache = Math.random();
    http.open('POST', base_url+'/'+department_id);
    http.onreadystatechange = suggestReplyExpertise;
    http.send(null);
}

function suggestReplyExpertise() {
    if(http.readyState == 4){
        var response = http.responseText;
        e = document.getElementById('expertise');
        if(response!=""){
            e.innerHTML=response;
            e.style.display="block";
        } else {
            e.style.display="none";
        }
    }
}

function suggestmemberName() {
    group_id = document.getElementById('group').value;
    // Set te random number to add to URL request
    var base_url = "http://localhost:8888/tumainifinance/index.php/loan/get_memberName";
    nocache = Math.random();
    http.open('POST', base_url+'/'+group_id);

    //Send the proper header information along with the request
    //http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //http.setRequestHeader("Content-length", postdata.length);

    http.onreadystatechange = suggestReplymemberName;
    http.send(null);
}

function suggestReplymemberName() {
    if(http.readyState == 4){
        var response = http.responseText;
        e = document.getElementById('member_id');
        if(response!=""){
            e.innerHTML=response;
            e.style.display="block";
        } else {
            e.style.display="none";
        }
    }
}

