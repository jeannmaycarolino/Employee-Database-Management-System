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
<?php include('../config/db.php'); ?>

<header class="shadow-lg">
    <div class="flex items-center w-full px-6 py-2 justify-between">
        <div class="flex flex-row max-sm:flex-row-reverse m-0 max-sm:w-full max-sm:justify-end">
            <div class="flex justify-center w-full">
                <!-- <img src="./assets/img/logo.png" alt="tailwind-logo" class="h-10 w-10"> -->
            </div>
            <div class="flex items-center max-sm:flex-col-reverse max-sm:items-start">
                <ul id="navigation" class="flex flex-row gap-6 px-8 text-gray-400 font-medium max-sm:hidden max-sm:flex-col max-sm:px-4 max-sm:absolute max-sm:top-14 max-sm:bg-slate-800 max-sm:w-full max-sm:left-0 max-sm:gap-1 max-sm:pb-3 max-sm:rounded-b-lg">
                    <a class="py-2 px-3 bg-yellow-400 rounded-md text-black" href="index.php"><li>Dashboard</li></a>
                    <a class="py-2 px-3 rounded-md hover:bg-slate-400 hover:text-black" href="employee.php"><li>Employee</li></a>
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
<div class="flex flex-row gap-4 items-left">
    <div class="flex flex-col gap-4">
        <div class="ml-16 flex flex-col gap-2">
            <div class="flex flex-row gap-2">
                <div class="flex flex-col gap-2 mt-2">
                    <div class="flex flex-row gap-2 w-[200px]">
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
            
                <div class="flex flex-col gap-4 mt-2">
                    <div class="flex flex-row gap-4 w-[200px]">
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
            </div>
            <div class="flex flex-row gap-2">
                <div class="flex flex-col gap-4 mt-2">
                    <div class="flex flex-row gap-4 w-[200px]">
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
                </div>
                
                <div class="flex flex-col gap-4 mt-2">
                    <div class="flex flex-row gap-4 w-[200px]">
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
            </div>
        </div>

        <div class="ml-20 flex flex-col gap-3">
            <h5 class="text-xl text-center font-bold leading-none text-gray-900 dark:text-white pe-1">Your team's progress</h5>
            <?php
                include('../config/db.php');

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
        </div>
    </div>
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
    <table class="w-full mr-20 mt-3 ml-20 text-sm text-left rtl:text-right text-lightgray">
                    <thead class="text-xs text-primary_text uppercase bg-yellow-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Project Name</th>
                            <th scope="col" class="px-6 py-3">Start Date</th>
                            <th scope="col" class="px-6 py-3">End Date</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $limit = 7;
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
 
<!-- Footer -->
<footer class="w-full absolute bottom-0 bg-slate-700 text-center text-white py-4">
    &copy; 2024 Employee Database Management
</footer>

</body>
</html>

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
            
            $currentDate = new DateTime();
            $startDate = $row['StartDate'];
            $endDate = $row['EndDate'];
                

            // Convert StartDate and EndDate to DateTime objects
            $startDateObject = DateTime::createFromFormat('m/d/Y', $startDate);
            $endDateObject = DateTime::createFromFormat('m/d/Y', $endDate);

            if ($endDateObject !== false && $endDateObject <= $currentDate) {
                // If endDate is not empty and endDate is less than or equal to the current date
                $text = "Done";
                $class = "text-green-400";
            } else { 
                // If startDate is not empty, startDate is less than or equal to the current date, and endDate is greater than the current date or not set
              $text = "In Progress";
              $class = "text-red-500";

            }
            echo '<tr>';
            echo '<td class="px-6 py-4">' . $row['ProjectName'] . '</td>';
            echo '<td class="px-6 py-4">' . $formattedStartDate . '</td>';
            echo '<td class="px-6 py-4">' . $formattedEndDate . '</td>';
            echo '<td class="px-6 py-4 '.$class.'" >' . $text. '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center py-4">No Records Found</td></tr>';
    }
}
?>
