// Detects click on button and grabs prompt from the corresponding table row

jQuery(document).ready(function ($) {
    $('.generate-button').on('click', function (e) {
        // console.log('button clicked');
        
        // this refers to button in this case
        let prompt = $( this ).closest("tr").find( ".prompt" );
        let promptResponseBox = $( this ).closest("tr").find(".prompt-response-box");
        let promptText = prompt.find("span").text();
        let generatedResponseWrapper = promptResponseBox.find(".generated-response");
        // let loadingSpinnerBox = $( this ).closest("tr").find(".button-cell").find(".loading-spinner"); //defines which row we want the loader spinner to show in
        
        // Show loading spinner
        showLoading();
        
        console.log(promptText);

        // Make the API call using AJAX
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
            dataType: 'json',
            data: {
                action: 'generateEssayAjax',
                // Additional data to send to the server if needed.
                prompt: promptText
            },
            // Handle the response from the server.
            success: function(response) {
                // hides loading page
                hideLoading();

                // If response is undefined, handle error
                if (response.content === undefined) {
                    console.log('API returned undefined');
                    generatedResponseWrapper.html('<hr><p>Unfortunately, there was an error on our end. Please try again.</p>');
                }
                
                console.log(response);
                // call function to display the generated content
                // take response, iterate over content obj, and use JS to create HTML DOM elements to put them on page
                generatedResponseWrapper.html('<hr><p>' + response.content.join('</p><hr><p>') + '</p>');
            },
          
            error: function(xhr, textStatus, errorThrown) {
                // hides loading page
                hideLoading();
                console.log('AJAX request failed: ' + textStatus + ', ' + errorThrown);
            }
        });
    });
});

function showLoading() {
    // Show the loading animation and hide the button
    console.log('show loader');
    let spinners = document.getElementsByClassName("loading-spinner");
    if (spinners.length > 0) {
        for (i = 0; i < spinners.length; i++) {
            spinners[i].classList.remove("hidden");
        }
    }
    let buttons = document.getElementsByClassName("generate-button");
    if (buttons.length > 0) {
        for (i = 0; i < buttons.length; i++) {
            buttons[i].style.display = "none";
        }
    }
}

function hideLoading() {
    // Hide the loading animation and show the button
    console.log('hide loader');
    let spinners = document.getElementsByClassName("loading-spinner");
    if (spinners.length > 0) {
        for (i = 0; i < spinners.length; i++) {
            spinners[i].classList.add("hidden");
        }
    }
    let buttons = document.getElementsByClassName("generate-button");
    if (buttons.length > 0) {
        for (i = 0; i < buttons.length; i++) {
            buttons[i].style.display = "block";
        }
    }
}
