<?php 
$username = $_POST["username"];
$oldpassword = md5($_POST["oldpassword"]);
$newpassword = md5($_POST["newpassword"]);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $host = "localhost";
    $database = "lab9";
    $user = "webuser";
    $password = "P@ssw0rd";

    $connection = mysqli_connect($host, $user, $password, $database);
    $error = mysqli_connect_error();
    if ($error != null) {
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
    } else {
        $sql = $connection->prepare("SELECT username FROM users WHERE username = '$username' and password = '$oldpassword'");
        $sql->execute();
        $complete = $sql->get_result();
        $entered = $complete->fetch_assoc();

        while ($entered) {
            $sql = $connection->prepare("UPDATE users SET password = '$newpassword' WHERE username = '$username' and password = '$oldpassword'");
            if ($sql->execute()) {
                echo "changed password succesfully";
                mysqli_free_result($complete);
                mysqli_close($connection);
                die;
            }
        }
        echo "cannot change password";
        mysqli_free_result($complete);
        mysqli_close($connection);
        die;
    }
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    die("Unable to get data!");
}
