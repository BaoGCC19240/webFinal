<div class="export"><button onclick="exportToExcel()"><a style="all: unset;" href="exportProduct.php">Export</a></button></div>
	<script>
		function exportToExcel() {
		// Tạo đối tượng Workbook mới
		var wb = XLSX.utils.book_new();

		// Tạo một đối tượng Worksheet mới
		var ws = XLSX.utils.json_to_sheet(data);

		// Thêm worksheet vào workbook
		XLSX.utils.book_append_sheet(wb, ws, "Product Data");

		// Hiển thị hộp thoại lưu file để người dùng chọn nơi lưu và đặt tên cho file
		var filename = prompt("Enter file name:", "Product.xlsx");
		if (filename != null) {
			// Xuất file với tên và định dạng được người dùng chọn
			XLSX.writeFile(wb, filename, { bookType: 'xlsx', type: 'binary' });
		}
		}
	</script>
<h1>Product</h1>
    <a href="?page=manage&&mpage=addProduct">Add</a>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Category ID</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
include_once('connection.php');

// Lấy dữ liệu từ bảng Product
$stmt = $conn->prepare("SELECT * FROM Product");
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả
if ($result->num_rows > 0) {
    // Hiển thị dữ liệu
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["category_id"]) . "</td>";
        echo "<td>";
        echo "<a href='?mpage=updateProduct&amp;id=" . htmlspecialchars($row["id"]) . "'>Edit</a>";
        echo " | ";
        echo "<a href='?mpage=manageProduct&amp;function=del&amp;id=" . htmlspecialchars($row["id"]) . "' onclick='return deleteConfirm()'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>Not added</td></tr>";
}
?>

  </tbody>
</table>
<?php
  include_once("connection.php");
  if(isset($_GET["function"])=="del"){
    if(isset($_GET['id'])){
      $id=mysqli_real_escape_string($conn, $_GET["id"]);

      // Kiểm tra xem category này có sản phẩm nào không
      $sql_check_invoice = "SELECT * FROM invoicedetail WHERE product_id = '$id'";
      $sql_check_invoice = mysqli_query($conn, $sql_check_invoice);

      if (mysqli_num_rows($sql_check_invoice) > 0) {
          // Nếu có sản phẩm liên kết thì không cho phép xóa
          echo '<script>
                  alert("This product cannot be removed because there is already a linked order!");
                  window.location.href="?mpage=manageProduct";
                </script>';
      } else {
          // Nếu không có sản phẩm liên kết thì tiến hành xóa category
          $sql_delete = "DELETE FROM product WHERE id=?";
          $stmt = mysqli_prepare($conn, $sql_delete);
          mysqli_stmt_bind_param($stmt, "i", $id);
          mysqli_stmt_execute($stmt);
          echo '<meta http-equiv="refresh" content="0;URL=?page=manage&mpage=manageProduct"/>';
      }
    }
  } 
?>
