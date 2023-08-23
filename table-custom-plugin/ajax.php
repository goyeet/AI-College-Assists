<?php
    function updateUserHistoryAjax() {
        if ((isset($_POST['promptId']) || isset($_POST['customPrompt'])) && isset($_POST['cvInput']) && isset($_POST['response'])) {
            $promptId = is_null($_POST['promptId']) ? null : (int) $_POST['promptId'];
            $customPrompt = is_null($_POST['customPrompt']) ? null : sanitize_text_field($_POST['customPrompt']);
            $cvInput = sanitize_text_field($_POST['cvInput']);
            $generated_response = "";
            foreach ($_POST['response'] as $response) {
                $generated_response = $generated_response . sanitize_text_field($response) . ' ';
            }
            // print_r($generated_response);
        }

        // Function call that sets table data
        set_user_history_table_data($promptId, $customPrompt, $cvInput, $generated_response);
    }
    add_action('wp_ajax_nopriv_updateUserHistoryAjax', 'updateUserHistoryAjax'); // for non-logged in user
    add_action('wp_ajax_updateUserHistoryAjax', 'updateUserHistoryAjax');
?>