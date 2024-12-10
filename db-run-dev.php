<?php
    include('./common.php');
    include('./db_connect.php');

    $sql = "
    CREATE TABLE IF NOT EXISTS user_sessions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        session_token VARCHAR(255) NOT NULL,
        user_agent VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ALTER TABLE user_sessions ADD COLUMN previous_session_token VARCHAR(255) NULL;
    ";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Table 'user_sessions' created successfully.";
    } else {
        echo "Error creating table: " . $conn->error;
    }
?>