// Global variable that tracks what is passed into API call
var cueString = "";

var selectedPromptText = "";

// Detects click on button and grabs prompt from the corresponding table row
jQuery(document).ready(function ($) {
    $('.generate-button').on('click', function (e) {

        console.log('generate button clicked');

        // array to hold selected inputs that are checked
        const selectedInputs = [];

        // selects all cv checkboxes on the page
        var cvCheckboxes = jQuery.makeArray($('.cv-checkbox'));

        // console.log('cv checkboxes: ' + cvCheckboxes);
        // console.log('cv checkboxes on page: ' + cvCheckboxes.length);

        // Filter and get only the checked checkboxes
        var checkedCheckboxes = cvCheckboxes.filter((checkbox) => {
            console.log('current item in iteration: ' + checkbox);
            return checkbox.checked;
        });

        // console.log('SELECTED cv checkboxes on page: ' + checkedCheckboxes.length);

        // console.log('checked boxes array: ' + checkedCheckboxes);

        // loop through all checkboxes that are checked
        checkedCheckboxes.forEach(checkbox => {
            selectedInputs.push(checkbox.value);
        });

        console.log(selectedInputs);

        // Grab entire str from user input box to prepare for string parsing
        // let userInput = $( this ).closest("tr").find( ".input" );
        // let inputStr = userInput.find("span").text();

        // let start = "Non-school Accomplishments:";
        // let startIndex = str.indexOf(start);
        // let endIndex = str.indexOf("|", startIndex + start.length);
        // let result = str.slice(startIndex + start.length, endIndex);


        let responseBox = $( this ).closest("tr").find(".response-box");
        let generatedResponseWrapper = responseBox.find(".generated-response"); // Eventually move response box
        
        // Show loading spinner
        showLoading();
        
        // TODO: make the cue string using selected prompt and selected cv inputs
        cueString = selectedPromptText; /* + academic + athletic + school + passion + misc; */


        console.log('cue: ' + cueString);

        // Make the API call using AJAX
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
            dataType: 'json',
            data: {
                action: 'generateEssayAjax',
                // Additional data to send to the server if needed.
                prompt: cueString // material to feed AI for essay generation
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

// -------------------------------------------------------------------------------------

// Detects click on PROMPT checkboxes
jQuery(document).ready(function ($) {
    $('.prompt-checkbox').on('change', function (e) {

        // console.log('prompt-checkbox clicked');

        // Uncheck other checkboxes with class "prompt-checkbox" if not the selected one
        $('.prompt-checkbox').not(this).prop('checked', false);
 
        // grabs prompt text in row
        let promptBox = $( this ).closest("tr").find( ".input" );
        selectedPromptText = "Addressing this prompt: " + promptBox.find("span").text();
        
        console.log('selected prompt: ' + selectedPromptText);
    });
});

// Detects click on CV INPUT checkboxes
jQuery(document).ready(function ($) {
    $('.cv-checkbox').on('change', function (e) {

        // console.log('cv-checkbox clicked');

        // Uncheck other checkboxes with class "cv-checkbox" if not the selected one
        let currentCheckboxes = $(this).closest("td").find( ".cv-checkbox" );
        $('.cv-checkbox').not(currentCheckboxes).prop('checked', false);
    });
});
