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
<table><thead><tr>
        <th>Employee ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Position ID</th>
        <th>Action</th>
        </tr><thead>
    <tbody>
    <?php
    $employee = "SELECT *
    FROM employee";
    $result = mysqli_query($conn, $employee) or die('error'); //pag connect page to php 

    if ($result = mysqli_query($conn, $employee)) { //pagkuha
        while ($row = mysqli_fetch_array($result) ) { //iterate
            // Display
            echo '<tr><th>' .$row['EmployeeID'].'</th><td>' .$row['FirstName'].'</td><td >'.$row['LastName'].'</td><td >'.$row['PositionID'].'</td> <td> <a href=" " onclick="showEditModal(event, \''.$row['EmployeeID'].'\', \''.$row['FirstName'].'\', \''.$row['LastName'].'\', \''.$row['PositionID'].'\')">Edit </a> <a href="employee.php?deleteid=' .$row['EmployeeID'].'">Delete </a> </td> </tr> ';
        }
    }
    ?> 
    </tbody></table>

    <!-- To delete a certain book -->
    <?php 
    include('config/db.php');

    if (isset($_GET['deleteid'])) {
        $id = $_GET['deleteid'];
        $delete = mysqli_query($conn, "DELETE FROM employee WHERE EmployeeID = '$id'");
        if ($delete) {
            echo "Employee deleted successfully.";
        } else {
            echo "Error deleting position: " . mysqli_error($conn);
        }
    }
    ?>

    <!-- Rest of your code to display positions -->



    <form action="" method="post" autocomplete="off">
        <label for="">Employee ID</label>
        <input type="text" name="EmployeeID" required value="" autocomplete="off">
        <label for="">First Name</label>
        <input type="text" name="FirstName" required value="" autocomplete="off">
        <label for="">Last Name</label>
        <input type="text" name="LastName" required value="" autocomplete="off">
        <label for="">Position ID</label>
        <input type="text" name="PositionID" required value="" autocomplete="off">
        <button name="submit">Submit</button>
    </form>
    <!-- to Add Employee -->
    <?php
        include('config/db.php');
        if (isset($_POST['submit'])) {
            // Get form data
            // palitan mo yung mga column titles niyo
            $EmployeeID = $_POST['EmployeeID'];
            $FirstName = $_POST['FirstName'];
            $LastName = $_POST['LastName'];
            $PositionID = $_POST['PositionID'];

            // Insert into database
            $setQuery = "INSERT INTO `employee` (`EmployeeID`, `FirstName`, `LastName`, `PositionID`) VALUES ('$EmployeeID', '$FirstName', '$LastName', '$PositionID');";
            if (mysqli_query($conn, $setQuery)) {
                echo '<script>alert("Employee added successfully!");</script>';
            } else {
                echo '<script>alert("Error: ' . $setQuery . '<br>' . mysqli_error($conn) . '");</script>';
            }
        }
    ?>
    <form id="employeeFormEdit" method="post" autocomplete="off" class="hidden" action="update.php">
            <label for="EmployeeIDEdit">Employee ID</label>
            <input id="EmployeeIDEdit" type="text" name="EmployeeIDEdit" required value="" autocomplete="off">
            <label for="FirstNameEdit">First Name</label>
            <input id="FirstNameEdit" type="text" name="FirstNameEdit" required value="" autocomplete="off">
            <label for="LastNameEdit">Last Name</label>
            <input id="LastNameEdit"type="text" name="LastNameEdit" required value="" autocomplete="off">
            <label for="PositionIDEdit">Position ID</label>
            <input id="PositionIDEdit" type="text" name="PositionIDEdit" required value="" autocomplete="off">
            <button name="employee_submit" onclick="hideEditModal()">Submit</button>

        </form>

    <!-- Script to show editing form -->
    <script>
        function showEditModal(event, EmployeeID, FirstName, LastName, PositionID) {
            event.preventDefault();
            document.getElementById('EmployeeIDEdit').value = EmployeeID;
            document.getElementById('FirstNameEdit').value = FirstName;
            document.getElementById('LastNameEdit').value = LastName;
            document.getElementById('PositionIDEdit').value = PositionID;
            document.getElementById('employeeFormEdit').classList.remove('hidden');
        }

        function hideEditModal() {
            document.getElementById('employeeFormEdit').classList.add('hidden');
        }
    </script>
</body>
</html>