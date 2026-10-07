<?php
session_start();

$conn = new mysqli("localhost", "root", "", "course_enrollment");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/*
 Student01 has internal database ID 1.
*/
$user_id = 1;

$sql = "
    SELECT
        e.enrollment_id,
        c.course_code,
        c.course_name,
        c.semester,
        e.enrollment_date
    FROM enrollments e
    INNER JOIN courses c
        ON e.course_id = c.course_id
    WHERE e.user_id = ?
    ORDER BY c.course_code
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>My Schedule</title>

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
    background-color: white;
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

.drop-button {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 8px 15px;
    cursor: pointer;
    border-radius: 4px;
}

.add-button {
    display: inline-block;
    margin-top: 20px;
    background-color: #007bff;
    color: white;
    padding: 10px 18px;
    text-decoration: none;
    border-radius: 4px;
}

</style>

</head>

<body>

<div class="container">

<h1>My Class Schedule</h1>

<table>

<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Semester</th>
    <th>Enrollment Date</th>
    <th>Action</th>
</tr>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

?>

<tr>

<td>
<?php echo htmlspecialchars($row["course_code"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["course_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["semester"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["enrollment_date"]); ?>
</td>

<td>

<form method="post" action="drop_course.php">

<input
    type="hidden"
    name="enrollment_id"
    value="<?php echo $row["enrollment_id"]; ?>"
>

<button
    type="submit"
    class="drop-button">
    Drop Course
</button>

</form>

</td>

</tr>

<?php

    }

} else {

?>

<tr>
<td colspan="5">
You are not currently registered for any courses.
</td>
</tr>

<?php
}
?>

</table>

<a class="add-button" href="courses.php">
Add Another Course
</a>

</div>

</body>

</html>

<?php

$stmt->close();
$conn->close();

?>