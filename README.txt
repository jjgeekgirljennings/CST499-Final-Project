CST499 Final Project
PHP Code Package – Online Course Enrollment System
Jessica Jennings
Instructor: Charmelia Butler
Date: October 7, 2026

CONTENTS
--------
Database.php
  Provides the mysqli connection to the course_enrollment MySQL database.

index.php
  Landing page for the Online Course Enrollment System with navigation to login and registration.

register.php
  Processes new-user registration, validates required fields and email format, checks duplicate
  user IDs/email addresses, hashes passwords, and inserts valid user records into MySQL.

login.php
  Displays the Student Login form used by the project.

courses.php
  Retrieves available courses from the courses table and displays an Enroll form for each course.

enroll.php
  Processes course enrollment, checks for duplicate enrollment, and inserts the selected course
  into the enrollments table.

my_courses.php
  Retrieves the student's registered courses by joining enrollments and courses and displays the
  student's class schedule with a Drop Course option.

drop_course.php
  Removes the selected enrollment for the project user and displays the result.

PROJECT ENVIRONMENT
-------------------
The files are designed for the XAMPP local environment used in the CST499 project:
  C:\xampp\htdocs\course_enrollment

Database name:
  course_enrollment

IMPORTANT FINAL-PROJECT NOTE
----------------------------
These PHP files are copied from the course_enrollment.zip submitted for the final-project package.
The original working source has been preserved rather than rewritten.

The implementation uses user_id = 1 in enroll.php, my_courses.php, and drop_course.php for the
demonstration student account. login.php contains the login interface, but the uploaded version
does not include server-side authentication/session assignment. The package therefore documents
the implementation exactly as submitted and does not claim functionality beyond the source code.
