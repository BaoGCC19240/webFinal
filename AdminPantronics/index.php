<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="styleManage.css">
	<script src="script.js"></script>
</head>
<body>
	<div class="mn-wrapper">
		<nav>
			<ul>
				<li><a href="?page=manage&&mpage=manageUser" class="active">User</a></li>
				<li><a href="?page=manage&&mpage=manageCategory">Category</a></li>
				<li><a href="?page=manage&&mpage=manageProduct">Product</a></li>
				<li><a href="?page=manage&&mpage=manageOrder">Order</a></li>
				<li><a href="?page=manage&&mpage=top_10product">Top 10 best selling products</a></li>
				<li><a href="?page=manage&&mpage=top_5category">Top 5 best selling product category</a></li>
				<li><a href="?page=manage&&mpage=rev_statistics">Revenue statistics</a></li>
			</ul>
		</nav>
		<div class="mn-content">
			<?php
			if(isset($_GET['mpage'])){
				$mpage=$_GET['mpage'];
				if($mpage=='manageCategory'){
					include_once('manageCategory.php');
				}
				if($mpage=='addCategory'){
					include_once('addCategory.php');
				}
				if($mpage=='updateCategory'){
					include_once('updateCategory.php');
				}
				if($mpage=='manageProduct'){
					include_once('manageProduct.php');
				}
				if($mpage=='addProduct'){
					include_once('addProduct.php');
				}
				if($mpage=='updateProduct'){
					include_once('updateProduct.php');
				}
				if($mpage=='manageOrder'){
					include_once('manageOrder.php');
				}if($mpage=='view_invoice'){
					include_once('view_invoice.php');
				}
				if($mpage=='manageUser'){
					include_once('manageUser.php');
				}
				if($mpage=='top_10product'){
					include_once('top_10product.php');
				}
				if($mpage=='top_5category'){
					include_once('top_5category.php');
				}
			}else{
				include_once('manageUSer.php');
			}
			?>
		</div>
	</div>
	<script src="script.js"></script>
</body>
</html>
