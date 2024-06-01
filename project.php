<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tailwind config -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
                    <a class="py-2 px-3 bg-yellow-400 rounded-md text-black" href="project.php"><li>Project</li></a>
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
    </div>
</header>

<main class="mx-10 my-5">
    <h1 class="text-primary_text text-lg font-bold">Project</h1>
    <div class="flex flex-row gap-4">
        <div class="flex flex-col gap-4 mt-2">
            <div class="flex flex-row gap-4">
                <?php
                    // Total Projects
                    $project = "SELECT * FROM project";
                    $result = mysqli_query($conn, $project) or die('error');

                    if ($result = mysqli_query($conn, $project)) {
                        $rowcount = mysqli_num_rows($result);
                        ?>
                        <div class="h-32 w-36 py-2 px-4 shadow-lg rounded-md flex flex-row items-center gap-1 hover:scale-105 hover:cursor-pointer">
                            <div class="flex flex-col">
                                <h1 class="font-medium text-secondary_text text-sm">Total Projects</h1>
                                <span class="text-primary_text text-4xl font-bold"><?php echo $rowcount?></span>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
<?php
include('config/db.php');

// Fetch all projects
$projectQuery = "SELECT * FROM project";
$result = mysqli_query($conn, $projectQuery) or die('Error querying database.');

// Initialize counters
$doneCount = 0;
$inProgressCount = 0;

// Get current date
$currentDate = new DateTime();

while ($row = mysqli_fetch_assoc($result)) {
    $startDate = $row['StartDate'];
    $endDate = $row['EndDate'];
    
    // Convert StartDate and EndDate to DateTime objects
    $startDateObject = DateTime::createFromFormat('m/d/Y', $startDate);
    $endDateObject = DateTime::createFromFormat('m/d/Y', $endDate);

    // Debugging output
    //echo "StartDate: $startDate, EndDate: $endDate<br>";
    //echo "StartDateObject: " . ($startDateObject ? $startDateObject->format('Y-m-d H:i:s') : 'Invalid') . ", EndDateObject: " . ($endDateObject ? $endDateObject->format('Y-m-d H:i:s') : 'Invalid') . "<br>";
    //echo "CurrentDate: " . $currentDate->format('Y-m-d H:i:s') . "<br>";

    if ($endDateObject !== false && $endDateObject <= $currentDate) {
        // If endDate is not empty and endDate is less than or equal to the current date
        $doneCount++;
    } else {
        // If startDate is not empty, startDate is less than or equal to the current date, and endDate is greater than the current date or not set
        $inProgressCount++;
    }
}

// Prepare data for the chart
$chartData = [
    'done' => $doneCount,
    'inProgress' => $inProgressCount
];
?>

        <!-- Radial Chart -->
            <div class="py-6" id="radial-chart"></div>
            <script type="text/javascript">
    const chartData = <?php echo json_encode($chartData); ?>;
    
    const getChartOptions = () => {
      const totalProjects = chartData.done + chartData.inProgress;

      return {
        series: [chartData.done, chartData.inProgress],
        colors: ["#1C64F2", "#16BDCA"],
        chart: {
          height: "380px",
          width: "100%",
          type: "radialBar",
          sparkline: {
            enabled: true,
          },
        },
        plotOptions: {
          radialBar: {
            track: {
              background: '#E5E7EB',
              startAngle: -135,
              endAngle: 135,
            },
            dataLabels: {
              show: true,
              name: {
                offsetY: -10,
                show: true,
                color: '#888',
                fontSize: '17px'
              },
              value: {
                formatter: function(val) {
                  return parseInt(val);
                },
                color: '#111',
                fontSize: '36px',
                show: true,
              }
            },
            hollow: {
              margin: 0,
              size: "32%",
              background: 'transparent',
            },
            track: {
              show: true,
              startAngle: undefined,
              endAngle: undefined,
              background: '#f2f2f2',
              strokeWidth: '97%',
              opacity: 1,
              margin: 5, // margin is in pixels
              dropShadow: {
                enabled: false,
                top: 2,
                left: 0,
                blur: 4,
                opacity: 0.15
              }
            }
          }
        },
        labels: ["Done", "In progress"],
        legend: {
          show: true,
          position: "bottom",
          fontFamily: "Inter, sans-serif",
        },
        tooltip: {
          enabled: true,
          x: {
            show: false,
          },
          y: {
            formatter: function(value) {
              return value + " projects";
            }
          }
        }
      }
    }

    if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
      const chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions());
      chart.render();
    }
</script>


        </div>
        <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
            <h1 class="text-secondary_text font-semibold text-md">Projects</h1>
            
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-lightgray">
                    <thead class="text-xs text-primary_text uppercase bg-yellow-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Project ID</th>
                            <th scope="col" class="px-6 py-3">Project Name</th>
                            <th scope="col" class="px-6 py-3">Start Date</th>
                            <th scope="col" class="px-6 py-3">End Date</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $limit = 8;
                            $project = "SELECT * FROM project";
                            $result = mysqli_query($conn, $project) or die('error');

                            $total_rows = mysqli_num_rows($result);
                            $total_pages = ceil($total_rows / $limit);
                            if (!isset($_GET['page'])) {
                                $page_number = 1;
                            } else {
                                $page_number = $_GET['page'];
                            }
                            $current_page = $page_number;
                            $initial_page = ($page_number - 1) * $limit;
                            $project = "SELECT * FROM project LIMIT $initial_page, $limit;";
                           
                            getTableData($project);
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
                        echo '<a href="project.php?page=' . $page_number . '" class="flex items-center justify-center px-3 h-8 leading-tight text-secondary_text ' . $class . ' border border-gray-600 text-black hover:bg-yellow-700 hover:text-white">' . $page_number . '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                ?>
            </nav>
        </div>
    </div>

    <!-- Form to Add Employee -->
    <div class="w-full mt-2 p-4 shadow-lg rounded-md flex flex-col gap-4">
        <h1 class="text-secondary_text font-semibold text-md">Add Project</h1>
        <form id="addProjectForm" action="" method="post" autocomplete="off">
            <label for="ProjectID">Project ID</label>
            <input type="text" name="ProjectID" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="ProjectName">Project Name</label>
            <input type="text" name="ProjectName" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="StartDate">Start Date</label>
            <input type="date" name="StartDate" required autocomplete="off" class="mb-2 p-2 border rounded">
            <label for="EndDate">End Date</label>
            <input type="date" name="EndDate" required autocomplete="off" class="mb-2 p-2 border rounded">

            <button name="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Submit</button>
        </form>
    </div>

    <?php
if (isset($_POST['submit'])) {
    $ProjectID = $_POST['ProjectID'];
    $ProjectName = $_POST['ProjectName'];
    $StartDate = $_POST['StartDate'];
    $EndDate = $_POST['EndDate'];

    // Check if Start Date is after End Date
    if ($StartDate > $EndDate) {
        echo "<script>alert('Error: Start Date cannot be after End Date');</script>";
    } else {
        // Check if End Date is before Start Date
        if ($EndDate < $StartDate) {
            echo "<script>alert('Error: End Date cannot be before Start Date');</script>";
        } else {
            // Check if the Project ID already exists in the database
            $checkProjectIDQuery = "SELECT * FROM `project` WHERE `ProjectID` = '$ProjectID'";
            $checkProjectIDResult = mysqli_query($conn, $checkProjectIDQuery);

            if ($checkProjectIDResult && mysqli_num_rows($checkProjectIDResult) > 0) {
                echo "<script>alert('Error: Project ID already exists');</script>";
            } else {
                // Check if the Project Name already exists in the database
                $checkProjectNameQuery = "SELECT * FROM `project` WHERE `ProjectName` = '$ProjectName'";
                $checkProjectNameResult = mysqli_query($conn, $checkProjectNameQuery);

                if ($checkProjectNameResult && mysqli_num_rows($checkProjectNameResult) > 0) {
                    echo "<script>alert('Error: Project Name already exists');</script>";
                } else {
                    // Insert new record into the project table
                    $setQuery = "INSERT INTO `project` (`ProjectID`, `ProjectName`, `StartDate`, `EndDate`) VALUES ('$ProjectID', '$ProjectName', '$StartDate', '$EndDate');";

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
            <h2 class="text-lg font-semibold mb-4">Edit Project</h2>
            <form id="projectFormEdit" action="" method="post">
                <label for="projectIDEdit">Project ID</label>
                <input type="text" id="projectIDEdit" name="projectIDEdit" readonly required class="mb-2 p-2 border rounded w-full">
                <label for="projectNameEdit">Project Name</label>
                <input type="text" id="projectNameEdit" name="projectNameEdit" required class="mb-2 p-2 border rounded w-full">
                <label for="startDateEdit">Start Date</label>
                <input type="date" id="startDateEdit" name="startDateEdit" required class="mb-2 p-2 border rounded w-full">
                <label for="endDateEdit">End Date</label>
                <input type="date" id="endDateEdit" name="endDateEdit" required class="mb-2 p-2 border rounded w-full">
                <button type="submit" name="update" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">Update</button>
                <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>


<?php
if (isset($_POST['update'])) {
    $projectIDEdit = $_POST['projectIDEdit'];
    $projectNameEdit = $_POST['projectNameEdit'];
    $startDateEdit = $_POST['startDateEdit'];
    $endDateEdit = $_POST['endDateEdit'];

    // Check if the edited Project Name already exists in the database, excluding the current project being edited
    $checkProjectNameQuery = "SELECT * FROM `project` WHERE `ProjectName` = '$projectNameEdit' AND `ProjectID` != '$projectIDEdit'";
    $checkProjectNameResult = mysqli_query($conn, $checkProjectNameQuery);

    if ($checkProjectNameResult && mysqli_num_rows($checkProjectNameResult) > 0) {
        echo "<script>alert('Error: Project Name already exists');</script>";
    } else {
        // Check if Start Date is after End Date
        if ($startDateEdit > $endDateEdit) {
            echo "<script>alert('Error: Start Date cannot be after End Date');</script>";
        } else {
            // Update the project record
            $updateQuery = "UPDATE `project` SET `ProjectName`='$projectNameEdit', `StartDate`='$startDateEdit', `EndDate`='$endDateEdit' WHERE `ProjectID`='$projectIDEdit';";

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
    function deleteProject(ProjectID) {
        if (confirm("Are you sure you want to delete this employee?")) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'project.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleteProjectID';
            input.value = ProjectID;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function openEditModal(ProjectID, ProjectName, StartDate, EndDate) {
        document.getElementById('projectIDEdit').value = ProjectID;
        document.getElementById('projectNameEdit').value = ProjectName;

        // Format the dates to mm/dd/yyyy for input fields
        const formattedStartDate = new Date(StartDate).toLocaleDateString('en-US', { year: 'numeric', month: 'numeric', day: 'numeric' });
        const formattedEndDate = new Date(EndDate).toLocaleDateString('en-US', { year: 'numeric', month: 'numeric', day: 'numeric' });

        document.getElementById('startDateEdit').value = formattedStartDate;
        document.getElementById('endDateEdit').value = formattedEndDate;

        document.getElementById('editModal').classList.remove('hidden');
    }


    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    

    <?php
    if (isset($_POST['deleteProjectID'])) {
        $deleteProjectID = $_POST['deleteProjectID']; // Correct variable name

        $deleteQuery = "DELETE FROM `project` WHERE `ProjectID`='$deleteProjectID';";

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
function getTableData($project) {
    global $conn;
    $result = mysqli_query($conn, $project) or die('error');

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $startDate = new DateTime($row['StartDate']);
            $formattedStartDate = $startDate->format('n/j/Y');
            $endDate = new DateTime($row['EndDate']);
            $formattedEndDate = $endDate->format('n/j/Y');

            echo '<tr>';
            echo '<td class="px-6 py-4">' . $row['ProjectID'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['ProjectName'] . '</td>';
            echo '<td class="px-6 py-4">' . $formattedStartDate . '</td>';
            echo '<td class="px-6 py-4">' . $formattedEndDate . '</td>';
            echo '<td class="px-6 py-4 flex gap-2">';
            echo '<button class="bg-green-400 hover:bg-green-500 text-black font-semibold py-1 px-2 rounded" onclick="openEditModal(\'' . $row['ProjectID'] . '\', \'' . $row['ProjectName'] . '\', \'' . $formattedStartDate .'\', \'' . $formattedEndDate .'\')">Edit</button>';
            echo '<button class="bg-red-400 hover:bg-red-500 text-white font-semibold py-1 px-2 rounded" onclick="deleteProject(\'' . $row['ProjectID'] . '\')">Delete</button>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center py-4">No Records Found</td></tr>';
    }
}
?>
</body>
</html>
