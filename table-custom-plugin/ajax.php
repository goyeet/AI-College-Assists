<?php
    function updateUserHistoryAjax() {
        if (isset($_POST['prompt']) && isset($_POST['promptId']) && isset($_POST['promptType'])
            && isset($_POST['generatedResponse']) && isset($_POST['cvInput']) && isset($_POST['isCustom'])) {

            $prompt = $_POST['prompt'];
            $promptId = $_POST['promptId'];
            $promptType = $_POST['promptType'];
            $generatedResponse = $_POST['generatedResponse'];
            $cvInput = $_POST['cvInput'];
            $isCustom = $_POST['isCustom'];
        }
        /* TODO: Make sure to validate and sanitize those values. */
        // filter_var();
        // Function call that sets table data
        set_user_history_table_data($prompt, $promptId, $promptType, $generatedResponse, $cvInput, $isCustom);
    }
    add_action('wp_ajax_nopriv_updateUserHistoryAjax', 'updateUserHistoryAjax'); // for non-logged in user
    add_action('wp_ajax_updateUserHistoryAjax', 'updateUserHistoryAjax');
?>