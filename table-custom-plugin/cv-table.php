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
            <th>Date of Entry</th>
            <th>Introduction</th>
            <th>Area of Interest</th>
            <th>Favorite High School Subject</th>
            <th>Favorite High School Teacher</th>
            <th>Favorite Teacher and Why</th>
            <th>Academic Accomplishments</th>
            <th>Athletic Accomplishments</th>
            <th>Non-school Accomplishments</th>
            <th>Passions</th>
            <th>Life Changing Moments</th>
        </tr>

        <?php
            // filter out all results that aren't associated with user email
            $entered_user_email = wp_get_current_user()->user_email; // get user email
            print_r($entered_user_email);

            $users_entry_ids = array();

            // loop through data table and gather all entry ids associated with user email
            foreach ($cv_form_entry_data as $row) {
                print_r('value: '.$row['value']);
                if ($row['value'] == $entered_user_email) { //if entered email equals value for that row
                    // store entry id in array
                    
                    array_push($users_entry_ids, $row['entry_id']);
                    print_r('pushing '.$row['entry_id'].' to array');
                }
            }

            // user did not have any entries in data table
            if (empty($users_entry_ids)) {
                echo '<p>No data available. Please enter your CV information through the provided form and try again.</p>';
                die;
            }

            print_r($users_entry_ids); // debugging purposes

            // $rows_in_table = array();
        ?>
        <?php
            // loop through data table and find all rows that are associated with user's entry ids
            foreach ($cv_form_entry_data as $row) {
                if (in_array($row['entry_id'], $users_entry_ids)) {?>
                    <tr>
                        <td class="entry-id"><?php echo esc_html($row['entry_id']);?></td>
                        <td class="date"><?php echo esc_html($row['date']);?></td>
                        <td class="value"><?php echo esc_html($row['value']);?></td>
                    </tr>
                
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
                }
            }
        ?>
    </table>
<?php endif; ?>