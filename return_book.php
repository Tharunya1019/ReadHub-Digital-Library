<?php
include "connection.php"; // Database connection file

// ----------------------------------------------------------
// CHECK IF PARAMETERS EXIST IN THE URL
// ----------------------------------------------------------
if (isset($_GET['studentid']) && isset($_GET['bookid'])) {

    // ----------------------------------------------------------
    // SANITIZE INPUTS TO PREVENT SQL INJECTION
    // ----------------------------------------------------------
    $studentid = mysqli_real_escape_string($db, $_GET['studentid']);
    $bookid = mysqli_real_escape_string($db, $_GET['bookid']);

    // ----------------------------------------------------------
    // UPDATE THE ISSUEINFO TABLE
    // When a student returns a book, mark the record as "Returned"
    // ----------------------------------------------------------
    $updateQuery = "
        UPDATE issueinfo 
        SET approve = 'Returned' 
        WHERE studentid = '$studentid' 
        AND bookid = '$bookid'
    ";

    // ----------------------------------------------------------
    // EXECUTE THE UPDATE QUERY
    // ----------------------------------------------------------
    if (mysqli_query($db, $updateQuery)) {

        // ----------------------------------------------------------
        // DATABASE TRIGGER (after_return_update)
        // ----------------------------------------------------------
        // Once the above update runs, the trigger automatically:
        // 1. Increases the quantity of the returned book in the 'books' table by 1.
        // 2. Checks the issue and return dates.
        // 3. If returned late, calculates the fine and updates the 'fine' field.
        // ----------------------------------------------------------

        echo "
        <script>
            alert('✅ Book marked as returned successfully!');
            window.location.href = 'manage_issued_books.php';
        </script>
        ";

    } else {
        // ----------------------------------------------------------
        // HANDLE ANY SQL OR CONNECTION ERRORS
        // ----------------------------------------------------------
        echo "
        <script>
            alert('❌ Error updating return status: " . mysqli_error($db) . "');
            window.location.href = 'manage_issued_books.php';
        </script>
        ";
    }

} else {
    // ----------------------------------------------------------
    // IF URL PARAMETERS ARE MISSING (e.g. opened directly)
    // ----------------------------------------------------------
    echo "
    <script>
        alert('⚠️ Invalid request. Missing student ID or book ID.');
        window.location.href = 'manage_issued_books.php';
    </script>
    ";
}
?>
