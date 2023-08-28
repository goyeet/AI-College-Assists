<?php if (empty($table_data)) : ?>
    <p>No data available.</p>
<?php else : ?>

    <h3>Prompts</h3>

    <table id="prompt-table">
        <tr>
            <th>Prompt ID</th>
            <th>Prompt Type</th>
            <th>Prompt</th>
        </tr>

        <?php foreach ($table_data as $row) : ?> 
            <tr>
                <td class="prompt-id"><?php echo esc_html($row['prompt_id']);?></td>
                <td class="prompt-type"><?php echo esc_html($row['prompt_type']);?></td>
                <!-- prompt -->
                <td class="input">
                    <span>
                        <?php echo esc_html($row['prompt']);?>
                    </span>
                </td>
                <td>
                    <input type="checkbox" id="selected_prompt" class="prompt-checkbox"><br>
                </td>
            </tr>
            
        <?php endforeach; ?>

        <tr>
            <!--last table row for user to input their own prompt-->
            <td class="prompt-id">Custom</td>
            <td class="prompt-type">Custom Input Prompt</td>
            <!-- prompt -->
            <td class="input">
                
                <form> 
                    <span><input type="text" id="input_custom_prompt_text" name="input_custom_prompt" maxlength="300" /></span>
                </form>
                
            </td>
            <td>
                <input type="checkbox" id="input_own_prompt_checkbox" class="prompt-checkbox"><br>
            </td>
        </tr>
        
    </table>
       
<?php endif; ?>