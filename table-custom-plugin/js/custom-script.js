// Global variable that tracks what is passed into API call
var cueString = "";

var selectedPromptText = "";

// Detects click on button and grabs prompt from the corresponding table row
jQuery(document).ready(function ($) {
    $('.generate-button').on('click', function (e) {

        console.log('generate button clicked');

        let customPrompt = $('#input_custom_prompt_text').val();
        console.log('custom prompt entered: ' + customPrompt);

        // array to hold selected inputs that are checked
        const selectedInputs = [];

        // selects all cv checkboxes on the page
        var cvCheckboxes = jQuery.makeArray($('.cv-checkbox'));

        let userInput = null;

        // Filter and get only the checked checkboxes
        var checkedCheckboxes = cvCheckboxes.filter((checkbox) => {
            console.log('current item in iteration: ' + checkbox);
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
            console.log('section Name: ' + sectionName);
            let startIndex = inputStr.indexOf(start);
            let endIndex = inputStr.indexOf(" | ", startIndex + start.length);
            let sectionData = inputStr.slice(startIndex + start.length, endIndex); // Data associated with current section
            console.log('section data: ' + sectionData);
            
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

        // TODO: make the cue string using selected prompt and selected cv inputs
        cueString = selectedPromptText + ' \nWrite me an essay response using the information provided below, no more than 300 words please.\n' + cvInputString; /* + academic + athletic + school + passion + misc; */

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
    //$('.prompt-checkbox').on('change', function (e) {
    $('.prompt-checkbox').on('change', function (e) {
        // console.log('prompt-checkbox clicked');

        // Uncheck other checkboxes with class "prompt-checkbox" if not the selected one
        $('.prompt-checkbox').not(this).prop('checked', false);
 
        
        // if (document.getElementByID('input_own_prompt').prop(checked)) {
        //     selectedPromptText = "I am a college apllicant writng an essay trying to address the prompt: \"" + $(this).find("input").text() + "\"";
        //     console.log('entered prompt: ' + document.getElementById('input_own_prompt').value);
        // }

        // else {
        
        // let customPrompt = $('#input_custom_prompt_text').val();
        // console.log('custom prompt entered: ' + customPrompt);
        // let promptBox = $( this ).closest("tr").find( ".input" );

        // selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + promptBox.find("span").text();
        // console.log('selected prompt: ' + selectedPromptText);
        
        // $('#input_own_prompt_checkbox').change(function () {
        //     if (this.checked) {
        //         console.log('checkbox is checked');
        //         let userInput = $('#input_custom_prompt_text').val(); 
        //         selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + userInput + "\"";
        //     }
        //     // else{
        //     //     let promptBox = $( this ).closest("tr").find( ".input" );

        //     //     selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + promptBox.find("span").text();
        //     //     console.log('selected prompt: ' + selectedPromptText);
        //     // }
        // });
        
        
        //need a way to find out if this checkbox is the custom prompt checkbox

        //  if ($('#input_custom_prompt_text').val()) { //checks if the user entered text into a custom prompt
        //     let userInput = $('#input_custom_prompt_text').val(); 
        //     selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + userInput + "\"";
        //  }
        //  else {
             // grabs prompt text in row
            let promptBox = $( this ).closest("tr").find( ".input" );

            selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + promptBox.find("span").text();
           //}
             console.log('selected prompt: ' + selectedPromptText);
                
        //}

        


        //console.log('selected prompt: ' + promptBox.find("span").text());

        // $('#input_own_prompt').click(function() {
        //     let isChecked = $(this).prop('checked');
        //     if (isChecked) {
        //         console.log('custom input Checkbox is checked.');
        //     } else {
        //         console.log('custom input Checkbox is not checked.');
        //     }
        // }
    //);
  //  }
         
});
});

jQuery(document).ready(function($) {
    $('#input_own_prompt_checkbox').change(function () {
            if (this.checked) {
                $('.prompt-checkbox').not(this).prop('checked', false);
                console.log('checkbox is checked');
                let userInput = $('#input_custom_prompt_text').val(); 
                selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + userInput + "\"";
                console.log('selected prompt: ' + selectedPromptText);
            }
            // else{
            //     let promptBox = $( this ).closest("tr").find( ".input" );

            //     selectedPromptText = "I am a college applicant writing an essay trying to address the prompt: \"" + promptBox.find("span").text();
            //     console.log('selected prompt: ' + selectedPromptText);
            // }
});
});

// jQuery(document).ready(function($) {
//     $('#formButton').click(function() {
//         let userInput = $('#input_custom_prompt_text').val();
//         selectedPromptText = userInput;
//         console.log('selected prompt: ' + selectedPromptText);
//     });
// });

// Detects click on CV INPUT checkboxes
jQuery(document).ready(function ($) {
    $('.cv-checkbox').on('change', function (e) {

        // console.log('cv-checkbox clicked');

        // Uncheck other checkboxes with class "cv-checkbox" if not the selected one
        let currentCheckboxes = $(this).closest("td").find( ".cv-checkbox" );
        $('.cv-checkbox').not(currentCheckboxes).prop('checked', false);
    });
});
