<?php
session_start();

$host = 'db';
$dbname = getenv('MYSQL_DATABASE');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    
    if (!empty($inputUsername) && !empty($inputPassword)) {
        try{
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$inputUsername, $inputPassword]);

            header("Location: login.php");
            exit(); 
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    else{
        echo "Both username and password are required.";
    }

}

?>

<form method="POST" action="">
    Username: <input type="text" name="username" required>
    Password: <input type="password" name="password" required>
    <button type="submit">Register</button>
</form>