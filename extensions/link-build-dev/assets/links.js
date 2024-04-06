
$(document).ready(function() {
fetch('https://localhost/shop_app/api/outbound-links-data') 
        .then(response => response.json())
        .then(responseData => {
            data = responseData;
            console.log(data);  
        });
    });