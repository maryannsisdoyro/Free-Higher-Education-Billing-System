<?php 
include 'db_connect.php'; 
  // Check if a file is uploaded
    if (is_uploaded_file($_FILES['csvFile']['tmp_name'])) {
        $csvFile = $_FILES['csvFile']['tmp_name'];

        // Open the CSV file for reading
        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            // Get the first row, which contains the column headers
            $headers = fgetcsv($handle, 1000, ",");

            // Prepare the SQL statement with placeholders
            $placeholders = implode(',', array_fill(0, 44, '?'));
            $stmt = $conn->prepare("INSERT INTO enroll2024 VALUES ($placeholders)");

            // Bind the parameters dynamically
            $params = array_fill(0, 44, null);
            $types = str_repeat('s', 44); // Assuming all columns are strings
            $stmt->bind_param($types, ...$params);

            // Iterate over the remaining rows
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                for ($i = 0; $i < 44; $i++) {
                    $params[$i] = $data[$i];
                }
                $stmt->execute();
            }

            fclose($handle);
            echo "Data imported successfully.";
        } else {
            echo "Could not open the file.";
        }
    } else {
        echo "No file uploaded.";
    }

    // Close the connection
    $conn->close();
}
</script>
