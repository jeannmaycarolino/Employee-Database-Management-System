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
<?php include('config/db.php'); ?>

<header class="shadow-lg">
    <div class="flex items-center w-full px-6 py-2 justify-between">
        <div class="flex flex-row max-sm:flex-row-reverse m-0 max-sm:w-full max-sm:justify-end">
            <div class="flex justify-center w-full">
                <!-- <img src="./assets/img/logo.png" alt="tailwind-logo" class="h-10 w-10"> -->
            </div>
            <div class="flex items-center max-sm:flex-col-reverse max-sm:items-start">
                <ul id="navigation" class="flex flex-row gap-6 px-8 text-gray-400 font-medium max-sm:hidden max-sm:flex-col max-sm:px-4 max-sm:absolute max-sm:top-14 max-sm:bg-slate-800 max-sm:w-full max-sm:left-0 max-sm:gap-1 max-sm:pb-3 max-sm:rounded-b-lg">
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="index.php"><li>Dashboard</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="employee.php"><li>Employee</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="position.php"><li>Position</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="project.php"><li>Project</li></a>
                    <a class="py-2 px-3  bg-yellow-400 rounded-md text-black" href="assignment.php"><li>Assignment</li></a>
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
    </div>
</header>

<main class="mx-10 my-5">
    <h1 class="text-primary_text text-lg font-bold">Project</h1>
    <div class="flex flex-row gap-4">
        <div class="flex flex-col gap-4 mt-2">
            <div class="flex flex-row gap-4">
                <?php
                    // Total Projects
                    $assignment = "SELECT * FROM assignment";
                    $result = mysqli_query($conn, $assignment) or die('error');

                    if ($result = mysqli_query($conn, $assignment)) {
                        $rowcount = mysqli_num_rows($result);
                        ?>
                        <div class="h-32 w-36 py-2 px-4 shadow-lg rounded-md flex flex-row items-center gap-1 hover:scale-105 hover:cursor-pointer">
                            <div class="flex flex-col">
                                <h1 class="font-medium text-secondary_text text-sm">Total Assignments</h1>
                                <span class="text-primary_text text-4xl font-bold"><?php echo $rowcount?></span>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
            <h1 class="text-secondary_text font-semibold text-md">Assignments</h1>
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-lightgray">
                    <thead class="text-xs text-primary_text uppercase bg-yellow-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Assignment ID</th>
                            <th scope="col" class="px-6 py-3">First Name</th>
                            <th scope="col" class="px-6 py-3">Last Name</th>
                            <th scope="col" class="px-6 py-3">Project Name</th>
                            <th scope="col" class="px-6 py-3">Hours Worked</th>
                            <th scope="col" class="px-6 py-3">Action</th>
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
                        $total_rows_query = "SELECT COUNT(*) as total FROM assignment";
                        $total_rows_result = mysqli_query($conn, $total_rows_query);
                        $total_rows = mysqli_fetch_assoc($total_rows_result)['total'];

                        // Calculate the total number of pages
                        $total_pages = ceil($total_rows / $limit);

                        // Fetch the paginated records
                        $assignmentQuery = "SELECT `assignment`.`AssignmentID`, `employee`.`FirstName`, `employee`.`LastName`, `project`.`ProjectName`, `assignment`.`HoursWorked`
                                            FROM `assignment` 
                                            LEFT JOIN `employee` ON `assignment`.`EmployeeID` = `employee`.`EmployeeID` 
                                            LEFT JOIN `project` ON `assignment`.`ProjectID` = `project`.`ProjectID`
                                            LIMIT $initial_page, $limit";
                        $assignmentResult = mysqli_query($conn, $assignmentQuery) or die('error');

                        // Fetch and display the table data
                        getTableData($assignmentResult);
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
                                    echo '<a href="assignment.php?page=' . $page_number . '" class="flex items-center justify-center px-3 h-8 leading-tight text-secondary_text ' . $class . ' border border-gray-600 text-black hover:bg-yellow-700 hover:text-white">' . $page_number . '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            ?>
                </nav>
        </div>
    </div>

    <!-- Form to Add Assignment -->
    <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
        <h1 class="text-secondary_text font-semibold text-md">Add Assignment</h1>
        <form id="addAssignmentForm" action="" method="post" autocomplete="off">
        <label for="AssignmentID">Assignment ID</label>
        <input type="text" name="AssignmentID" required autocomplete="off" class="mb-2 p-2 border rounded">
        <label for="FirstName">First Name</label>
        <input type="text" name="FirstName" required autocomplete="off" class="mb-2 p-2 border rounded">
        <label for="LastName">Last Name</label>
        <input type="text" name="LastName" required autocomplete="off" class="mb-2 p-2 border rounded">
        <label for="ProjectID">Project Name</label>
        <select name="ProjectID" required class="mb-2 p-2 border rounded">
            <!-- Populate project options dynamically from the database -->
            <?php
            $projectQuery = "SELECT * FROM project";
            $projectResult = mysqli_query($conn, $projectQuery) or die('error');

            while ($row = mysqli_fetch_array($projectResult)) {
                echo '<option value="' . $row['ProjectID'] . '">' . $row['ProjectName'] . '</option>';
            }
            ?>
        </select>
        <label for="HoursWorked">Hours Worked</label>
        <input type="number" name="HoursWorked" required autocomplete="off" class="mb-2 p-2 border rounded" min="1" max="8">

        <button name="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Submit</button>
        </form>


    </div>

    <?php
    if (isset($_POST['submit'])) {
        $AssignmentID = $_POST['AssignmentID'];
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $ProjectID = $_POST['ProjectID'];
        $HoursWorked = $_POST['HoursWorked'];

        // Check if AssignmentID already exists
        $checkQuery = "SELECT * FROM `assignment` WHERE `AssignmentID`='$AssignmentID'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Display script alert for duplicate AssignmentID
            echo "<script>alert('Duplicate AssignmentID. Please choose a different AssignmentID.');</script>";
        } else {
            // Fetch EmployeeID based on First Name and Last Name
            $employeeQuery = "SELECT EmployeeID FROM employee WHERE FirstName='$FirstName' AND LastName='$LastName'";
            $employeeResult = mysqli_query($conn, $employeeQuery) or die('error');

            if (mysqli_num_rows($employeeResult) > 0) {
                $row = mysqli_fetch_assoc($employeeResult);
                $EmployeeID = $row['EmployeeID'];

                // Insert new record into the assignment table
                $setQuery = "INSERT INTO `assignment` (`AssignmentID`, `EmployeeID`, `ProjectID`, `HoursWorked`) VALUES ('$AssignmentID', '$EmployeeID', '$ProjectID', '$HoursWorked');";

                if (mysqli_query($conn, $setQuery)) {
                    echo "<script>alert('New record created successfully');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "Error: " . $setQuery . "<br>" . mysqli_error($conn);
                }
            } else {
                // Display script alert if employee not found
                echo "<script>alert('Employee not found. Please check first name and last name.');</script>";
            }
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

<!-- Add the modal for editing assignments -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4">Edit Assignment</h2>
            <form id="assignmentFormEdit" action="" method="post" onsubmit="return validateHoursWorked()">
            <label for="assignmentIDEdit">Assignment ID</label>
            <input type="text" id="assignmentIDEdit" name="assignmentIDEdit" required class="mb-2 p-2 border rounded w-full" readonly>
            <label for="editFirstName">First Name</label>
            <input type="text" id="editFirstName" name="editFirstName" required class="mb-2 p-2 border rounded w-full">
            <label for="editLastName">Last Name</label>
            <input type="text" id="editLastName" name="editLastName" required class="mb-2 p-2 border rounded w-full">
            <label for="projectNameEdit">Project Name</label>
            <select id="projectNameEdit" name="projectNameEdit" required class="mb-2 p-2 border rounded w-full">
                <option value="" selected disabled>Select Project Name</option>
                <!-- Assuming you fetch project names from the database and populate the dropdown dynamically -->
                <?php
                // Fetch project names from the database
                $projectQuery = "SELECT ProjectName FROM project";
                $projectResult = mysqli_query($conn, $projectQuery);

                // Check if there are any results
                if ($projectResult && mysqli_num_rows($projectResult) > 0) {
                    // Loop through each row to display project names as options in the dropdown
                    while ($row = mysqli_fetch_assoc($projectResult)) {
                        $ProjectName = $row['ProjectName'];
                        echo "<option value='$ProjectName'>$ProjectName</option>";
                    }
                }
                ?>
            </select>
            <label for="hoursWorkedEdit">Hours Worked</label>
            <input type="number" id="hoursWorkedEdit" name="hoursWorkedEdit" required class="mb-2 p-2 border rounded w-full" min="1" max="8">

            <button type="submit" name="update" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Update</button>
            <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded" onclick="closeEditModal()">Cancel</button>
        </form>
        <script>
            function validateHoursWorked() {
                var hoursWorkedEdit = document.getElementById("hoursWorkedEdit").value;
                if (hoursWorkedEdit > 8) {
                    alert("Hours Worked should not exceed 8.");
                    return false;
                }
                return true;
            }
        </script>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update'])) {
    $assignmentIDEdit = $_POST['assignmentIDEdit'];
    $editFirstName = $_POST['editFirstName'];
    $editLastName = $_POST['editLastName'];
    $projectNameEdit = $_POST['projectNameEdit'];
    $hoursWorkedEdit = $_POST['hoursWorkedEdit'];

    // Retrieve EmployeeID based on First Name and Last Name
    $employeeQuery = "SELECT EmployeeID FROM employee WHERE FirstName='$editFirstName' AND LastName='$editLastName'";
    $employeeResult = mysqli_query($conn, $employeeQuery);

    if ($employeeResult && mysqli_num_rows($employeeResult) > 0) {
        $employeeRow = mysqli_fetch_assoc($employeeResult);
        $employeeIDEdit = $employeeRow['EmployeeID'];

        // Retrieve ProjectID based on Project Name
        $projectQuery = "SELECT ProjectID FROM project WHERE ProjectName='$projectNameEdit'";
        $projectResult = mysqli_query($conn, $projectQuery);

        if ($projectResult && mysqli_num_rows($projectResult) > 0) {
            $projectRow = mysqli_fetch_assoc($projectResult);
            $projectIDEdit = $projectRow['ProjectID'];

            // Update the assignment record
            $updateQuery = "UPDATE `assignment` SET `EmployeeID`='$employeeIDEdit', `ProjectID`='$projectIDEdit', `HoursWorked`='$hoursWorkedEdit' WHERE `AssignmentID`='$assignmentIDEdit';";

            if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('Record updated successfully');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: Project not found<br>";
        }
    } else {
        echo "<script>alert('Employee not found');</script>";
    }
}
?>



<script>
    function deleteAssignment(AssignmentID) {
        if (confirm("Are you sure you want to delete this assignment?")) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'assignment.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleteAssignmentID';
            input.value = AssignmentID;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function openEditModal(AssignmentID, firstName, lastName, ProjectName, HoursWorked) {
        document.getElementById('assignmentIDEdit').value = AssignmentID;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('projectNameEdit').value = ProjectName;
        document.getElementById('hoursWorkedEdit').value = HoursWorked;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    <?php
    if (isset($_POST['deleteAssignmentID'])) {
        $deleteAssignmentID = $_POST['deleteAssignmentID'];

        $deleteQuery = "DELETE FROM `assignment` WHERE `AssignmentID`='$deleteAssignmentID';";

        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Record deleted successfully');</script>";
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
                echo '<td class="px-6 py-4">' . $row['AssignmentID'] . '</td>';
                echo '<td class="px-6 py-4">' . $row['FirstName'] . '</td>';
                echo '<td class="px-6 py-4">' . $row['LastName'] . '</td>';
                echo '<td class="px-6 py-4">' . $row['ProjectName'] . '</td>'; 
                echo '<td class="px-6 py-4">' . $row['HoursWorked'] . '</td>';    

                echo '<td class="px-6 py-4 flex gap-2">';
                echo '<button class="bg-green-400 hover:bg-green-500 text-black font-semibold py-1 px-2 rounded" onclick="openEditModal(\'' . $row['AssignmentID'] . '\', \'' . $row['FirstName'] . '\', \'' . $row['LastName'] . '\', \'' . $row['ProjectName'] . '\',\'' . $row['HoursWorked'] . '\')">Edit</button>';
                echo '<button class="bg-red-400 hover:bg-red-500 text-white font-semibold py-1 px-2 rounded" onclick="deleteAssignment(\'' . $row['AssignmentID'] . '\')">Delete</button>';
                echo '</td>';
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
