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
               
            </div>
            <div class="flex items-center max-sm:flex-col-reverse max-sm:items-start">
                <ul id="navigation" class="flex flex-row gap-6 px-8 text-gray-400 font-medium max-sm:hidden max-sm:flex-col max-sm:px-4 max-sm:absolute max-sm:top-14 max-sm:bg-slate-800 max-sm:w-full max-sm:left-0 max-sm:gap-1 max-sm:pb-3 max-sm:rounded-b-lg">
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="index.php"><li>Dashboard</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="employee.php"><li>Employee</li></a>
                    <a class="py-2 px-3  bg-yellow-400 rounded-md text-black" href="position.php"><li>Position</li></a>
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
    <h1 class="text-primary_text text-lg font-bold">Positions</h1>
    <div class="flex flex-row gap-4">
        <div class="flex flex-col gap-4 mt-2">
            <div class="flex flex-row gap-4">
                <?php
                    // Total Employees
                    $position = "SELECT * FROM position";
                    $result = mysqli_query($conn, $position) or die('error');

                    if ($result = mysqli_query($conn, $position)) {
                        $rowcount = mysqli_num_rows($result);
                        ?>
                        <div class="h-32 w-36 py-2 px-4 shadow-lg rounded-md flex flex-row items-center gap-1 hover:scale-105 hover:cursor-pointer">
                            <div class="flex flex-col">
                                <h1 class="font-medium text-secondary_text text-sm">Total Positions</h1>
                                <span class="text-primary_text text-4xl font-bold"><?php echo $rowcount?></span>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
            <h1 class="text-secondary_text font-semibold text-md">Positions</h1>
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-lightgray">
                    <thead class="text-xs text-primary_text uppercase bg-yellow-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Position ID</th>
                            <th scope="col" class="px-6 py-3">Position Title</th>
                            <th scope="col" class="px-6 py-3">Salary</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $limit = 8;
                            $position = "SELECT * FROM position";
                            $result = mysqli_query($conn, $position) or die('error');

                            $total_rows = mysqli_num_rows($result);
                            $total_pages = ceil($total_rows / $limit);
                            if (!isset($_GET['page'])) {
                                $page_number = 1;
                            } else {
                                $page_number = $_GET['page'];
                            }
                            $current_page = $page_number;
                            $initial_page = ($page_number - 1) * $limit;
                            $position = "SELECT * FROM position LIMIT $initial_page, $limit;";
                           
                            getTableData($position);
                        ?>
                    </tbody>
                </table>
            </div>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                <?php
                    echo '<span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900 dark:text-white">1-'.$limit.'</span> of <span class="font-semibold text-gray-900 dark:text-white">'.$total_pages.'</span></span>';
                    
                    echo '<ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">';
                    for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
                        $class = ($page_number == $current_page) ? "bg-yellow-600" : "bg-yellow-700";
                        echo '<li>';
                        echo '<a href="position.php?page=' . $page_number . '" class="flex items-center justify-center px-3 h-8 leading-tight text-secondary_text ' . $class . ' border border-gray-600 text-black hover:bg-yellow-700 hover:text-white">' . $page_number . '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                ?>
            </nav>
        </div>
    </div>

    <!-- Form to Add Employee -->
    <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
        <h1 class="text-secondary_text font-semibold text-md">Add Position</h1>
        <form id="addPositionForm" action="" method="post" autocomplete="off">
            <label for="PositionID">Position ID</label>
            <input type="text" name="PositionID" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="PositionTitle">Position Title</label>
            <input type="text" name="PositionTitle" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="Salary">Salary</label>
            <input type="text" name="Salary" required autocomplete="off" class="mb-2 p-2 border rounded">
            <button name="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Submit</button>
        </form>
    </div>

<?php
if (isset($_POST['submit'])) {
    $PositionID = $_POST['PositionID'];
    $PositionTitle = $_POST['PositionTitle'];
    $Salary = $_POST['Salary'];

    // Check if the Position ID already exists in the database
    $checkPositionIDQuery = "SELECT * FROM `position` WHERE `PositionID` = '$PositionID'";
    $checkPositionIDResult = mysqli_query($conn, $checkPositionIDQuery);

    if ($checkPositionIDResult && mysqli_num_rows($checkPositionIDResult) > 0) {
        echo "<script>alert('Error: Position ID already exists');</script>";
    } else {
        // Check if the Position Title already exists in the database
        $checkPositionTitleQuery = "SELECT * FROM `position` WHERE `PositionTitle` = '$PositionTitle'";
        $checkPositionTitleResult = mysqli_query($conn, $checkPositionTitleQuery);

        if ($checkPositionTitleResult && mysqli_num_rows($checkPositionTitleResult) > 0) {
            echo "<script>alert('Error: Position Title already exists');</script>";
        } else {
            // Check if Salary is not 0 and is a valid number
            if ($Salary <= 0 || !is_numeric($Salary)) {
                echo "<script>alert('Error: Salary should be a non-zero number');</script>";
            } else {
                // Insert new record into the position table
                $setQuery = "INSERT INTO `position` (`PositionID`, `PositionTitle`, `Salary`) VALUES ('$PositionID', '$PositionTitle', '$Salary');";

                if (mysqli_query($conn, $setQuery)) {
                    echo "<script>alert('New record created successfully');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<script>alert('Error: " . $setQuery . "\\n" . mysqli_error($conn) . "');</script>";
                }
            }
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

<!-- Add the modal for editing positions -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4">Edit Position</h2>
            <form id="positionFormEdit" action="" method="post">
                <label for="PositionIDEdit">Position ID</label>
                <input type="text" id="PositionIDEdit" name="PositionIDEdit" readonly required class="mb-2 p-2 border rounded w-full">
                <label for="PositionTitleEdit">Position Title</label>
                <input type="text" id="PositionTitleEdit" name="PositionTitleEdit" required class="mb-2 p-2 border rounded w-full">
                <label for="SalaryEdit">Salary</label>
                <input type="text" id="SalaryEdit" name="SalaryEdit" required class="mb-2 p-2 border rounded w-full">
                <button type="submit" name="update" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Update</button>
                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>


<?php
if (isset($_POST['update'])) {
    $PositionIDEdit = $_POST['PositionIDEdit'];
    $PositionTitleEdit = $_POST['PositionTitleEdit'];
    $SalaryEdit = $_POST['SalaryEdit'];

    // Check if the edited Position Title already exists in the database
    $checkPositionTitleQuery = "SELECT * FROM `position` WHERE `PositionTitle` = '$PositionTitleEdit' AND `PositionID` != '$PositionIDEdit'";
    $checkPositionTitleResult = mysqli_query($conn, $checkPositionTitleQuery);

    if ($checkPositionTitleResult && mysqli_num_rows($checkPositionTitleResult) > 0) {
        echo "<script>alert('Error: Position Title already exists');</script>";
    } else {
        // Check if Salary is not 0 and is a valid number
        if ($SalaryEdit <= 0 || !is_numeric($SalaryEdit)) {
            echo "<script>alert('Error: Salary should be a non-zero number');</script>";
        } else {
            // Update the position record
            $updateQuery = "UPDATE `position` SET `PositionTitle`='$PositionTitleEdit', `Salary`='$SalaryEdit' WHERE `PositionID`='$PositionIDEdit';";

            if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('Record updated successfully');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "<script>alert('Error: " . $updateQuery . "\\n" . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>




<script>
    function deletePosition(PositionID) {
        if (confirm("Are you sure you want to delete this employee?")) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'position.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deletePositionID';
            input.value = PositionID;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function openEditModal(PositionID, PositionTitle, Salary) {
        document.getElementById('PositionIDEdit').value = PositionID;
        document.getElementById('PositionTitleEdit').value = PositionTitle;
        document.getElementById('SalaryEdit').value = Salary;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    <?php
    if (isset($_POST['deletePositionID'])) {
        $deletePositionID = $_POST['deletePositionID']; // Correct variable name

        $deleteQuery = "DELETE FROM `position` WHERE `PositionID`='$deletePositionID';";

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
function getTableData($position) {
    global $conn;
    $result = mysqli_query($conn, $position) or die('error');

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td class="px-6 py-4">' . $row['PositionID'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['PositionTitle'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['Salary'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center py-4">No Records Found</td></tr>';
    }
}
?>
</body>
</html>
