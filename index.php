<?php
include_once('includes/connection.php');
include_once('includes/product.php');
$product = new Product();
$data = $product->fetch_all();
//add by 714380532@qq.com
//add agian by 714380532@qq.com
//modified in branch team
//2nd modified in branch team
//3rd modified in branch team
?>

<!DOCTYPE html>
<head>
    <title>WebShelf</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

    <div class="container">
        <a href="index.php" id="logo">WebShelf</a>
        <ol>
	    <?php foreach ($data as $item) { ?>
	    <li>
		<a href="product_detail.php?id=<?php echo $item['id'];?>">
		<?php echo $item['name']; ?>
		</a> 
	        <small>posted in
		   <?php 
			date_default_timezone_set('America/Detroit');
			echo date('l jS', $article['create_date']);?>
		</small>
   	    </i>
	<?php } ?>
        <ol>
	<br/><br/>
        <a href="signin.php" id="login">Sign in</a>
	&nbsp;&nbsp;
        <a href="signup.php" id="signup">Sign up</a>
	<br><br>
        <a href="home_page.php" id="home_page">Home Page</a>
    </div>

</body>
</html>
