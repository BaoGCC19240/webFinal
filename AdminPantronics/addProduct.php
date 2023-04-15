<!DOCTYPE html>
<html>
<head>
	<title>Add new product</title>

</head>
<?php
// Kết nối tới cơ sở dữ liệu
include_once('connection.php');

// Truy vấn để lấy danh sách các danh mục
$sql = "SELECT id, name FROM ProductCategory";
$result = mysqli_query($conn, $sql);

// Tạo các tùy chọn cho thẻ select
$options = '<option value="">--Select category--</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
}
?>
<body>
	<h1>Add new product</h1>
	<form method="post" action="" id="formAP" enctype="multipart/form-data">
		<label for="name">Product name:</label><br>
		<input type="text" id="name" name="name" required><br>
		<label for="description">Description:</label><br>
		<textarea id="description" name="description" required></textarea><br>
		<label for="price">Price:</label><br>
		<input type="number" id="price" name="price" step="0.01" min="0" required><br>
		<label for="image_url">Picture URL:</label><br>
		<input type="file" id="images" name="images[]" multiple required>
		<label for="quantity">Quantity:</label><br>
		<input type="number" id="quantity" name="quantity" min="0" required><br>
		<label for="category_id">Category:</label><br>
		<select id="category" name="category_id" required>
    	<?php echo $options; ?>
		</select><br><br>
		<input type="submit" name="addProduct" value="Add Product">
	</form>
	<?php 
	include_once('connection.php');
	
	if(isset($_POST['addProduct'])){
		$name = $_POST['name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$category_id = $_POST['category_id'];
		$images = $_FILES['images'];
		
		// Lưu sản phẩm vào bảng Product
		$sql = "INSERT INTO Product (name, description, price, quantity, category_id) VALUES (?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ssiii", $name, $description, $price, $quantity, $category_id);
		$result = mysqli_stmt_execute($stmt);
		
		if ($result) {
		  // Lấy id của sản phẩm vừa được thêm vào
		  $product_id = mysqli_insert_id($conn);
		
		  // Lưu thông tin các hình ảnh vào bảng ProductImage
		  foreach ($images['tmp_name'] as $key => $tmp_name) {
			$image_name = $images['name'][$key];
			$image_url ="Images/$image_name";
			$disk_url="../Images/$image_name";
			move_uploaded_file($tmp_name, $disk_url);
		
			$sql = "INSERT INTO ProductImage (product_id, image_url) VALUES (?, ?)";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "is", $product_id, $image_url);
			mysqli_stmt_execute($stmt);
		  }
		
		echo '<script>';
		echo 'alert("Product added successfully");';
		echo '</script>';
		echo '<meta http-equiv="refresh" content="0;URL=?page=manage&&mpage=manageProduct"/>';
		} else {
		  echo "There are wrong something while add new product";
		}		
	
	}
?>

</body>
</html>
