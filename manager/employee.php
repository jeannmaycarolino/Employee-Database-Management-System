<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tailwind config -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Database Management</title>
</head>
<body class="bg-stone-50">
<?php include('../config/db.php'); ?>

<header class="shadow-lg">
    <div class="flex items-center w-full px-6 py-2 justify-between">
        <div class="flex flex-row max-sm:flex-row-reverse m-0 max-sm:w-full max-sm:justify-end">
            <div class="flex justify-center w-full">
                <!-- <img src="./assets/img/logo.png" alt="tailwind-logo" class="h-10 w-10"> -->
            </div>
            <div class="flex items-center max-sm:flex-col-reverse max-sm:items-start">
                <ul id="navigation" class="flex flex-row gap-6 px-8 text-gray-400 font-medium max-sm:hidden max-sm:flex-col max-sm:px-4 max-sm:absolute max-sm:top-14 max-sm:bg-slate-800 max-sm:w-full max-sm:left-0 max-sm:gap-1 max-sm:pb-3 max-sm:rounded-b-lg">
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="index.php"><li>Dashboard</li></a>
                    <a class="py-2 px-3 bg-yellow-400 rounded-md text-black" href="employee.php"><li>Employee</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="position.php"><li>Position</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="project.php"><li>Project</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="assignment.php"><li>Assignment</li></a>
                </ul>
                <div class="max-sm:text-gray-400 max-sm:transition-all">
                    <button onclick="activate()" class="max-sm:p-2 max-sm:rounded-md max-sm:hover:bg-slate-700 max-sm:hover:text-gray-100 max-sm:cursor-pointer max-sm:active:ring-offset-1 max-sm:active:ring-1 max-sm:active:ring-gray-200">
                        <svg id="cross" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <svg id="burger" class="h-6 w-6 hidden max-sm:block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div>
        <a href="../login.php" class="font-medium py-2 px-3 rounded-md hover:bg-red-400 hover:text-black">Sign out </a>
        </div>
    </div>
</header>

<main class="mx-10 my-5">
    <h1 class="text-primary_text text-lg font-bold">Employee</h1>
    <div class="flex flex-row gap-4">
        <div class="flex flex-col gap-4 mt-2">
            <div class="flex flex-row gap-4">
                <?php
                    // Total Employees
                    $employee = "SELECT * FROM employee";
                    $result = mysqli_query($conn, $employee) or die('error');

                    if ($result = mysqli_query($conn, $employee)) {
                        $rowcount = mysqli_num_rows($result);
                        ?>
                        <div class="h-32 w-36 py-2 px-4 shadow-lg rounded-md flex flex-row items-center gap-1 hover:scale-105 hover:cursor-pointer">
                            <div class="flex flex-col">
                                <h1 class="font-medium text-secondary_text text-sm">Total Employees</h1>
                                <span class="text-primary_text text-4xl font-bold"><?php echo $rowcount?></span>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
            <h1 class="text-secondary_text font-semibold text-md">Employees</h1>
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-lightgray">
                    <thead class="text-xs text-primary_text uppercase bg-yellow-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Employee ID</th>
                            <th scope="col" class="px-6 py-3">First Name</th>
                            <th scope="col" class="px-6 py-3">Last Name</th>
                            <th scope="col" class="px-6 py-3">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Set the limit of records per page
                            $limit = 8;

                            // Determine the current page number
                            if (!isset($_GET['page'])) {
                                $current_page = 1;
                            } else {
                                $current_page = $_GET['page'];
                            }

                            // Calculate the offset for the query
                            $initial_page = ($current_page - 1) * $limit;

                            // Fetch the total number of records
                            $total_rows_query = "SELECT COUNT(*) as total FROM employee";
                            $total_rows_result = mysqli_query($conn, $total_rows_query);
                            $total_rows = mysqli_fetch_assoc($total_rows_result)['total'];

                            // Calculate the total number of pages
                            $total_pages = ceil($total_rows / $limit);

                            // Fetch the paginated records
                            $employeeQuery = "SELECT employee.*, position.PositionTitle 
                                            FROM employee
                                            INNER JOIN position ON employee.PositionID = position.PositionID
                                            LIMIT $initial_page, $limit";
                            $employeeResult = mysqli_query($conn, $employeeQuery) or die('error');

                            // Fetch and display the table data
                            getTableData($employeeResult);
                        ?>
                    </tbody>
                    </table>
                    </div>
                    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                        <?php
                            // Display the pagination information
                            $start_record = $initial_page + 1;
                            $end_record = min($initial_page + $limit, $total_rows);
                            echo '<span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900 dark:text-white">'.$start_record.'-'.$end_record.'</span> of <span class="font-semibold text-gray-900 dark:text-white">'.$total_rows.'</span></span>';

                            // Display the pagination links
                            echo '<ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">';
                            for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
                                $class = ($page_number == $current_page) ? "bg-yellow-600" : "bg-yellow-700";
                                echo '<li>';
                                echo '<a href="employee.php?page=' . $page_number . '" class="flex items-center justify-center px-3 h-8 leading-tight text-secondary_text ' . $class . ' border border-gray-600 text-black hover:bg-yellow-700 hover:text-white">' . $page_number . '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        ?>
                    </nav>

        </div>
    </div>

    <!-- Form to Add Employee -->
    <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
        <h1 class="text-secondary_text font-semibold text-md">Add Employee</h1>
        <form id="addEmployeeForm" action="" method="post" autocomplete="off">
            <label for="EmployeeID">Employee ID</label>
            <input type="text" name="EmployeeID" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="FirstName">First Name</label>
            <input type="text" name="FirstName" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="LastName">Last Name</label>
            <input type="text" name="LastName" required autocomplete="off" class="mb-2 p-2 border rounded">

            <label for="PositionTitle">Position Title</label>
                <select id="PositionTitle" name="PositionTitle" required class="mb-2 p-2 border rounded">
                    <option value="" selected disabled>Select Position Title</option>
                    <!-- Assuming you fetch position titles from the database and populate the dropdown dynamically -->
                    <?php
                    // Fetch position titles from the database
                    $positionQuery = "SELECT PositionTitle FROM position";
                    $positionResult = mysqli_query($conn, $positionQuery);

                    // Check if there are any results
                    if ($positionResult && mysqli_num_rows($positionResult) > 0) {
                        // Loop through each row to display position titles as options in the dropdown
                        while ($row = mysqli_fetch_assoc($positionResult)) {
                            $PositionTitle = $row['PositionTitle'];
                            echo "<option value='$PositionTitle'>$PositionTitle</option>";
                        }
                    }  
                    ?>
                </select>
            <button name="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Submit</button>
        </form>
    </div>

    <?php
if (isset($_POST['submit'])) {
    $EmployeeID = $_POST['EmployeeID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $PositionTitle = $_POST['PositionTitle'];

    // Check if the provided PositionTitle exists in the position table
    $positionCheckQuery = "SELECT PositionID FROM position WHERE PositionTitle = '$PositionTitle'";
    $positionCheckResult = mysqli_query($conn, $positionCheckQuery);

    if (mysqli_num_rows($positionCheckResult) > 0) {
        // PositionTitle exists, fetch the PositionID
        $row = mysqli_fetch_assoc($positionCheckResult);
        $PositionID = $row['PositionID'];

        // Check if the FirstName and LastName already exist in the employee table
        $nameCheckQuery = "SELECT EmployeeID FROM employee WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
        $nameCheckResult = mysqli_query($conn, $nameCheckQuery);

        if (mysqli_num_rows($nameCheckResult) > 0) {
            // Employee with the same FirstName and LastName already exists
            echo "<script>alert('Error: An employee with the same First Name and Last Name already exists.');</script>";
        } else {
            // Check if the EmployeeID already exists
            $employeeIDCheckQuery = "SELECT EmployeeID FROM employee WHERE EmployeeID = '$EmployeeID'";
            $employeeIDCheckResult = mysqli_query($conn, $employeeIDCheckQuery);

            if (mysqli_num_rows($employeeIDCheckResult) > 0) {
                // EmployeeID already exists
                echo "<script>alert('Error: An employee with the same EmployeeID already exists.');</script>";
            } else {
                // Insert the new employee with the correct PositionID
                $setQuery = "INSERT INTO `employee` (`EmployeeID`, `FirstName`, `LastName`, `PositionID`) 
                             VALUES ('$EmployeeID', '$FirstName', '$LastName', '$PositionID')";

                if (mysqli_query($conn, $setQuery)) {
                    echo "<script>alert('New record created successfully');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<script>alert('Error: " . $setQuery . "\\n" . mysqli_error($conn) . "');</script>";
                }
            }
        }
    } else {
        // PositionTitle does not exist in the position table
        echo "<script>alert('Error: The provided Position Title does not exist.');</script>";
    }
}
?>


</main>

<!-- Footer -->
<footer>
    <div class="bg-slate-700 text-center text-white py-4">
        &copy; 2024 Employee Database Management
    </div>
</footer>

<!-- Add the modal for editing employees -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4">Edit Employee</h2>
            <form id="editEmployeeForm" action="" method="post">
                <label for="editEmployeeID">Employee ID</label>
                <input type="text" id="editEmployeeID" name="editEmployeeID" required class="mb-2 p-2 border rounded w-full" readonly>
                <label for="editFirstName">First Name</label>
                <input type="text" id="editFirstName" name="editFirstName" required class="mb-2 p-2 border rounded w-full">
                <label for="editLastName">Last Name</label>
                <input type="text" id="editLastName" name="editLastName" required class="mb-2 p-2 border rounded w-full">
                <label for="PositionTitleEdit">Position Title</label>
                <select id="PositionTitleEdit" name="PositionTitleEdit" required class="mb-2 p-2 border rounded w-full">
                    <option value="" selected disabled>Select Position Title</option>
                    <!-- Assuming you fetch position titles from the database and populate the dropdown dynamically -->
                    <?php
                    // Fetch position titles from the database
                    $positionQuery = "SELECT PositionTitle FROM position";
                    $positionResult = mysqli_query($conn, $positionQuery);

                    // Check if there are any results
                    if ($positionResult && mysqli_num_rows($positionResult) > 0) {
                        // Loop through each row to display position titles as options in the dropdown
                        while ($row = mysqli_fetch_assoc($positionResult)) {
                            $PositionTitle = $row['PositionTitle'];
                            echo "<option value='$PositionTitle'>$PositionTitle</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" name="update" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Update</button>
                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update'])) {
    $editEmployeeID = $_POST['editEmployeeID'];
    $editFirstName = $_POST['editFirstName'];
    $editLastName = $_POST['editLastName'];
    $PositionTitleEdit = $_POST['PositionTitleEdit'];

    // You need to ensure that PositionTitleEdit is properly sanitized to prevent SQL injection
    $PositionTitleEdit = mysqli_real_escape_string($conn, $PositionTitleEdit);

    // Fetch the PositionID corresponding to the PositionTitleEdit from the position table
    $positionQuery = "SELECT * FROM position WHERE PositionTitle = '$PositionTitleEdit'";
    $positionResult = mysqli_query($conn, $positionQuery);

    if ($positionResult && mysqli_num_rows($positionResult) > 0) {
        $row = mysqli_fetch_assoc($positionResult);
        $PositionID = $row['PositionID'];

        // Check if the new first name and last name already exist in the database
        $checkQuery = "SELECT * FROM employee WHERE FirstName = '$editFirstName' AND LastName = '$editLastName' AND EmployeeID != '$editEmployeeID'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            echo "<script>alert('Error: First Name and Last Name already exist');</script>";
        } else {
            // Update the employee record with the new position title
            $updateQuery = "UPDATE `employee` SET `FirstName`='$editFirstName', `LastName`='$editLastName', `PositionID`='$PositionID' WHERE `EmployeeID`='$editEmployeeID';";

            if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('Record updated successfully');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "<script>alert('Error: " . $updateQuery . "\\n" . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Error: Position not found');</script>";
    }
}
?>



<script>
    function deleteEmployee(id) {
        if (confirm("Are you sure you want to delete this employee?")) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'employee.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleteEmployeeID';
            input.value = id;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function openEditModal(id, firstName, lastName, positionTitle) {
        document.getElementById('editEmployeeID').value = id;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('PositionTitleEdit').value = positionTitle;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    <?php
    if (isset($_POST['deleteEmployeeID'])) {
        $deleteEmployeeID = $_POST['deleteEmployeeID'];

        $deleteQuery = "DELETE FROM `employee` WHERE `EmployeeID`='$deleteEmployeeID';";

        if (mysqli_query($conn, $deleteQuery)) {
            echo "Record deleted successfully";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
        }
    }
    ?>
</script>

<?php
    // Function to display table data
    function getTableData($result) {
        // Check if the result is a valid mysqli_result object
        if (is_object($result) && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td class="px-6 py-4">' . $row['EmployeeID'] . '</td>';
                echo '<td class="px-6 py-4">' . $row['FirstName'] . '</td>';
                echo '<td class="px-6 py-4">' . $row['LastName'] . '</td>';
                echo '<td class="px-6 py-4">' . $row['PositionTitle'] . '</td>'; // Display PositionTitle instead of PositionID
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5" class="text-center py-4">No Records Found</td></tr>';
        }
    }

    // Close the database connection
    mysqli_close($conn);
?>


</body>
</html>