// Detects click on button and grabs prompt from the corresponding table row
jQuery(document).ready(function ($) {
    $('.generate-button').on('click', function (e) {
        // console.log('button clicked');
        // this refers to button in this case
        let prompt = $( this ).closest("tr").find( ".prompt" );
        let promptText = prompt.find("span").text();
        let generatedResponseWrapper = prompt.find("div");
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
                // If response is undefined, handle error
                if (response === undefined) {
                    console.log('API returned undefined');
                }
                console.log(response);
                // call function to display the generated content
                // take response, iterate over content obj, and use JS to create HTML DOM elements to put them on page
                generatedResponseWrapper.html('<hr><p>' + response.content.join('</p><hr><p>') + '</p>');
            },
          
            error: function(xhr, textStatus, errorThrown) {
                console.log('AJAX request failed: ' + textStatus + ', ' + errorThrown);
            }
        });
    });
});
