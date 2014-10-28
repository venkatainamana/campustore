<?php
include_once('includes/connection.php');
include_once('includes/product.php');
$product = new Product();
$data = $product->fetch_all();

$page_title = "index.php";
include('includes/header.php');
?>

       <ol>
	    <?php 
		$column_num = 4;
		$column_count = 0;
		foreach ($data as $item) { 
		    $icon_path = "./uploads/icons/".$item['icon']; 
		    if(!file_exists($icon_path) || is_dir($icon_path)){
			$icon_path = "./uploads/icons/"."default.png";
		    }
	    ?>
		    <div class="item">
			<img class="item_icon" src=<?php echo $icon_path?> alt="item picture">
			<br>
			<a href="product_detail.php?id=<?php echo $item['id'];?>">
			<?php echo $item['name']; ?>
			</a> 
			<br>
	       		 <small>posted in
		   	<?php 
				date_default_timezone_set('America/Detroit');
				echo date('l jS', $article['create_date']);
			?>
			</small>
   		    </div>
	    <?php
	   	  if(++$column_count >= $column_num){
			$column_count = 0;	
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
	           }
	     } 
	    ?>
        <ol>
	<br/><br/>
        <a href="signin.php" id="login">Sign in</a>
	&nbsp;&nbsp;
        <a href="signup.php" id="signup">Sign up</a>
	<br><br>
        <a href="home_page.php" id="home_page">Home Page</a>

<?php 
include('includes/footer.php');
?>
