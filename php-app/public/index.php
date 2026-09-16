<!DOCTYPE html>
<html>
<head>
    <title>Add Lead</title>
</head>
<body>
    <h1>Add a New Lead</h1>

    <form action="submit-lead.php" method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name"><br><br>

        <label>Last Name:</label>
        <input type="text" name="last_name"><br><br>

        <label>Phone Number:</label>
        <input type="text" name="phone_number"><br><br>

        <label>Email:</label>
        <input type="text" name="email"><br><br>

        <label>Notes:</label>
        <textarea name="notes"></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
