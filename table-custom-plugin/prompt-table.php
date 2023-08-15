<?php if (empty($table_data)) : ?>
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

        td {
            text-align: center;
        }

        .input {
            text-align: left;
        }

        .prompt-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 8px;
        }


        
    </style>

    <table id="prompt-table">
        <tr>
            <th>Prompt ID</th>
            <th>Prompt Type</th>
            <th>Prompt</th>
            <th>Generated Response</th>
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
                    <input type="checkbox" class="prompt-checkbox"><br>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>