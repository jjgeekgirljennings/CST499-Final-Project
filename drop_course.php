<?php
session_start();

$conn = new mysqli("localhost", "root", "", "course_enrollment");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$user_id = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["enrollment_id"])) {

    $enrollment_id = intval($_POST["enrollment_id"]);

    $stmt = $conn->prepare(
        "DELETE FROM enrollments
         WHERE enrollment_id = ?
         AND user_id = ?"
    );

    $stmt->bind_param("ii", $enrollment_id, $user_id);

    if ($stmt->execute()) {

        if ($stmt->affected_rows > 0) {
            $message = "Course successfully removed from your schedule.";
        } else {
            $message = "Course could not be found.";
        }

    } else {
        $message = "Unable to remove the course.";
    }

    $stmt->close();

} else {
    $message = "No course was selected.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Drop Course</title>

<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8;
    padding: 40px;
}

.container {
    max-width: 700px;
    margin: auto;
    background-color: white;
    padding: 40px;
    text-align: center;
    border-radius: 8px;
}

.message {
    font-size: 20px;
    margin-bottom: 30px;
}

a {
    display: inline-block;
    margin: 10px;
    padding: 10px 18px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
}

</style>

</head>

<body>

<div class="container">

<h1>Drop Course</h1>

<p class="message">
<?php echo htmlspecialchars($message); ?>
</p>

<a href="my_courses.php">My Schedule</a>

<a href="courses.php">Available Courses</a>

</div>

</body>
</html>