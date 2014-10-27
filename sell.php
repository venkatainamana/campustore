<?php
session_start();
include_once('includes/connection.php');
include('includes/header.php');


if (isset($_SESSION['logged_in'])) {
    //Fetching the user id from the session variable
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['name'], $_POST['category'], $_POST['description'], $_POST['price'], $_POST['quantity'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        //Check if any of the input fields is empty
        if (empty($name) or empty($description) or empty($category) or empty($price) or empty($quantity)) {
            $error = "All fields are required!";
        } else {

            //Check if the category is 'Books' i.e value of category id must be '1'
            if ($category == '1') {

                //If the category selected is 'Books', then author, edition and year are mandatory
                if (isset($_POST['author'], $_POST['edition'], $_POST['year'])) {
                    $author = $_POST['author'];
                    $edition = $_POST['edition'];
                    $year = $_POST['year'];

                    //Check if any of fields is empty, if so raise error.
                    if (empty($author) or empty($edition) or empty($year)) {
                        $error = "All fields are required!";
                    } else {

                        //else concatenate the author, edition and year to the description field
                        $description = "Author: " . $author . " Edition: " . $edition . " Year: " . $year . " " . $description;
                    }
                }
            }
        }

        /*****Code logic for uploading image file of the product****/
        if (empty($_FILES['picture']['name'])) {
            $image_attr = "0"; //no file chosen
        } else {
            //if user has chosen an image file for upload, check the file size
            if ($_FILES['picture']['size'] > 256000) {
                $error =  "Sorry, your file is too large.";
            }else {
//            $target_path = $target_path.basename( $_FILES['picture']['name']);
//            if(move_uploaded_file($_FILES['picture']['tmp_name'], $target_path)) {
//                $image_attr = "1";
//            } else{
//                $error = "There was an error uploading the file, please try again!";
//            }
            }

        }
        /***** End of code logic for file upload ******/

        //If no errors encountered, then add the product to the database
        if (empty($error)) {
            //Prepare the SQL INSERT query to add the product to the database
            date_default_timezone_set('America/Detroit');
            $query = $pdo->prepare("INSERT INTO product (name, description, create_date, price, order_status, quantity, user_id, category_id) VALUES (?,?,?,?,?,?,?,?)");
            $query->bindValue(1, $name);
            $query->bindValue(2, $description);
            $query->bindValue(3, date("Y-m-d H:i:s")); //date format of MySQL 'datetime' type
            $query->bindValue(4, $price);
            $query->bindValue(5, "Available");
            $query->bindValue(6, $quantity);
            $query->bindValue(7, $user_id);
            $query->bindValue(8, $category);

            // Execute the INSERT query
            $query->execute() or die(print_r($query->errorInfo(), true));

            // Fetch the id of the new product inserted to the database
            $product_id = $pdo->lastInsertId();

            //If image file chosen by user, update the picture table with the filepth
            if ($image_attr === "1") {
                $query = $pdo->prepare("INSERT INTO picture (product_id, path) VALUES (?,?)");
                $query->bindValue(1, $product_id);
                $query->bindValue(2, $target_path);
                $query->execute() or die(print_r($query->errorInfo(), true));
            }
            header("Location: edit_item.php");
        }
    }
}
?>

<html>
<head>
    <title>WebShelf -Upload Product to catalog</title>
    <link rel="stylesheet" href="style.css" id="style">
    <!--Script to show/hide div id "Book_details" based on dropdown menu selected -->
    <script>
        function changeDisplay(){
            var category = document.getElementById("category");
            var book_details = document.getElementById("book_details");
            if (category.value === '1'){
                book_details.style.display="inline";
            }
            else{
                book_details.style.display="none";
            }
        }
    </script>
</head>

<body>

    <div id="add_item" class="box add_item">
        <a href="account_menu.php" id="account">Your Account</a>
        <h3 class="center_align"> Upload Product for sale </h3>
        <?php if (isset($error)) { ?>
            <small style="color: #aa0000;"><?php echo $error;?></small>
            <br /><br />
        <?php } ?>
        <form method="post" action="sell.php" name="upload_item" enctype="multipart/form-data" >
            Category&nbsp;&nbsp;<select name="category" id="category" onchange="changeDisplay()">
                <?php
                $query = $pdo->prepare("SELECT id, name FROM category");
                $query->execute() or die(print_r($query->errorInfo(), true));
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row){
                    echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
            </select>
            <br><br>

            <label>Name&nbsp;&nbsp;<input type="text" name="name" size="50" required/></label><br><br>

            <div id="book_details">
                <label>Author&nbsp;&nbsp;<input type="text" name="author" size="50" /></label><br><br>
                <label>Edition&nbsp;&nbsp;<input type="text" name="edition" size="50" /></label><br><br>
                <label>Year&nbsp;&nbsp;<input type="text" name="year" size="50" pattern="[1-9][0-9]{3}"/>
                    <em class="comments">*YYYY</em>
                </label><br><br>
            </div>

            <label>Description<br>
                <textarea name="description" rows="5" cols="60" required placeholder="Enter Description here.."></textarea>
            </label><br><br>

            <label>Quantity&nbsp;&nbsp;
                <input type="text" name="quantity" pattern="[1-9]\d*"  value="1" required/>
            </label><br><br>

            <label>Price&nbsp;&nbsp;
                <input type="text" name="price" pattern="[1-9]\d*[.]?\d{1,2}" required/>
                <em class="comments">*Numbers only and upto 2 decimals allowed</em>
            </label><br><br>

            <label>Picture&nbsp;&nbsp;
                <input type="file" name="picture"/><br>
                <em class="comments">*File size must be less than 256kb</em>
            </label><br><br>

            <input type="submit" name="submit" value="Upload"/>
            <input type="reset" name="reset" value="Cancel"/>
            <br>

        </form>
    </div>
</body>
</html>
                                                              
<?php
include('includes/footer.php');
//} else{
//    header('Location: index.php');
//}
//
//?><!--                    -->
