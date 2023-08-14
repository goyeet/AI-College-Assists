<?php if (empty($cv_form_entry_data)) : ?>
    <p>No data available.</p>
<?php else : ?>
    
    <!-- style sheet for spinner -->
    <style>
        /** Actual Spinner */
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
            border: .5px solid #000000;
            border-radius: 5px;
            width: 1000px;
            height: 500px;
            padding: 10px;
        }
        
    </style>

    <table id="cv-table">
        <tr>
            <th>Entry ID</th>
            <th>User Input</th>
            <th>Section Selection</th>
            
            <!-- <th>Date of Entry</th>
            <th>Introduction</th>
            <th>Area of Interest</th>
            <th>Favorite High School Subject and Why</th>
            <th>Favorite High School Teacher and Why</th>
            <th>Academic Accomplishments</th>
            <th>Athletic Accomplishments</th>
            <th>Non-school Accomplishments</th>
            <th>Passions</th>
            <th>Life Changing Moments</th> -->
            <?php ?>
        </tr>

            <?php
                // filter out all results that aren't associated with user email
                $entered_user_id = get_current_user_id();

                $users_entry_ids = array();

                // loop through data table and gather all entry ids associated with user email
                foreach ($cv_form_entries_data as $row) {
                    if ($row['user_id'] == $entered_user_id) { //if entered email equals value for that row
                        // store entry id in array
                        array_push($users_entry_ids, $row['entry_id']);
                    }
                }

                // user did not have any entries in data table
                if (empty($users_entry_ids)) {
                    echo '<p>No data associated with the logged in user. Please enter your CV information through the provided form and try again.</p>';
                    die;
                }

            ?>
            <?php
                // Associative Array that holds user's entries
                // $userEntryHolder = array(
                //      'entry_1' => "{blah blah blah}",
                //      'entry_2' => "{blah blah blah}"
                // );
                $userEntryHolder = array();
                foreach ($users_entry_ids as $entryId) {
                    $userEntryHolder[$entryId] = "";
                }

                $form = wpforms()->form->get(11);
                if ($form) {
                    $post_content = json_decode($form->post_content, true); // decoded JSON object into php array
                    $existing_fieldIDs = array_keys($post_content['fields']); // array to track what field IDs are used in form
                }
                
                // loop through data table and find all rows that are associated with user's entry ids
                foreach ($cv_form_entry_fields_data as $row) {
                    // if row belongs to user
                    if (in_array($row['entry_id'], $users_entry_ids)) {
                        // if row's field ID is NOT in the existing field ID array (deprecated or never existed)
                        $search_result = array_search($row['field_id'], $existing_fieldIDs);
                        if ($search_result !== 0 && $search_result === false) {
                            $userEntryHolder[$row['entry_id']] .= "(DEPRECATED): " . $row['value'] . " | ";
                        }
                        // if row's field ID IS in existing field ID array
                        else {
                            $field_name = $post_content['fields'][$row['field_id']]['label'];
                            if ($field_name) {
                                $userEntryHolder[$row['entry_id']] .= $field_name . ": " . $row['value'] . " | ";
                            }
                        }
                    }
                }
            ?>
            <?php foreach ($userEntryHolder as $entryID => $inputStr) : ?>
                <tr>
                    <td class="entry-id"><?php echo esc_html($entryID);?></td>
                    <td class="input">
                        <span>
                            <?php echo esc_html($inputStr);?>
                        </span>
                    </td>
                    <td class="cv-selection">
                        <input type="checkbox" class="cv-checkbox" value="Academic Accomplishments:">Academics<br>
                        <input type="checkbox" class="cv-checkbox" value="Athletic Accomplishments:">Athletic Accomplishments<br>
                        <input type="checkbox" class="cv-checkbox" value="Non-school Accomplishments:">Non-School Accomplishments<br>
                        <input type="checkbox" class="cv-checkbox" value="Passions:">Passions<br>
                    </td>
                    <!-- <td class="response-box">
                        <div class="generated-response"></div>
                    </td>
                    <td class="button-cell">
                        <button class="generate-button cv-button">Generate</button>
                        <div class="loading-spinner hidden">
                            <div class="loader"></div>
                        </div>
                    </td> -->
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="response-box">
            <div class="generated-response"></div>
        </div>
        <div class="button-cell">
            <button class="generate-button cv-button">Generate</button>
            <div class="loading-spinner hidden">
                <div class="loader"></div>
            </div>
        </div>

    <?php endif; ?>
<?php endif; ?>