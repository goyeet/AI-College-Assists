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
            <?php 

            // $cv_fields = array(); 
            // foreach ($cv_form_entry_data as $row) 
                // if (in_array($row['field_id'], $cv_fields)) {
                //     break;
                // }
                // else {

                // }

                ?>
            <th>Entry ID</th>
            <th>User Input</th>
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
                // print_r('value: '.$row['value']);
                if ($row['value'] == $entered_user_email) { //if entered email equals value for that row
                    // store entry id in array
                    array_push($users_entry_ids, $row['entry_id']);
                    // print_r('pushing '.$row['entry_id'].' to array');
                }
                
                
            }

            // user did not have any entries in data table
            if (empty($users_entry_ids)) {
                echo '<p>No data available. Please enter your CV information through the provided form and try again.</p>';
                die;
            }

            // print_r($users_entry_ids); // debugging purposes

            // $rows_in_table = array();
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
            // print_r($userInputHolder);

            // loop through data table and find all rows that are associated with user's entry ids
            foreach ($cv_form_entry_data as $row) {
                // if row belongs to user
                if (in_array($row['entry_id'], $users_entry_ids)) {
                    // if entry is one of the 4 CV inputs
                        // create row in checklist for CV Input

                    $userInputHolder[$row['entry_id']] .= $row['value'] . "\n";
                    
                    // if field isn't already a part of displayed table
                    /* if (!in_array($row['field_id'], $users_cv_field_ids)) {
                        array_push($users_cv_field_ids, $row['field_id']); // push field_id to array that tracks field_id's
                    } */
                    //2d array 
                    //all rows with the same entry id will have their field ids stored in the same array within the 2d array
                    //with values
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

        <?php     
            //2nd for loop
                //3rd for loop
                    //for every field id in the 2d array
                    //fill in table with value, verifying that the field_id of the column name matches the field id
                
                    ?>
                    

                
                    <!-- <tr>
                        <td class="date-of-entry"></td>
                        <td class="introduction"></td>
                        <td class="area-of-interest"></td>
                        <td class="fav-subject"></td>
                        <td class="fav-teacher"></td>
                        <td class="date-of-entry"></td>
                        <td class="date-of-entry"></td>
                        <td class="date-of-entry"></td>
                        <td class="date-of-entry"></td>
                    </tr> -->
                    <!--find field id, use it to find field name, match field name to column name, insert value into associated column/row -->


                    <?php
                    //create new table row
                    //delete entry id from entry ids array
                    /* $field_id = $row['field_id'];
                    $field_value = $row['value'];
                    $field_name = wpforms()->get('field', $field_id)->name; */

                    
                    /* if (in_array($row['entry_id']), $rows_in_table) {
                        //add value to table
                    } */
                
                //else (entry id is not in the array so it already has a row from the table)
            
        ?>
    </table>
<?php endif; ?>