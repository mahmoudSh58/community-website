
## <span style='color:red'> Object-oriented interface vs Procedural interface in mySQLi :


I think you might be asking about the difference between the procedural and object-oriented approaches to using the mysqli extension in PHP. Here are examples of both approaches:

> #### Procedural example using mysqli:

```php
<?php
// connect to the database
$mysqli = mysqli_connect("localhost", "username", "password", "database_name");

// check connection
if (!$mysqli) {
	die("Connection failed: " . mysqli_connect_error());
}

// run a query and retrieve the results
$sql = "SELECT * FROM users";
$result = mysqli_query($mysqli, $sql);

// loop through the results and display them
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
    echo "Name: " . $row["name"] . ", Email: " . $row["email"] . "<br>";
  }
} else {
	echo "No results found";
}

// close the database connection
mysqli_close($mysqli);
?>
```

In this example, we're using the procedural approach to connect to a MySQL database using mysqli_connect(), run a SELECT query using mysqli_query(), loop through the results using mysqli_fetch_assoc(), and close the database connection using mysqli_close().

> ##### Object-oriented example using mysqli:


```php

<?php
// create a new mysqli object and connect to the database
$mysqli = new mysqli("localhost", "username", "password", "database_name");

// check connection
if ($mysqli->connect_errno) {
	die("Connection failed: " . $mysqli->connect_error);
}

// run a query and retrieve the results
$sql = "SELECT * FROM users";
$result = $mysqli->query($sql);

// loop through the results and display them
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "Name: " . $row["name"] . ", Email: " . $row["email"] . "<br>";
  }
} else {
	echo "No results found";
}

// close the database connection
$mysqli->close();
?>
```

In this example, we're using the object-oriented approach to create a new mysqli object using the new keyword, connect to a MySQL database, run a SELECT query using the query() method, loop through the results using the fetch_assoc() method, and close the database connection using the close() method.

Note that the syntax and function names are slightly different between the two approaches, but the underlying functionality is the same. It's up to personal preference and coding style which approach to use.
	
.......
.......


## <span style='color:red'> for safety :

> where to use htmlspecialchars()

You should use the htmlspecialchars() function whenever you output user-generated data in an HTML context, such as when displaying the data on a web page. This function converts special characters to their corresponding HTML entities, which prevents the browser from interpreting them as HTML tags or other malicious code.

For example, let's say you have a form that collects a user's name and displays it on a web page:

```php

<!DOCTYPE html>
<html>
<head>
  <title>Example Form</title>
</head>
<body>
  <?php
  $name = $_POST['name'];
  ?>
  <h1>Hello, <?php echo $name; ?>!</h1>
</body>
</html>
```

In this example, we're retrieving the value of the "name" field from the form submission using $_POST['name'], and displaying it on the web page using PHP's echo statement. However, if the user's name contains special characters such as <, >, or &, these characters could be interpreted by the browser as HTML tags or other code.

To prevent this from happening, we can use the htmlspecialchars() function to sanitize the user's name before displaying it on the web page:

```php

<!DOCTYPE html>
<html>
<head>
  <title>Example Form</title>
</head>
<body>
  <?php
  $name = $_POST['name'];
  ?>
  <h1>Hello, <?php echo htmlspecialchars($name); ?>!</h1>
</body>
</html>
```