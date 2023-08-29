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
                <td class="date-created">
                    <?php echo $row['created']; ?>
                </td>
                <td class="prompt-id">
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
                    <?php
                    $cv_inputs_selected_string = $row['cv_inputs_selected'];
                    $selected_inputs = explode('|', $cv_inputs_selected_string); // takes the string and turns it into an array
                    ?>
                    <ul>
                        <?php foreach ($selected_inputs as $word) : ?>
                            <li><strong><?php echo $word?></strong></li>
                        <?php endforeach; ?>
                    </ul
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
                    <?php

                    $checked = in_array('Academic Accomplishments', $selected_inputs) ? 'checked' : '';
                    echo "<input type='checkbox' class='cv-checkbox' value='Academic Accomplishments' $checked>Academics<br>";

                    $checked = in_array('Athletic Accomplishments', $selected_inputs) ? 'checked' : '';
                    echo "<input type='checkbox' class='cv-checkbox' value='Athletic Accomplishments' $checked>Athletic Accomplishments<br>";

                    $checked = in_array('Extracurricular Activities', $selected_inputs) ? 'checked' : '';
                    echo "<input type='checkbox' class='cv-checkbox' value='Extracurricular Activities' $checked>Extracurricular Activities<br>";

                    $checked = in_array('Passions', $selected_inputs) ? 'checked' : '';
                    echo "<input type='checkbox' class='cv-checkbox' value='Passions' $checked>Passions<br>";
                    ?>

                    <!-- Only display additional text box -->
                    <form method="post" class="edit-input-form">
                        <?php wp_nonce_field('update_text_action', 'update_text_nonce'); ?>
                        <textarea class="edit-additional-info" name="updated_text"><?php echo esc_textarea($row['additional_info']); ?></textarea>
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