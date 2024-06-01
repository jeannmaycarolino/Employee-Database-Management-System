<?php
// Include your database connection file
include 'config/db.php';

if (isset($_POST['employee_submit'])) {
    // Get the form data
    $editEmployeeID = $_POST['editEmployeeID'];
    $editFirstName = $_POST['editFirstName'];
    $editLastName = $_POST['editLastName'];
    $PositionTitleEdit = $_POST['PositionTitleEdit'];

    // Validate and sanitize the input data as necessary
    $editEmployeeID = mysqli_real_escape_string($conn, $editEmployeeID);
    $editFirstName = mysqli_real_escape_string($conn, $editFirstName);
    $editLastName = mysqli_real_escape_string($conn, $editLastName);
    $PositionTitleEdit = mysqli_real_escape_string($conn, $PositionTitleEdit);

    // Find the PositionID associated with the provided PositionTitle
    $getPositionIDQuery = "SELECT * FROM position WHERE PositionTitle = '$PositionTitleEdit'";
    $positionResult = mysqli_query($conn, $getPositionIDQuery);

    if (mysqli_num_rows($positionResult) > 0) {
        $row = mysqli_fetch_assoc($positionResult);
        $PositionTitleEdit = $row['PositionTitleEdit'];

        // Create the SQL UPDATE statement
        $sql = "UPDATE employee SET FirstName='$editEmployeeID', LastName='$editLastName', PositionID='$editPositionID' WHERE EmployeeID='$editEmployeeID'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            header('Location: employee.php');
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // If the provided PositionTitle does not exist, display an error
        echo "Error: The provided PositionTitle does not exist.";
    }

    // Close the database connection
    mysqli_close($conn);
}

if (isset($_POST['position_submit'])) {
    // Get the form data
    $PositionIDEdit = $_POST['PositionIDEdit'];
    $PositionTitleEdit = $_POST['PositionTitleEdit'];
    $SalaryEdit = $_POST['SalaryEdit'];

    // Validate and sanitize the input data as necessary
    $PositionIDEdit = mysqli_real_escape_string($conn, $PositionIDEdit);
    $PositionTitleEdit = mysqli_real_escape_string($conn, $PositionTitleEdit);
    $SalaryEdit = mysqli_real_escape_string($conn, $SalaryEdit);


    // Create the SQL UPDATE statement
    $sql = "UPDATE position SET PositionTitle='$PositionTitleEdit', Salary='$SalaryEdit' WHERE PositionID='$PositionIDEdit'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header('Location: position.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
}

if (isset($_POST['project_submit'])) {
    // Get the form data
    $projectIDEdit = $_POST['projectIDEdit'];
    $projectNameEdit = $_POST['projectNameEdit'];
    $startDateEdit = $_POST['startDateEdit'];
    $endDateEdit = $_POST['endDateEdit'];

    // Validate and sanitize the input data as necessary
    $projectIDEdit = mysqli_real_escape_string($conn, $projectIDEdit);
    $projectNameEdit = mysqli_real_escape_string($conn, $projectNameEdit);
    $startDateEdit = date('m/d/Y', strtotime($startDateEdit));
    $endDateEdit = date('m/d/Y', strtotime($endDateEdit));

    // Create the SQL UPDATE statement
    $sql = "UPDATE project SET ProjectName='$projectNameEdit', StartDate='$startDateEdit', EndDate='$endDateEdit' WHERE ProjectID='$projectIDEdit'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header('Location: project.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
if (isset($_POST['assignment_submit'])) {
    // Get the form data
    $assignmentIDEdit = $_POST['assignmentIDEdit'];
    $employeeIDEdit = $_POST['employeeIDEdit'];
    $projectIDEdit = $_POST['projectIDEdit'];
    $hoursWorkedEdit = $_POST['hoursWorkedEdit'];

    // Validate and sanitize the input data as necessary
    $assignmentIDEdit = mysqli_real_escape_string($conn, $assignmentIDEdit);
    $employeeIDEdit = mysqli_real_escape_string($conn, $employeeIDEdit);
    $projectIDEdit = mysqli_real_escape_string($conn, $projectIDEdit);
    $hoursWorkedEdit = mysqli_real_escape_string($conn, $hoursWorkedEdit);

    // Create the SQL UPDATE statement
    $sql = "UPDATE assignment SET EmployeeID='$employeeIDEdit', ProjectID='$projectIDEdit', HoursWorked='$hoursWorkedEdit' WHERE AssignmentID='$assignmentIDEdit'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header('Location: assignment.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}


?>