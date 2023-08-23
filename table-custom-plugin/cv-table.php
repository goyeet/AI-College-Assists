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

    .response-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .text-box {
        border: .5px solid #000000;
        border-radius: 5px;
        width: 1000px;
        min-height: 500px;
        height: auto;
        padding: 10px;
    }

    .cv-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 8px;
        margin-right: 5px;
    }

    .cv-selection {
        text-align: left;
    }

    .button-cell {
        margin-left: 10px;
    }
    
</style>

<?php

$user_form_entries = get_user_cv_form_entries(); // array of user's entry ids

if (empty($user_form_entries)) : ?>
    <p>No entries available.</p>
<?php else : ?>

    <?php $cv_form_entry_fields_data = get_user_cv_form_entry_fields($user_form_entries); // get all data from cv form entries ?>
    
    <?php if (empty($cv_form_entry_fields_data)) : ?>
        <p>No data available.</p>
    <?php else : ?>

        <table id="cv-table">
            <tr>
                <th>Entry ID</th>
                <th>User Input</th>
                <th>Section Selection</th>
            </tr>

            <?php
                // Associative Array that holds user's entries
                // $userEntryHolder = array(
                //      'entry_1' => "{blah blah blah}",
                //      'entry_2' => "{blah blah blah}"
                // );
                $userEntryHolder = array();
                foreach ($user_form_entries as $entryId) {
                    $userEntryHolder[$entryId] = "";
                }

                //must change
                /* $form = GFAPI::get_form(1);
                if ($form) {
                    $existing_fieldIDs = wp_list_pluck($form['fields'], 'id'); // Array of existing field IDs, array to track what field IDs are used in form
                

                    //$post_content = json_decode($form->post_content, true); // decoded JSON object into php array
                    //$existing_fieldIDs = array_keys($post_content['fields']); // array to track what field IDs are used in form
                } */
                
                // loop through results (rows that belong to user)
                foreach ($cv_form_entry_fields_data as $row) {

                    

                    // if row's field ID is NOT in the existing field ID array (deprecated or never existed)
                    /* $search_result = array_search($row['field_id'], $existing_fieldIDs);
                    if ($search_result !== 0 && $search_result === false) {
                        $userEntryHolder[$row['entry_id']] .= "(DEPRECATED): " . $row['value'] . " | ";
                    }
                    // if row's field ID IS in existing field ID array
                    else {
                        $field = $form = GFAPI::get_form($form_id);
                        $field_name = $post_content['fields'][$row['field_id']]['label'];   $field_label = rgar($field, 'label'); 
                        if ($field_name) {
                            $userEntryHolder[$row['entry_id']] .= $field_name . ": " . $row['value'] . " | ";
                        }
                    } */
                    
                }
            ?>
            <?php foreach ($userEntryHolder as $entryID => $inputStr) : ?>
                <tr>
                    <td class="entry-id"><?php echo esc_html($entryID);?></td>
                    <td class="input">
                        <span class="inputText">
                            <?php echo esc_html($inputStr);?>
                        </span>
                    </td>
                    <td class="cv-selection">
                        <input type="checkbox" class="cv-checkbox" value="Academic Accomplishments:">Academics<br>
                        <input type="checkbox" class="cv-checkbox" value="Athletic Accomplishments:">Athletic Accomplishments<br>
                        <input type="checkbox" class="cv-checkbox" value="Non-school Accomplishments:">Non-School Accomplishments<br>
                        <input type="checkbox" class="cv-checkbox" value="Passions:">Passions<br>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Additional Input</h3>
        <h4>Add any prompt specific or additional information you'd like to include in this generation below:</h4>

        <form> 
            <span><input type="text" id="additional_cv_input" name="additional_cv_input" maxlength="300" /></span>
        </form>    

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

<?php endif; ?>