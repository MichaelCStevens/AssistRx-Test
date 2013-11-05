AssistRx PHP Assessment Test

Requirements:
Webserver and MySQL Database (local or hosted)
Run users.sql to create "users" table with test users

Objectives:
1. Complete login::validateUser() in index.php - query database to match user with password (password is md5 hash of user)
  a. account for XSS and SQL injections
  b. show meaningful errors if authentication fails (e.g. 'Username not found', 'Password invalid for user', 'All fields required')

2. Complete class "hint" in forgot_password.php
  a. hint::validateUser() - query database to match user with email - show hint if successful
  b. validate email by using regular expressions
  c. account for XSS and SQL injections

3. use jQuery/AJAX for "Forgot Password" to show secret hint.  Do not refresh or leave page.
  a. if validation is successful, remove the form and show the hint.
  b. you may modify the html as needed

4. Using CSS, move the forms side-by-side, instead of vertical
  a. make other design updates if time permits - no need for a production-ready design
  b. comment on how you could improve user experience (e.g. autocomplete can be used to...)

5. Make any other improvements for OOP best practices - feel free to rewrite as needed
