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

    .hidden {
        display: none; /** Loading Spinner hidden by default */
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
            <th>Prompt ID</th>
            <th>Prompt Used</th>
            <th>CV Inputs Selected</th>
            <th>Generated Response</th>
        </tr>

        <?php foreach ($user_history_data as $row) : ?>

            <tr class="data-row">
                <td class="stored-date-created">
                    <?php echo $row['created']; ?>
                </td>
                <td class="stored-prompt-id">
                    <?php 
                        $promptID = $row['prompt_id'];
                        echo $promptID ? $promptID : "Custom"; 
                    ?>
                </td>
                <td class="stored-prompt">
                    <?php
                        echo $row['custom_prompt'] ? $row['custom_prompt'] : $row['prompt'];
                    ?>
                </td>
                <td class="stored-cv-inputs">
                    <?php echo $row['cv_inputs']; ?>
                </td>
                <td class="stored-response">
                    <?php echo $row['generated_response']; ?>
                </td>
                <td class="edit-button-cell">
                    <button class="edit-button">Reuse and Edit</button>
                </td>
            </tr>
            
            <tr class="editing-row">
                <td class="date-created">
                </td>
                <td class="prompt-id">
                    <?php echo $row['prompt_id']; ?>
                </td>
                <td class="prompt-used">
                    <?php
                        $prompt_text = $row['custom_prompt'] ? $row['custom_prompt'] : $row['prompt'];
                    ?>
                    <form method="post" class="edit-prompt-form">
                        <?php wp_nonce_field('update_text_action', 'update_text_nonce'); ?>
                        <textarea class="altered_prompt_text" name="updated_text"><?php echo esc_textarea($prompt_text); ?></textarea>
                        <!-- <input type="submit" name="submit" value="Update Text"> -->
                    </form>
                </td>
                <td class="cv-inputs-used">
                    <form method="post" class="edit-input-form">
                        <?php wp_nonce_field('update_text_action', 'update_text_nonce'); ?>
                        <textarea class="altered_cv_text" name="updated_text"><?php echo esc_textarea($row['cv_inputs']); ?></textarea>
                        <!-- <input type="submit" name="submit" value="Update Text"> -->
                    </form>
                </td>
                <td class="generated-response">
                    
                </td>
                <td class="save-button-cell">
                    <button class="new-generate-button">New Generation</button>
                    <div class="loading-spinner hidden">
                        <div class="loader"></div>
                    </div>         
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
<?php endif; ?>
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