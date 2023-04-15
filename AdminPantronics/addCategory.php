<!DOCTYPE html>
<html>
<head>
	<title>Add new category</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<h1>Add new category</h1>
	<?php
	include_once('connection.php');

	// Kiểm tra xem người dùng đã submit form chưa
	if (isset($_POST['add'])) {
		// Lấy dữ liệu từ form và kiểm tra tính hợp lệ
		$name = mysqli_real_escape_string($conn, $_POST["name"]);
		$description = mysqli_real_escape_string($conn, $_POST["description"]);
		if (empty($name) || empty($description)) {
			echo "Error: Please enter all required fields";
		} else {
			// Sử dụng Prepared Statements để thêm mới danh mục sản phẩm
			$stmt = $conn->prepare("INSERT INTO ProductCategory (name, description) VALUES (?, ?)");
			$stmt->bind_param("ss", $name, $description);
			if ($stmt->execute()) {
				echo '<script>';
				echo 'setTimeout(function() { alert("Product category added successfully"); }, 2000);';
				echo '</script>';
				echo '<meta http-equiv="refresh" content="0;URL=?page=manage&&mpage=manageCategory"/>';
			} else {
				echo "Error: " . $stmt->error;
			}
			$stmt->close();
		}
	}

	// Đóng kết nối
	$conn->close();
	?>
	<form method="POST" action="">
		<label for="name">Category name:</label>
		<input type="text" name="name" required>
		<br>
		<label for="description">Description:</label>
		<textarea name="description" required></textarea>
		<br>
		<input type="submit" name="add" value="Add Category">
	</form>
</body>
</html>
