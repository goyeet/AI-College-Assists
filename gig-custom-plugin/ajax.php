<?php
    function generateEssayAjax() {
        if (isset($_POST['cue'])) {
            $cue = $_POST['cue'];
        }
        gig_generate_essay($cue);
    }
    add_action('wp_ajax_nopriv_generateEssayAjax', 'generateEssayAjax'); // for non-logged in user
    add_action('wp_ajax_generateEssayAjax', 'generateEssayAjax');
    
    function updateUserHistoryAjax() {
        if (isset($_POST['promptUsed']) && isset($_POST['cvInputsSelected'])
             && isset($_POST['additionalInfo']) && isset($_POST['cueString']) && isset($_POST['response'])) {
            $promptUsed = sanitize_text_field($_POST['promptUsed']);
            $cvInputsSelected = sanitize_text_field($_POST['cvInputsSelected']);
            $additionalInfo = sanitize_text_field($_POST['additionalInfo']);
            $cueString = sanitize_text_field($_POST['cueString']);
            $generated_response = "";
            foreach ($_POST['response'] as $response) {
                $generated_response = $generated_response . sanitize_text_field($response) . ' ';
            }
        }

        // Function call that sets table data
        set_user_history_table_data($promptUsed, $cvInputsSelected, $additionalInfo, $cueString, $generated_response);
    }
    add_action('wp_ajax_nopriv_updateUserHistoryAjax', 'updateUserHistoryAjax'); // for non-logged in user
    add_action('wp_ajax_updateUserHistoryAjax', 'updateUserHistoryAjax');

    function searchForPromptAjax() {
        if (isset($_POST['promptToSearch'])) {
            $promptToSearch = $_POST['promptToSearch'];
            // Function call that searches table for matches
            searchForPrompt($promptToSearch);
        }
    }
    add_action('wp_ajax_nopriv_searchForPromptAjax', 'searchForPromptAjax'); // for non-logged in user
    add_action('wp_ajax_searchForPromptAjax', 'searchForPromptAjax');
?>