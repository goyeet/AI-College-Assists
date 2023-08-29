<h3>User History</h3>

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
                    <input type="checkbox" class="cv-checkbox" value="Academic Accomplishments">Academics<br>
                    <input type="checkbox" class="cv-checkbox" value="Athletic Accomplishments">Athletic Accomplishments<br>
                    <input type="checkbox" class="cv-checkbox" value="Extracurricular Activities">Extracurricular Activities<br>
                    <input type="checkbox" class="cv-checkbox" value="Passions">Passions<br>
                    <!-- Only display additional text box -->
                    <form method="post" class="edit-input-form">
                        <?php wp_nonce_field('update_text_action', 'update_text_nonce'); ?>
                        <textarea class="edit-additional-info" name="updated_text"><?php echo esc_textarea($row['additional_info']); ?></textarea>
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