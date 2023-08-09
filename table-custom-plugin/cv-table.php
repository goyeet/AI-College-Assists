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
    </style>

    <table id="cv-table">
        <tr>
            <th>Entry ID</th>
            <th>User Input</th>
            <th>Section Selection</th>
            <th>Generated Response</th>
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
            $entered_user_email = wp_get_current_user()->user_email; // get user email
            // print_r($entered_user_email);

            $users_entry_ids = array();
            $users_cv_field_ids = array();

            // loop through data table and gather all entry ids associated with user email
            foreach ($cv_form_entry_data as $row) {
                if ($row['value'] == $entered_user_email) { //if entered email equals value for that row
                    // store entry id in array
                    array_push($users_entry_ids, $row['entry_id']);
                }
                
                
            }

            // user did not have any entries in data table
            if (empty($users_entry_ids)) {
                echo '<p>No data available. Please enter your CV information through the provided form and try again.</p>';
                die;
            }

        ?>
        <?php
            // Associative Array that holds user input
            // $userInputHolder = array(
            //      'entryID' => "{user input}",
            //      'entryID' => "{user input}"
            // );
            $userInputHolder = array();
            foreach ($users_entry_ids as $entryId) {
                $userInputHolder[$entryId] = "";
            }

            // loop through data table and find all rows that are associated with user's entry ids
            foreach ($cv_form_entry_data as $row) {
                // if row belongs to user
                if (in_array($row['entry_id'], $users_entry_ids)) {
                    $userInputHolder[$row['entry_id']] .= $row['value'] . "\n";
                }
            }
        ?>
        <?php foreach ($userInputHolder as $entryID => $inputStr) : ?>
            <tr>
                <td class="entry-id"><?php echo esc_html($entryID);?></td>
                <td class="input">
                    <span>
                        <?php echo esc_html($inputStr);?>
                    </span>
                </td>
                <td class="cv-selection">
                    <input type="checkbox" class="cv-checkbox" value="academics">Academics<br>
                    <input type="checkbox" class="cv-checkbox" value="school_accomplishments">School Accomplishments<br>
                    <input type="checkbox" class="cv-checkbox" value="non_school_accomplishments">Non-School Accomplishments<br>
                    <input type="checkbox" class="cv-checkbox" value="passions">Passions<br>
                </td>
                <td class="response-box">
                    <div class="generated-response"></div>
                </td>
                <td class="button-cell">
                    <button class="generate-button cv-button">Generate</button>
                    <div class="loading-spinner hidden">
                        <div class="loader"></div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>