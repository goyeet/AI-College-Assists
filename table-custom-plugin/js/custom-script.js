// Global variable that tracks what is passed into API call
var cueString = "";

var selectedPromptText = "";

var prompt_id = "";

var prompt_type = "";

//var userCustomFormInput = "";
var useUserInputPrompt = false; //will be used to store whether the user wants to use the custom prompt

var generatedResponse = "";

// Detects click on button and grabs prompt from the corresponding table row
jQuery(document).ready(function ($) {
    $('.generate-button').on('click', function (e) {

        // console.log('generate button clicked');

        if (useUserInputPrompt) { //if using the user's inputted prompt, aka custom prompt is selected by user
            let userCustomFormInput = $('#input_custom_prompt_text').val(); 
            selectedPromptText = userCustomFormInput;
            // console.log('custom prompt post generate: ' + selectedPromptText);
            // console.log('if ran' + useUserInputPrompt);
        }

        // array to hold selected inputs that are checked
        const selectedInputs = [];

        // selects all cv checkboxes on the page
        var cvCheckboxes = jQuery.makeArray($('.cv-checkbox'));

        let userInput = null;

        // Filter and get only the checked checkboxes
        var checkedCheckboxes = cvCheckboxes.filter((checkbox) => {
            // console.log('current item in iteration: ' + checkbox);
            // if userInput hasn't already been set
            if (checkbox.checked && (userInput == null)) {
                userInput = $(checkbox).closest("tr").find( ".input" );
            }
            return checkbox.checked;
        });

        // Hardcoded other CV inputs
        selectedInputs.push("Introduction:");

        // loop through all checkboxes that are checked
        checkedCheckboxes.forEach(checkbox => {
            selectedInputs.push(checkbox.value);
        });

        selectedInputs.push("Key Moments:");
        selectedInputs.push("Challenges Overcome:");

        console.log(selectedInputs);

        // Grab entire str from user input box to prepare for string parsing
        let inputStr = userInput.find("span").text();
        console.log('grabbed text: ' + inputStr);

        // Associative array that stores pairs of "sectionName" = sectionData
        // Ex. "Academic Accomplishments: " = 4.0
        let chosenCVFields = {};

        selectedInputs.forEach(sectionName => {
            //sectionName is the section names like "Academic Accomplishments: "
            let start = sectionName;
            // console.log('section Name: ' + sectionName);
            let startIndex = inputStr.indexOf(start);
            let endIndex = inputStr.indexOf(" | ", startIndex + start.length);
            let sectionData = inputStr.slice(startIndex + start.length, endIndex); // Data associated with current section
            // console.log('section data: ' + sectionData);
            
            chosenCVFields[sectionName] = sectionData; //adds checkedbox's section name and section data to chosenCVFields associative array
        });

        // var elements = Object.keys(chosenCVFields).map(function(k) {
        //     return chosenCVFields[k];
        // })

        // console.log('stored cv inputs for generation: ' + elements);
        let generatedResponseWrapper = $(".generated-response"); // Eventually move response box
        
        // Show loading spinner
        showLoading();
        
        let cvInputString = "";

        for (const cvInput in chosenCVFields) {
            if (chosenCVFields.hasOwnProperty(cvInput)) {
                cvInputString = cvInputString + cvInput + " " + chosenCVFields[cvInput] + "\n"; // double newline breaks AI for some reason
            }
        }

        let additionalCVInfo = $('#additional_cv_input').val(); 
        cvInputString = cvInputString + "Additional Information: " + additionalCVInfo;

        // TODO: make the cue string using selected prompt and selected cv inputs
        cueString = "I am a college applicant writing an essay trying to address the prompt: \"" + selectedPromptText  + "\"" + ' \nWrite me an essay response using the information provided below, no more than 300 words please.\n' + cvInputString; /* + academic + athletic + school + passion + misc; */

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
                cue: cueString // material to feed AI for essay generation
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
                
                // Store api call response in global var
                generatedResponse = response.content;
                
                // console.log(response);

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

        // Second Ajax call:
        // Pass in prompt (either custom or sample one)
        // Pass in generated response var: generatedResponse (response.content from previous ajax call)
        // Pass in user's selected cv inputs
        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
            dataType: 'json',
            data: {
                action: 'updateUserHistoryAjax',
                prompt: selectedPromptText,
                promptId: prompt_id,
                promptType: prompt_type,
                generatedResponse: generatedResponse,
                cvInput: cvInputString,
                isCustom: useUserInputPrompt
            },
            // Handle the response from the server.
            success: function(response) {
                /* try {
                    var plainTextResponse = JSON.parse(response);
                    console.log('Decoded plain text:', plainTextResponse);
                } catch (error) {
                    console.error('Parsing JSON failed:', error);
                } */
                console.log('response: ' + JSON.stringify(response));
            },
          
            error: function(xhr, textStatus, errorThrown) {
                console.log('AJAX request failed: ' + textStatus + ', ' + errorThrown);
            }
        });
    });
});

function showLoading() {
    // Show the loading animation and hide the button
    // console.log('show loader');
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
    // console.log('hide loader');
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

        if ($( this ).is('[id="input_own_prompt_checkbox"]')) {
            useUserInputPrompt = true;
        }
        else {
            useUserInputPrompt = false; //ensures selected prompt gets used
        }
        
        //finds selected prompt
        let promptBox = $( this ).closest("tr").find( ".input" );
        prompt_id = $( this ).closest("tr").find( ".prompt-id" ).text();
        console.log('selected prompt id: ' + prompt_id);
        prompt_type = $( this ).closest("tr").find( ".prompt-type" ).text();
        console.log('selected prompt type: ' + prompt_type);

        selectedPromptText = promptBox.find("span").text();

        console.log('selected prompt: ' + selectedPromptText);
    });
});

// Custom prompt input
jQuery(document).ready(function($) {
    $('#input_own_prompt_checkbox').change(function () {
        if (this.checked) {
            $('.prompt-checkbox').not(this).prop('checked', false);
            console.log('checkbox is checked');
            let userCustomFormInput = $('#input_custom_prompt_text').val(); //sends user's inputted prompt
            selectedPromptText = userCustomFormInput;
            console.log('custom prompt: ' + selectedPromptText);
            useUserInputPrompt = true; //prompts cue to use this prompt
        }
        else {
            useUserInputPrompt = false;
            console.log("changed to false");
        }
    });
});

//----------------------------------------------------------------------------
// Detects click on CV INPUT checkboxes
jQuery(document).ready(function ($) {
    $('.cv-checkbox').on('change', function (e) {
        // console.log('cv-checkbox clicked');

        // Uncheck other checkboxes with class "cv-checkbox" if not the selected one
        let currentCheckboxes = $(this).closest("td").find( ".cv-checkbox" );
        $('.cv-checkbox').not(currentCheckboxes).prop('checked', false);
    });
});
