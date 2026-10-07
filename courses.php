<?php
session_start();
require_once 'Database.php';

$conn = new mysqli("localhost", "root", "", "course_enrollment");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT course_id, course_code, course_name, semester, max_enrollment
        FROM courses
        ORDER BY course_code";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Courses</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        .enroll-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<div class="container">

<h1>Available Courses</h1>

<table>

<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Semester</th>
    <th>Maximum Enrollment</th>
    <th>Action</th>
</tr>

<?php
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

<tr>

<td><?php echo htmlspecialchars($row['course_code']); ?></td>

<td><?php echo htmlspecialchars($row['course_name']); ?></td>

<td><?php echo htmlspecialchars($row['semester']); ?></td>

<td><?php echo htmlspecialchars($row['max_enrollment']); ?></td>

<td>
    <form method="post" action="enroll.php">

        <input
            type="hidden"
            name="course_id"
            value="<?php echo $row['course_id']; ?>"
        >

        <button
            class="enroll-button"
            type="submit">
            Enroll
        </button>

    </form>
</td>

</tr>

<?php
    }
} else {
?>

<tr>
    <td colspan="5">No courses are currently available.</td>
</tr>

<?php
}
?>

</table>

</div>

</body>
</html>