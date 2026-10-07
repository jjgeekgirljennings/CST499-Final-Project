<?php
session_start();

$conn = new mysqli("localhost", "root", "", "course_enrollment");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/*
 For this project demonstration, user 1 is the registered
 student account (student01).
*/
$user_id = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["course_id"])) {

    $course_id = intval($_POST["course_id"]);

    // Check whether the student is already enrolled.
    $check = $conn->prepare(
        "SELECT enrollment_id
         FROM enrollments
         WHERE user_id = ? AND course_id = ?"
    );

    $check->bind_param("ii", $user_id, $course_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        $message = "You are already registered for this course.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO enrollments (user_id, course_id)
             VALUES (?, ?)"
        );

        $stmt->bind_param("ii", $user_id, $course_id);

        if ($stmt->execute()) {
            $message = "Course registration successful!";
        } else {
            $message = "Unable to register for the course.";
        }

        $stmt->close();
    }

    $check->close();

} else {

    $message = "No course was selected.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">

<title>Course Registration</title>

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

.success {
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

<h1>Course Registration</h1>

<p class="success">
<?php echo htmlspecialchars($message); ?>
</p>

<a href="courses.php">Available Courses</a>

<a href="my_courses.php">My Schedule</a>

</div>

</body>

</html>