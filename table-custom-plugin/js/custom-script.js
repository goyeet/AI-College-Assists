
jQuery(document).ready(function ($) {
    $('.generate-button').on('click', function () {
        console.log('button clicked');

        let prompt = $( this ).siblings( ".prompt" );
        console.log(prompt);

        // Make the API call using AJAX
        /* $.ajax({
            url: 'YOUR_API_ENDPOINT_URL', // Replace with your API endpoint URL
            method: 'GET', // Use 'POST' for POST requests
            dataType: 'json', // The expected data type from the API response
            success: function (data) {
                // Handle the API response data here
                console.log(data);
            },
            error: function (xhr, status, error) {
                // Handle errors if the API call fails
                console.error(error);
            }
        }); */
    });
});
