<!DOCTYPE html>
<html>
<head>
	<title>User Management</title>
	<style>
		table {
			border-collapse: collapse;
			width: 90%;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border-bottom: 1px solid #ddd;
		}

		tr:hover {background-color: #f5f5f5;}

		.order-list {
			padding: 8px;
			background-color: #f5f5f5;
		}

		.order-list table {
			border-collapse: collapse;
			width: 90%;
		}

		.order-list th, .order-list td {
			text-align: left;
			padding: 8px;
			border-bottom: 1px solid #ddd;
		}
	</style>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
	$(document).ready(function() {
		var clickCount = {}; // Object to store click counts for each user ID

		// Handle click event on user row
		$("table#user-table").on("click", "tr.user-row", function() {
			// Get user ID from data attribute
			var userId = $(this).data("user-id");

			// Send AJAX request to get orders for user
			if (!clickCount[userId]) {
				clickCount[userId] = 1;
			} else {
				clickCount[userId]++;
			}

			$.ajax({
				method: "GET",
				url: "get_orders.php",
				data: { user_id: userId }
			}).done(function(data) {
				var orderList = $("tr.order-list[data-user-id=" + userId + "]");

				if (clickCount[userId] % 2 == 1) {
					// Show order list below user row
					$("tr.user-row[data-user-id=" + userId + "]").after("<tr class='order-list' data-user-id='" + userId + "'><td colspan='5'><table>" + data + "</table></td></tr>");
				} else {
					// Hide order list
					orderList.hide();
				}
			});
		});
	});
</script>
</head>
<body>
	<div class="export"><button onclick="exportToExcel()"><a style="all: unset;" href="exportUser.php">Export</a></button></div>
	<script>
		function exportToExcel() {
		// Tạo đối tượng Workbook mới
		var wb = XLSX.utils.book_new();

		// Tạo một đối tượng Worksheet mới
		var ws = XLSX.utils.json_to_sheet(data);

		// Thêm worksheet vào workbook
		XLSX.utils.book_append_sheet(wb, ws, "User Data");

		// Hiển thị hộp thoại lưu file để người dùng chọn nơi lưu và đặt tên cho file
		var filename = prompt("Enter file name:", "user_data.xlsx");
		if (filename != null) {
			// Xuất file với tên và định dạng được người dùng chọn
			XLSX.writeFile(wb, filename, { bookType: 'xlsx', type: 'binary' });
		}
		}
	</script>
	<h1>User Management</h1>
	<table id="user-table">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Email</th>
			<th>Address</th>
			<th>Phone</th>
		</tr>
		<?php
			// Connect to MySQL database
			include_once('connection.php');
			// Select all users from User table
			$sql = "SELECT * FROM User where password!='null'";
			$result = mysqli_query($conn, $sql);

			// Loop through all rows and display user data in table
			if (mysqli_num_rows($result) > 0) {
			    while($row = mysqli_fetch_assoc($result)){echo "<tr class='user-row' data-user-id='" . $row["id"] . "'>";
			        echo "<td>" . $row["id"] . "</td>";
			        echo "<td>" . $row["username"] . "</td>";
			        echo "<td>" . $row["email"] . "</td>";
			        echo "<td>" . $row["address"] . "</td>";
			        echo "<td>" . $row["phone"] . "</td>";
			        echo "</tr>";
			    }
			} else {
			    echo "0 results";
			}
		?>
        
	</table>
</body>
</html>
