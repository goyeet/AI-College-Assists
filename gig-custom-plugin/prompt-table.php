<?php
$essay_prompts = array_reverse(get_prompts_data());

if (empty($essay_prompts)) : ?>
    <p>No essay prompts available.</p>
<?php else : ?>

    <h3>Prompts</h3>

    <table id="prompt-table">
        <tr>
            <!-- <th>Prompt ID</th> -->
            <th>Prompt Type</th>
            <th>Prompt</th>
        </tr>

        <?php foreach ($essay_prompts as $prompt) : ?>
            <?php 
                $prompt_title = $prompt->post_title;
                $prompt_type = strip_tags($prompt->post_content);
            ?>
            <tr>
                <td class="prompt-type"><?php echo esc_html($prompt_type); ?></td>
                <!-- prompt -->
                <td class="input">
                    <span>
                        <?php echo esc_html($prompt_title);?>
                    </span>
                </td>
                <td>
                    <input type="checkbox" id="selected_prompt" class="prompt-checkbox"><br>
                </td>
            </tr>
            
        <?php endforeach; ?>

        <tr>
            <!--last table row for user to input their own prompt-->
            <td class="prompt-type">Custom Prompt</td>
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