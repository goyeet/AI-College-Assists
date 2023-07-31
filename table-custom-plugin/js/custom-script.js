// 
jQuery(document).ready(function ($) {
    $('#generate-button').on('click', function () {
        console.log('button clicked');
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

function triggerAPIActionHook() {
    // console.log('id: ' + id + 'key: ' + key + 'prompt: ' + prompt);

    console.log('in action hook');

    // Use jQuery or fetch API to make an AJAX request to the server
    // and trigger the action hook.
    /* jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', {
        'action': 'generate_essay';
        'user_id': id;
        'user_key': key;
        'prompt': prompt;
    }); */
    // do_action('generate_essay', $gig_user_id, $gig_user_key, prompt);
    
    

}