<?php
    function generateEssayAjax() {
        $prompt = $_POST['prompt'];
        /* TODO: Make sure to validate and sanitize those values. */
        // filter_var();
        gig_generate_essay($prompt);        
    }
    add_action('wp_ajax_nopriv_generateEssayAjax', 'generateEssayAjax'); // for non-logged in user
    add_action('wp_ajax_generateEssayAjax', 'generateEssayAjax');
?>