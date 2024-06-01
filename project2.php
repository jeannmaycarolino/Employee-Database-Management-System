<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tailwind config -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include('config/db.php'); ?>
<table><thead><tr><th>Project ID</th><th>Project Name</th><th>Start Date</th><th>End Date</th></tr><thead>
    <tbody>
    <?php
    // Function to convert date format from Y-m-d to M/D/YYYY
    function convertDateFormat($date) {
        // First, check if the date is in Y-m-d format
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        if ($dateTime !== false) {
            return $dateTime->format('n/j/Y');
        }
        
        // If not, check if it's already in M/D/YYYY format
        $dateTime = DateTime::createFromFormat('n/j/Y', $date);
        if ($dateTime !== false) {
            return $dateTime->format('n/j/Y');
        }
        
        // If neither format is valid, return an error message or handle it appropriately
        return "Invalid date";
    }

    // Your database query
    $project = "SELECT * FROM project";
    $result = mysqli_query($conn, $project) or die('error');

    // Fetch and display the data
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            // Convert the date formats
            $startDate = convertDateFormat($row['StartDate']);
            $endDate = convertDateFormat($row['EndDate']);
            
            // Display the data in the table row
            echo '<tr><th>' .$row['ProjectID'].'</th><td>' .$row['ProjectName'].'</td><td >'.$row['StartDate'].'</td><td >'.$row['EndDate'].'</td> <td> <a href=" " onclick="showEditModal(event, \''.$row['ProjectID'].'\', \''.$row['ProjectName'].'\', \''.$row['StartDate'].'\', \''.$row['EndDate'].'\')">Edit </a> <a href="project.php?deleteid='.$row['ProjectID'].'">Delete </a> </td> </tr> ';
        }
    }
    ?>
    </tbody></table>

    <?php 
    include('config/db.php');

    if (isset($_GET['deleteid'])) {
        $id = $_GET['deleteid'];
        $delete = mysqli_query($conn, "DELETE FROM project WHERE ProjectID = '$id'");
        if ($delete) {
            echo "Project deleted successfully.";
        } else {
            echo "Error deleting position: " . mysqli_error($conn);
        }
    }
    ?>

    <!-- Rest of your code to display positions -->


    <form action="" method="post" autocomplete="off">
        <label for="">Project ID</label>
        <input type="text" name="ProjectID" required value="" autocomplete="off">
        <label for="">Project Name</label>
        <input type="text" name="ProjectName" required value="" autocomplete="off">
        <label for="">Start Date</label>
        <input type="date" name="StartDate" required value="" autocomplete="off">
        <label for="">End Date</label>
        <input type="date" name="EndDate" required value="" autocomplete="off">
        <button name="submit">Submit</button>
    </form>
    <!-- to Add Employee -->
    <?php
        include('config/db.php');
        if (isset($_POST['submit'])) {
            // Get form data
            // palitan mo yung mga column titles niyo
            $ProjectID = $_POST['ProjectID'];
            $ProjectName = $_POST['ProjectName'];
            $StartDate = $_POST['StartDate'];
            $EndDate = $_POST['EndDate'];

            // Insert into database
            $setQuery = "INSERT INTO `project` (`ProjectID`, `ProjectName`, `StartDate`, `EndDate`) VALUES ('$ProjectID', '$ProjectName', '$StartDate', '$EndDate');";
            if (mysqli_query($conn, $setQuery)) {
                echo '<script>alert("Added successfully!");</script>';
            } else {
                echo '<script>alert("Error: ' . $setQuery . '<br>' . mysqli_error($conn) . '");</script>';
            }
        }
    ?>
    <form id="projectFormEdit" method="post" autocomplete="off" class="hidden" action="update.php">
        <label for="projectIDEdit">Project ID</label>
        <input id="projectIDEdit" type="text" name="projectIDEdit" required value="" autocomplete="off">
        <label for="projectNameEdit">Project Name</label>
        <input id="projectNameEdit" type="text" name="projectNameEdit" required value="" autocomplete="off">
        <label for="startDateEdit">Start Date</label>
        <input id="startDateEdit" type="date" name="startDateEdit" required value="" autocomplete="off">
        <label for="endDateEdit">End Date</label>
        <input id="endDateEdit" type="date" name="endDateEdit" required value="" autocomplete="off">
        <button name="project_submit">Submit</button>
    </form>

    <!-- Script to show editing form -->
    <script>
        function showEditModal(event, ProjectID, ProjectName, StartDate, EndDate) {
            event.preventDefault();
            document.getElementById('projectIDEdit').value = ProjectID;
            document.getElementById('projectNameEdit').value = ProjectName;
            document.getElementById('startDateEdit').value = StartDate;
            document.getElementById('endDateEdit').value = EndDate;
            document.getElementById('projectFormEdit').classList.remove('hidden');
        }

        function hideEditModal() {
            document.getElementById('projectFormEdit').classList.add('hidden');
        }
    </script>
</body>
</html>