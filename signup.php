<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Tailwind config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE DATABASE MANAGEMENT</title>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                EMPLOYEE DATABASE MANAGEMENT
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign up to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="post">
                        <div class="mt-5 flex flex-row justify-between gap-3">
                            <div>
                                <label for="firstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                <input type="text" name="firstName" id="firstName" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            <div>
                                <label for="lastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                <input type="text" name="lastName" id="lastName" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="employee" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee ID</label>
                            <input type="text" name="employee" id="employee" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="PositionTitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position Title</label>
                            <select id="PositionTitle" name="PositionTitle" required class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected disabled>Select Position Title</option>
                                <!-- Assuming you fetch position titles from the database and populate the dropdown dynamically -->
                                <?php
                                include('./config/db.php');
                                // Fetch position titles from the database
                                $positionQuery = "SELECT * FROM position";
                                $positionResult = mysqli_query($conn, $positionQuery);

                                // Check if there are any results
                                if ($positionResult && mysqli_num_rows($positionResult) > 0) {
                                    // Loop through each row to display position titles as options in the dropdown
                                    while ($row = mysqli_fetch_assoc($positionResult)) {
                                        $PositionTitle = $row['PositionTitle'];
                                        $PositionID = $row['PositionID'];
                                        echo "<option value='$PositionID'>$PositionTitle</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="submit_button" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign Up</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Already have an account? <a href="login.php" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
include('./config/db.php');

if (isset($_POST['submit_button'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $employeeID = $_POST['employee'];
    $PositionTitle = $_POST['PositionTitle'];
    print($employeeID);

    // Check if the email already exists in the database
    $existingEmailQuery = "SELECT Email FROM account WHERE Email='$email'";
    $existingEmailResult = mysqli_query($conn, $existingEmailQuery);

    if (mysqli_num_rows($existingEmailResult) > 0) {
        // If the email already exists, show an error message
        echo "<script>alert('Error: Email address already exists. Please use a different email address.');</script>";
    } else {
        // Check if the FirstName and LastName already exist in the employee table
        $nameCheckQuery = "SELECT * FROM employee WHERE FirstName = '$firstName' AND LastName = '$lastName'";
        $nameCheckResult = mysqli_query($conn, $nameCheckQuery);

        if (mysqli_num_rows($nameCheckResult) > 0) {
            // Employee with the same FirstName and LastName already exists
            echo "<script>alert('Error: An employee with the same First Name and Last Name already exists.');</script>";
        } else {
            $employeeQuery = "INSERT INTO employee (`EmployeeID`, `FirstName`, `LastName`, `PositionID`) VALUES ('$employeeID', '$firstName', '$lastName', '$PositionTitle')";

            if(mysqli_query($conn, $employeeQuery)) {
                // If the employee is successfully inserted, proceed with inserting the new user into the account table
                $insertQuery = "INSERT INTO account (`AccountID`, `Email`, `Password`, `EmployeeID`) VALUES (NULL, '$email', '$password', '$employeeID')";

                if (mysqli_query($conn, $insertQuery)) {
                    // User successfully inserted
                    echo "<script>alert('New record created successfully');</script>";
                    // Optionally, redirect to a confirmation page instead of refreshing
                    echo "<script>window.location.href = './employee/index.php';</script>";
                } else {
                    // Error inserting user
                    echo "<p class='text-red-500'>Error: " . mysqli_error($conn) . "</p>";
                }
            }
        }
    }
}
?>


</body>
</html>
