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

        <?php foreach ($table_data as $row) : ?> 
            <tr>
                <td class="date"><?php echo esc_html($row['date']);?></td>
                <td class="value"><?php echo esc_html($row['value']);?></td>
                <td class="prompt">
                    <span>
                        <?php echo esc_html($row['prompt']);?>
                    </span>
                    
                </td>
                <td class="prompt-response-box">
                    <div class="generated-response"></div>
                </td>
                <td class="button-cell">
                    <button class="generate-button">Generate</button>
                    <div class="loading-spinner hidden">
                        <div class="loader"></div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>