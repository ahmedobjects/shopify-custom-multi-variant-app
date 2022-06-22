var token = "TOKEN_PLACEHOLDER";
var shop = "SHOP_PLACEHOLDER";
console.log(shop);
if(meta && meta.page && meta.page.pageType && meta.page.pageType == 'product'){
    var action = "https://a2d1-197-165-201-189.ngrok.io/product-variants";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           // Typical action to be performed when the document is ready:
           test(xhttp);
        //    console.log(xhttp);
        //    console.log(xhttp.responseText);
        //    document.getElementById("demo").innerHTML = xhttp.responseText;
        }
    };
    xhttp.open("GET", action, true);
    xhttp.send();

    // var productId = meta.page.resourceId;
}else{
    
}

function test(response){
    console.log("in test fucntin");
    console.log(response);
}


// console.log(token);
// console.log(shop);