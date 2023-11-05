<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["csvFile"])) {
        $csvFile = $_FILES["csvFile"]["tmp_name"];

        if (($handle = fopen($csvFile, "r")) !== false) {
            $table = pathinfo($_FILES["csvFile"]["name"], PATHINFO_FILENAME);
            $headers = fgetcsv($handle, 0, "\t"); // Use tab as delimiter

            // Generate the SQL schema dynamically based on the headers
            $sql = "CREATE TABLE $table (ID INT AUTO_INCREMENT PRIMARY KEY, ";
            foreach ($headers as $header) {
                $sanitizedHeader = preg_replace('/[^a-zA-Z0-9_]/', '_', $header); // Replace special characters with underscores
                $sql .= "$sanitizedHeader VARCHAR(255) NOT NULL, ";
            }
            $sql = rtrim($sql, ", ");
            $sql .= ");\n";

            // Initialize a flag to skip the first line (header)
            $firstLine = true;

            // Process the CSV data and insert into the database
            while (($data = fgetcsv($handle, 0, "\t")) !== false) {
                // Check for an empty line
                if (count($data) === 1 && trim($data[0]) === "") {
                    continue; // Skip empty lines
                }

                if ($firstLine) {
                    $firstLine = false; // Skip the first line (header)
                    continue;
                }

                // Dynamically generate the column names and values
                $columnNames = implode(', ', array_map(function ($header) {
                    return preg_replace('/[^a-zA-Z0-9_]/', '_', $header);
                }, $headers));

                $columnValues = implode("', '", array_map(function ($value) {
                    return addslashes($value);
                }, $data));

                $insertSql = "INSERT INTO $table ($columnNames) VALUES ('$columnValues');\n";
                $sql .= $insertSql;
            }

            fclose($handle);

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $conn->exec($sql);

                // Send the SQL schema and INSERT statements as a response
                echo $sql;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error: Unable to open the CSV file.";
        }
    } else {
        echo "Error: No file uploaded.";
    }
}