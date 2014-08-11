var req=false, sbox;

function init() {
    req = (window.XMLHttpRequest)
    // for IE7+,Firefox,Chrome,Opera,Safari
    ? new XMLHttpRequest()
    // code for IE6, IE5
    : new ActiveXObject("Microsoft.XMLHTTP");
    sbox=document.getElementById("suggestions");
    req.onreadystatechange=display_suggestion;
}

function display_suggestion() {
    var sg;
    if (this.readyState === this.DONE && this.status === 200) {
        if ( (sg=req.responseText) && sg !== "") {
            parser=new DOMParser();
            xmlDoc=parser.parseFromString(sg,"text/xml");
            if (xmlDoc.getElementsByTagName("oname").length !== 0) {
                sbox.innerHTML = "";
                for (var j = 0; j < xmlDoc.getElementsByTagName("oname").length; j++) {
                    sbox.innerHTML += "<ul><li>"+xmlDoc.getElementsByTagName("oname")[j].childNodes[0].nodeValue
                            +" : "+xmlDoc.getElementsByTagName("oprice")[j].childNodes[0].nodeValue+"</li></ul>";
                }
                sbox.style.display="block";
            }
            else {
                sbox.style.display="none";
            }
        }
        else {
            sbox.style.display="none";
        }
    }
}

function getSuggestion(str){
    if (!req) init();
    str=str.replace(/^\s+||\s+$/g,"");
    if (str==="") {
        sbox.style.display="none";
        return;
    }
    req.open("GET", "search.php?itemName="+str, true);
    req.send();
}