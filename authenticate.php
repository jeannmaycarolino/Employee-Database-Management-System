<?php
session_start();
include('config/logindb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Fetch user data
    $query = "SELECT * FROM users WHERE username='$username' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            switch ($role) {
                case 'admin':
                    header('Location: admin_dashboard.php');
                    break;
                case 'employee':
                    header('Location: employee_dashboard.php');
                    break;
                case 'manager':
                    header('Location: manager_dashboard.php');
                    break;
                default:
                    header('Location: login.php?error=Invalid role');
                    break;
            }
            exit();
        } else {
            header('Location: login.php?error=Invalid password');
            exit();
        }
    } else {
        header('Location: login.php?error=User not found or incorrect role');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>
