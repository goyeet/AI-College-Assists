<style>

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

    .inputText {
        display: flex;
        flex-direction: column;
    }
    
</style>

<?php

$user_form_entries = get_user_cv_form_entries(); // array of user's entry ids

if (empty($user_form_entries)) : ?>
    <p>No entries available.</p>

<?php else : ?>

    <?php
    // get users data from cv form entries
    $cv_form_entry_fields_data = get_user_cv_form_entry_fields($user_form_entries);

    if (empty($cv_form_entry_fields_data)) : ?>
        <p>No data associated with user.</p>

    <?php else : ?>

        <script>
            const entry_data = <?php echo json_encode($cv_form_entry_fields_data);?>
        </script>

        <?php
        $form_data = get_cv_form_data(1); // Hardcoded form ID
        $form_fields = json_decode($form_data[0]['display_meta'], true);
        ?>

        <table id="cv-table">

            <tr>
                <th>Entry ID</th>
                <th>User Input</th>
                <th>Section Selection</th>
            </tr>

            <?php foreach ($user_form_entries as $entryID) : ?>
                <tr>
                    <td class="entry-id"><?php echo esc_html($entryID);?></td>
                    <td class="input">
                        <ul class="inputText">
                            <?php
                            $filtered_array = array_filter($cv_form_entry_fields_data, function($row) use ($entryID) {
                                return $row['entry_id'] == $entryID;
                            });
                            ?>
                            <?php foreach ($filtered_array as $row) : ?>
                                <li class="cv-input">
                                    <?php $field_label = searchMultidimensionalArray($form_fields['fields'], 'id', (string) $row['meta_key'], 'label');?>
                                    <strong><?php echo $field_label?></strong>
                                    <span data-label="<?php echo $field_label ?>"><?php echo esc_html($row['meta_value']);?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td class="cv-selection">
                        <input type="checkbox" class="cv-checkbox" value="Academic Accomplishments">Academics<br>
                        <input type="checkbox" class="cv-checkbox" value="Athletic Accomplishments">Athletic Accomplishments<br>
                        <input type="checkbox" class="cv-checkbox" value="Extracurricular Activities">Extracurricular Activities<br>
                        <input type="checkbox" class="cv-checkbox" value="Passions">Passions<br>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Additional Input</h3>
        <h4>Add any prompt specific or additional information you'd like to include in this generation below:</h4>

        <form> 
            <span><input type="text" id="additional_cv_input" name="additional_cv_input" maxlength="300" /></span>
        </form>    

        
    <?php endif; ?>
<?php endif; ?>