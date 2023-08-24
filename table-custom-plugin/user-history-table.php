<style>

    .loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .editing-row {
        display: none; 
    }

</style>

<?php
$user_history_data = get_user_history_table_data();

if (empty($user_history_data)) : ?>
    <p>No history available.</p>

<?php else : ?>
    
    <table id="user-history-table">

        <tr>
            <th>Date Created</th>
            <th>Prompt Used</th>
            <th>CV Inputs Selected</th>
            <th>Generated Response</th>
        </tr>

        <?php foreach ($user_history_data as $row) : ?>
            <tr class="data-row">
                <td class="date-created">
                    <?php echo $row['created']; ?>
                </td>
                <td class="prompt-used">
                    <?php
                        echo $row['custom_prompt'] ? $row['custom_prompt'] : $row['prompt'];
                    ?>
                </td>
                <td class="cv-inputs-used">
                    <?php echo $row['cv_inputs']; ?>
                </td>
                <td class="generated-response">
                    <?php echo $row['generated_response']; ?>
                </td>
                <td class="edit-button-cell">
                    <button class="edit-button" data-text-id="<?php echo $text_id; ?>">Edit</button>
                </td>
                <!-- <td class="input">
                    <div class="before_edit">
                        <ul class="inputText">
                            TEST
                            <?php>
                        // $text_id = 1; //$prompt_used; // should be prompt ids of the current user
                            // $text = "prompt used";//$prompt_used; $wpdb->get_var($wpdb->prepare("SELECT prompt_id FROM wp_gig_user_history WHERE id = %d", $text_id));
                            
                            <?>
                        </ul> 
                    </div>
                    <button class="edit-button" data-text-id="<?php /* echo $text_id; */ ?>">Edit</button>
                    <form class="edit-form" data-text-id="<?php /* echo $text_id; */ ?>" method="post" style="display: none;">
                    <?php /* wp_nonce_field('update_text_action', 'update_text_nonce'); */ ?>
                    <textarea name="updated_text"><?php /* echo esc_textarea($text); */ ?></textarea>
                    <input type="submit" name="submit" value="Update Text">
                </form>

                </td> -->
            </tr>
            <tr class="editing-row">
                <td class="date-created">
                </td>
                <td class="prompt-used">
                    <?php
                        echo $row['custom_prompt'] ? $row['custom_prompt'] : $row['prompt'];
                    ?>
                </td>
                <td class="cv-inputs-used">
                    <?php echo $row['cv_inputs']; ?>
                </td>
                <td class="generated-response">
                </td>
                <td class="save-button-cell">
                    <button class="save-button" data-text-id="<?php echo $text_id; ?>">Save Changes</button>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>



    <?php
    
    // if (isset($_POST['submit'])) {
    //     if (isset($_POST['update_text_nonce']) && wp_verify_nonce($_POST['update_text_nonce'], 'update_text_action')) {
    //         $updated_text = sanitize_textarea_field($_POST['updated_text']);
            
    //         // Update the database
    //         $wpdb->update(
    //             'wp_gig_user_history',
    //             array(
    //                 'custom_prompt' => $updated_text,
    //                 'user_id' => get_current_user_id(),
    //                 'prompt_id' => null,
    //                 'cv_inputs' => $cvInput,
    //                 'generated_response' => $generatedResponse
    //             )
    //         );
            
    //         echo "Text updated successfully!";
    //     } else {
    //         echo "Security check failed!";
    //     }
    // }
    

    ?>

    <h1>Generated Response</h1>
    <div class="response-box">
        <div class="text-box">
            <div class="generated-response"></div>
        </div>
        <div class="button-cell">
            <button class="generate-button cv-button">Generate</button>
            <div class="loading-spinner hidden">
                <div class="loader"></div>
            </div>
        </div>
    </div>
<?php endif; ?>