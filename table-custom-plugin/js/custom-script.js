// Global variable that tracks what is passed into API call
var cueString = ""

var selectedPromptText = ""

var prompt_id = ""

var generatedResponse = ""

var cvInputString = ""

var useCustomPrompt = false //will be used to store whether the user wants to use the custom prompt

// Detects click on button and grabs prompt from the corresponding table row
jQuery(document).ready(function ($) {
    $(".generate-button").on("click", function (e) {
        console.log('regular generate button clicked');

        if (useCustomPrompt) {
            //if using the user's inputted prompt, aka custom prompt is selected by user
            selectedPromptText = $("#input_custom_prompt_text").val()
            // console.log('custom prompt post generate: ' + selectedPromptText);
            // console.log('if ran' + useCustomPrompt);
        }
    
        // array to hold selected inputs that are checked
        const selectedInputs = []

        // selects all cv checkboxes on the page
        var cvCheckboxes = jQuery.makeArray($(".cv-checkbox"))

        let userInput = null

        // Filter and get only the checked checkboxes
        var checkedCheckboxes = cvCheckboxes.filter((checkbox) => {
            // console.log('current item in iteration: ' + checkbox);
            // if userInput hasn't already been set
            if (checkbox.checked && userInput == null) {
                userInput = $(checkbox).closest("tr").find(".input")
            }
            return checkbox.checked;
        })

        // Hardcoded other CV inputs
        selectedInputs.push("Introduction")

        // loop through all checkboxes that are checked
        checkedCheckboxes.forEach((checkbox) => {
            selectedInputs.push(checkbox.value)
        });

        selectedInputs.push("Key Moments")
        selectedInputs.push("Challenges Overcome")

        console.log(selectedInputs)

        cvInputString = ""

        selectedInputs.forEach((sectionName) => {
            let inputStr = userInput.find("[data-label='" + sectionName + "']").text();
            cvInputString = cvInputString + sectionName + ": " + inputStr;
        });

        console.log('cvInputString: ' + cvInputString);

        // console.log('stored cv inputs for generation: ' + elements);

        // Show loading spinner
        showLoading()
    
        // Check if user had any additional input
        // TODO: make this conditional
        let additionalCVInfo = $("#additional_cv_input").val()
        cvInputString = cvInputString + "Additional Information: " + additionalCVInfo;

        // Make the cue string using selected prompt and selected cv inputs
        cueString =
            'I am a college applicant writing an essay trying to address the prompt: "' +
            selectedPromptText +
            '"' +
            " \nWrite me an essay response using the information provided below, no more than 300 words please.\n" +
            cvInputString;

        console.log("cue: " + cueString);

        // Target response box
        let generatedResponseWrapper = $(".generated-response")

        // Make the API call using AJAX
        e.preventDefault()

        $.ajax({
            type: "POST",
            url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
            dataType: "json",
            data: {
                action: "generateEssayAjax",
                // Additional data to send to the server if needed.
                cue: cueString, // material to feed AI for essay generation
            },
            // Handle the response from the server.
            success: function (response) {
                // hides loading page
                hideLoading()
    
                // If response is undefined, handle error
                if (response.content === undefined) {
                    console.log("API returned undefined")
                    generatedResponseWrapper.html(
                        "<hr><p>Unfortunately, there was an error on our end. Please try again.</p>"
                    )
                }
    
                // Store api call response in global var
                generatedResponse = response.content
                console.log("generated response: " + generatedResponse)
    
                // call function to display the generated content
                // take response, iterate over content obj, and use JS to create HTML DOM elements to put them on page
                generatedResponseWrapper.html(
                    "<hr><p>" + response.content.join("</p><hr><p>") + "</p>"
                )
    
                // Second Ajax call:
                // Pass in prompt (either custom or sample one)
                // Pass in generated response var: generatedResponse (response.content from previous ajax call)
                // Pass in user's selected cv inputs
                $.ajax({
                    type: "POST",
                    url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
                    dataType: "json",
                    data: {
                        action: "updateUserHistoryAjax",
                        promptId: useCustomPrompt ? null : prompt_id,
                        customPrompt: useCustomPrompt ? selectedPromptText : null,
                        cvInput: cvInputString,
                        response: generatedResponse,
                    },
                    // Handle the response from the server.
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response))
                    },
    
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(
                            "AJAX request failed: " + textStatus + ", " + errorThrown
                        )
                    },
                })
            },
    
            error: function (xhr, textStatus, errorThrown) {
                // hides loading page
                hideLoading()
                console.log(
                    "AJAX request failed: " + textStatus + ", " + errorThrown
                )
            },
        })
    })
})


function showLoading() {
    // Show the loading animation and hide the button
    // console.log('show loader');
    let spinners = document.getElementsByClassName("loading-spinner")
    if (spinners.length > 0) {
        for (i = 0; i < spinners.length; i++) {
            spinners[i].classList.remove("hidden")
        }
    }
    let buttons = document.getElementsByClassName("generate-button")
    let buttons2 = document.getElementsByClassName("new-generate-button")
    if (buttons.length > 0) {
        for (i = 0; i < buttons.length; i++) {
            buttons[i].style.display = "none"
        }
    }
    if (buttons2.length > 0) {
        for (i = 0; i < buttons2.length; i++) {
            buttons2[i].style.display = "none"
        }
    }
}

function hideLoading() {
    // Hide the loading animation and show the button
    // console.log('hide loader');
    let spinners = document.getElementsByClassName("loading-spinner")
    if (spinners.length > 0) {
        for (i = 0; i < spinners.length; i++) {
            spinners[i].classList.add("hidden")
        }
    }
    let buttons = document.getElementsByClassName("generate-button")
    let buttons2 = document.getElementsByClassName("new-generate-button")
    if (buttons.length > 0) {
        for (i = 0; i < buttons.length; i++) {
            buttons[i].style.display = "block"
        }
    }
    if (buttons2.length > 0) {
        for (i = 0; i < buttons2.length; i++) {
            buttons2[i].style.display = "block"
        }
    }
}

// -------------------------------------------------------------------------------------

// Detects click on PROMPT checkboxes
jQuery(document).ready(function ($) {
    $(".prompt-checkbox").on("change", function (e) {
        // console.log('prompt-checkbox clicked');

        // Uncheck other checkboxes with class "prompt-checkbox" if not the selected one
        $(".prompt-checkbox").not(this).prop("checked", false)

        if ($(this).is('[id="input_own_prompt_checkbox"]')) {
            useCustomPrompt = true
        } else {
            useCustomPrompt = false //ensures selected prompt gets used
        }

        //finds selected prompt
        let promptBox = $(this).closest("tr").find(".input")
        prompt_id = $(this).closest("tr").find(".prompt-id").text()
        console.log("selected prompt id: " + prompt_id)
        prompt_type = $(this).closest("tr").find(".prompt-type").text()
        console.log("selected prompt type: " + prompt_type)

        selectedPromptText = promptBox.find("span").text()

        console.log("selected prompt: " + selectedPromptText)
    })
})

// Custom prompt input
jQuery(document).ready(function ($) {
    $("#input_own_prompt_checkbox").on("change", function (e) {
        if (this.checked) {
            $(".prompt-checkbox").not(this).prop("checked", false)
            console.log("checkbox is checked")
            selectedPromptText = $("#input_custom_prompt_text").val() //sends user's inputted prompt
            console.log("custom prompt: " + selectedPromptText)
            useCustomPrompt = true //prompts cue to use this prompt
        } else {
            useCustomPrompt = false
            console.log("changed to false")
        }
    })
})

//----------------------------------------------------------------------------
// Detects click on CV INPUT checkboxes
jQuery(document).ready(function ($) {
    $(".cv-checkbox").on("change", function (e) {
        // console.log('cv-checkbox clicked');

        // Uncheck other checkboxes with class "cv-checkbox" if not the selected one
        let currentCheckboxes = $(this).closest("td").find(".cv-checkbox")
        $(".cv-checkbox").not(currentCheckboxes).prop("checked", false)
    })
})

// Display "hidden" editing row underneath the clicked row
jQuery(document).ready(function($) { //changes text to be an editable form
    $(".edit-button").on("click", function (e) {
        let editRow = $(this).closest("tr").next();
        editRow.css("display", "table-row");
        useAlteredPrompt = true;
    });
});

// Hide editing row when save button is clicked
jQuery(document).ready(function($) { //changes text to be an editable form
    $(".save-button").on("click", function (e) {
        let editRow = $(this).closest("tr");
        editRow.css("display", "none");
    });
});

// Regenerate or new generation button
jQuery(document).ready(function ($) {
    $(".new-generate-button").on("click", function (e) {

        e.preventDefault()

        console.log('New generation button clicked')

        // Show loading spinner
        showLoading()

        let initial_prompt_id = $(this).closest("tr").find(".prompt-id").text();
        console.log('initial prompt id' + initial_prompt_id);
        
        let initial_prompt_text = $(this).closest("tr").prev().find(".stored-prompt").text();
        console.log('initial prompt text: ' + initial_prompt_text);

        let form_prompt_text = $(this).closest("tr").find(".altered_prompt_text").val();
        selectedPromptText = form_prompt_text;
        console.log('edited prompt text: ' + selectedPromptText);
        cvInputString = $(this).closest("tr").find(".altered_cv_text").val();
        // console.log('edited input text: ' + cvInputString);

        // check values to see if they were changed

        let customPromptString = "";

        // if prompt value is changed
        if (form_prompt_text.replace(/\s/g, "") != initial_prompt_text.replace(/\s/g, "")) {
            console.log('text was changed');
            $.ajax({
                type: "POST",
                url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
                dataType: "json",
                data: {
                    action: "searchForPromptAjax",
                    promptToSearch: form_prompt_text,
                },
                // Handle the response from the server.
                success: function (response) {
                    console.log("response: " + JSON.stringify(response))

                    // if Found is success
                    if (response.Found == 'Success') {
                        console.log('function found match');
                        prompt_id = response.Found_Prompt_ID;
                        customPromptString = null;
                    }
                    else {
                        console.log('function DIDNT find match');
                        prompt_id = null;
                        customPromptString = selectedPromptText;
                        console.log('setting custom prompt to: ' + customPromptString);
                    }
                    
                },

                error: function (xhr, textStatus, errorThrown) {
                    console.log(
                        "AJAX request failed: " + textStatus + ", " + errorThrown
                    )
                },
            })
        } else {
            console.log('text was NOT changed');
            prompt_id = initial_prompt_id;
            console.log('prompt id of new generation: ' + prompt_id);
        }
        
        // if cvInput value is changed
        
        // make the cue string using selected prompt and selected cv inputs
        cueString =
            'I am a college applicant writing an essay trying to address the prompt: "' +
            selectedPromptText +
            '"' +
            " \nWrite me an essay response using the information provided below, no more than 300 words please.\n" +
            cvInputString;

        console.log("cue: " + cueString);

        // Target response box
        let generatedResponseWrapper = $(".generated-response")

        // Make the API call using AJAX

        $.ajax({
            type: "POST",
            url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
            dataType: "json",
            data: {
                action: "generateEssayAjax",
                // Additional data to send to the server if needed.
                cue: cueString, // material to feed AI for essay generation
            },
            // Handle the response from the server.
            success: function (response) {
                // hides loading page
                hideLoading()
    
                // If response is undefined, handle error
                if (response.content === undefined) {
                    console.log("API returned undefined")
                    generatedResponseWrapper.html(
                        "<hr><p>Unfortunately, there was an error on our end. Please try again.</p>"
                    )
                }
    
                // Store api call response in global var
                generatedResponse = response.content
                console.log("generated response: " + generatedResponse)
    
                // call function to display the generated content
                // take response, iterate over content obj, and use JS to create HTML DOM elements to put them on page
                generatedResponseWrapper.html(
                    "<hr><p>" + response.content.join("</p><hr><p>") + "</p>"
                )
    
                // Second Ajax call:
                // Pass in prompt (either custom or sample one)
                // Pass in generated response var: generatedResponse (response.content from previous ajax call)
                // Pass in user's selected cv inputs
                $.ajax({
                    type: "POST",
                    url: my_ajax_object.ajaxurl, // WordPress AJAX URL.
                    dataType: "json",
                    data: {
                        action: "updateUserHistoryAjax",
                        promptId: prompt_id,
                        customPrompt: customPromptString,
                        cvInput: cvInputString,
                        response: generatedResponse,
                    },
                    // Handle the response from the server.
                    success: function (response) {
                        console.log("response: " + JSON.stringify(response))
                    },
    
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(
                            "AJAX request failed: " + textStatus + ", " + errorThrown
                        )
                    },
                })
            },
    
            error: function (xhr, textStatus, errorThrown) {
                // hides loading page
                hideLoading()
                console.log(
                    "AJAX request failed: " + textStatus + ", " + errorThrown
                )
            },
        })
        
    });
});