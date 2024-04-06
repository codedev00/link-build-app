jQuery(document).ready(function() {
    var script = document.currentScript;
    var fullUrl = script.src;
    // console.log(fullUrl);
    let url = new URL(fullUrl);
    let params = new URLSearchParams(url.search.slice(1));
    let obj = {};
    
    for(let pair of params.entries()) {
        obj[pair[0]] = pair[1]; 
    }

    var prodlink = obj.prodlink;
    var store = obj.shop;
    var key = obj.key;
    var currenturl = window.location.href;

    if (currenturl === prodlink) {
        
        $('body').append('<div class="header" id="myHeader"><b><h2 align="center"><a href="https://' + store + '/pages/outbound-links" target="_blank">Discover More Products</a></b></h2></div>');
    }
});

