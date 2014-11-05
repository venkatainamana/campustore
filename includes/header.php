<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class="header">
        <a href="index.php" id="logo"><img class="logo" src="img/logo.png" alt="logo picture" ></a>
	<select name="category_list" id="category_dropdown">
	<option value="Books">Books</option>
	<option value="Electronics">Electionics</option>
	</select>
        <input type="text" name="searchStr" id="search_input">
	<button name="searchBtn" id="searchButton">Search</button>
	<button href="signin.php" id="signin" onclick="window.location.href='signin.php'">Sign in</button>
	<button href="signup.php" id="signup" onclick="window.location.href='signup.php'">Sign up</button>
	<button href="signup.php" id="signup" onclick="window.location.href='signup.php'">Sign up</button>


    </div>

    <div class="container">

<!-- The <div> will be closed in footer.php-->
</html>

