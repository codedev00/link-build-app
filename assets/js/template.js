// $(document).ready(function() {
//     fetch('https://localhost/shop_app/api/outbound-links-data') // API endpoint
//         .then(response => response.json())
//         .then(data => {
//             console.log(data); // Log the data to verify

//             var currenturl = window.location.href;
//             if (currenturl.includes('/pages/outbound-links')) {
//                 const dataContainer = $('<div id="data-container"></div>'); // Create a container for all data
//                 $('.section-header').append(dataContainer); // Append the container

//                 // Append each item as a card inside the container
//                 data.forEach((item, index) => {
//                     const card = $('<div class="header">' +
//                         '<div class="box">' +
//                         '<h6 style="font-size:33px;">' + item.title + '</h6>' +
//                         '<p style="font-size:12px;">' + item.keyword + '</p>' +
//                         '<img src="' + item.image + '" height="130px" width="100px">' +
//                         '</div>' +
//                         '</div>');
//                     dataContainer.append(card);
//                 });
//             }
//         })
//         .catch(error => console.error('Error fetching data:', error));
// });

$(document).ready(function() {
    var script = document.currentScript;
	var fullUrl = script.src;
    
    let url = new URL(fullUrl);
    let params = new URLSearchParams(url.search.slice(1));

    let obj = {};
    for(let pair of params.entries()) {
        obj[pair[0]] = pair[1]  
    }
    var val=obj.shop;
    // console.log( val)
    const itemsPerPage = 20; 
    const maxPageLinks = 5; 
    let currentPage = 1;
    let data; 

	
    fetch('https://localhost/shop_app/api/outbound-links-data?store='+val+'') 
        .then(response => response.json())
        .then(responseData => {
            data = responseData; 
            // console.log(data); 

            var currenturl = window.location.href;
            if (currenturl.includes('/pages/outbound-links')) {
                const sectionHeader = $('.section-header');

                
                function displayItems(page) {
                    const dataContainer = $('<div id="data-container" class="data-list" style="display:flex; max-width:100%;flex-wrap: wrap;"></div>'); // Create a container for all data
                    sectionHeader.empty().append(dataContainer); 

                    const startIndex = (page - 1) * itemsPerPage;
                    const endIndex = Math.min(startIndex + itemsPerPage, data.length);
                    const itemsToShow = data.slice(startIndex, endIndex);

                    itemsToShow.forEach(item => {
						var string = item.title;
						var length = 6;
						var trimmedString = string.substring(0,length)+ "..." ;
						const keywordText = item.keyword ? '<p style="font-size:14px;">' + item.keyword + '</p>' : '<p style="font-size:14px;">No keyword</p>';
                        const card = $('<div class="header" style="padding: 10px; max-width:25%; flex:0 0 25%;">' +
                            '<div class="box" style="height:100%; padding:15px;">' +
                            '<a href="'+item.link+'" target="_blank"><h6 style="font-size:22px;">' + trimmedString + '</h6></a>' +
                            '<a href="'+item.link+'" target="_blank">' + keywordText + '</a>' +
                            '<a href="'+item.link+'" target="_blank"><img src="' + item.image + '" height="130px" width="100px"></a>' +
                            '</div>' +
                            '</div>');
                        dataContainer.append(card);
                    });
                }

                
                function generatePaginationLinks() {
                    let pagination = $('#pagination'); 
                    if (!pagination.length) { 
                        pagination = $('<div class="pagination" id="pagination"></div>'); 
                        sectionHeader.append(pagination); 
                    } else { 
                        pagination.empty();
                    }

                    const totalPages = Math.ceil(data.length / itemsPerPage);

                    if (totalPages > 1) {
                        pagination.append('<a href="#" id="prev" style="margin-left:15px;">Previous</a>');

                        let startPage = Math.max(1, currentPage - Math.floor(maxPageLinks / 2));
                        let endPage = Math.min(totalPages, startPage + maxPageLinks - 1);

                        if (endPage - startPage + 1 < maxPageLinks) {
                            startPage = Math.max(1, endPage - maxPageLinks + 1);
                        }

                        for (let i = startPage; i <= endPage; i++) {
                            pagination.append('<a href="#" class="page-link" data-page="' + i + '" style= margin-left:15px;">' + i + '</a>');
                        }

                        pagination.append('<a href="#" id="next" style="margin-left:15px;">Next</a>');
                    }

                    
                    $('.page-link').click(function() {
                        const page = parseInt($(this).data('page'));
                        currentPage = page;
                        displayItems(currentPage);
                        generatePaginationLinks(); 
                    });

                    $('#prev').click(function() {
                        if (currentPage > 1) {
                            currentPage--;
                            displayItems(currentPage);
                            generatePaginationLinks();
                        }
                    });

                    $('#next').click(function() {
                        if (currentPage < totalPages) {
                            currentPage++;
                            displayItems(currentPage);
                            generatePaginationLinks();
                        }
                    });
                }

               
                displayItems(currentPage);
                generatePaginationLinks();
            }
        })
    //     fetch('https://localhost/shop_app/api/insertdata',{
    //     method: "POST",
     
    //     // Adding body or contents to send
    //     body: JSON.stringify({
    //        store:val
           
    //     }),
    //     // Adding headers to the request
    //     headers: {
    //         "Content-type": "application/json; charset=UTF-8"
    //     }
    // })
     
    // // Converting to JSON
    // .then(response => response.json())
});










