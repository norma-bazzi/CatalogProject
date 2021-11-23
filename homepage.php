<?php
session_start();
if(isset($_SESSION['usr']) || isset($_COOKIE['usr'])){
}
else
	header("Location: login.php");

require('connection.php');
$db = connect();
$query = "select name,catid from category";
$stmt = $db->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

if(isset($_POST['addcat'])){
	$catid = $_POST['categoryid'];
	$name = $_POST['name'];
$queryadd = "insert into category(catid,name) values(?,?)";
$stmtadd = $db->prepare($queryadd);
$stmtadd->bind_param('is',$catid,$name);
$stmtadd->execute();
header("Location: homepage.php");
}

if(isset($_POST['addprod'])){
	$prodid = $_POST['productid'];
	$prodname = $_POST['prodname'];
	$price = $_POST['price'];
	$id = $_POST['catiddd'];
$queryadd = "insert into product(productid,prodname,price) values(?,?,?)";
$stmtadd = $db->prepare($queryadd);
$stmtadd->bind_param('isi',$prodid,$prodname,$price);
$stmtadd->execute();

$queryy = "insert into collection(productid,catid) values(?,?)";
$stmty = $db->prepare($queryy);
$stmty->bind_param('ii',$prodid,$id);
$stmty->execute();

}

$queryc= "Select distinct catid,name from category";
$stmtc = $db->prepare($queryc);
$stmtc->execute();
$resc = $stmtc->get_result();

$queryprod= "Select distinct productid,prodname from product";
$stmtprod = $db->prepare($queryprod);
$stmtprod->execute();
$resprod = $stmtprod->get_result();

if(isset($_POST['delete'])){
$ctid=$_POST['catdelete'];

$querydel= 'delete from collection where catid='.$ctid;
$stmtdel = $db->prepare($querydel);
$stmtdel->execute();
	
$querydell= 'delete from category where catid='.$ctid;
$stmtdell = $db->prepare($querydell);
$stmtdell->execute();
header("Location: homepage.php");
}


if(isset($_POST['deleteprod'])){
$prid=$_POST['prod'];

$querydel= 'delete from collection where productid='.$prid;
$stmtdel = $db->prepare($querydel);
$stmtdel->execute();
	
$querydell= 'delete from product where productid='.$prid;
$stmtdell = $db->prepare($querydell);
$stmtdell->execute();
header("Location: homepage.php");
}

if(isset($_POST['editcat'])){
	$v=$_POST['catdelete'];
	header("Location: update.php?valuecat=$v");
}

if(isset($_POST['editprod'])){
	$vp=$_POST['prod'];
	header("Location: update.php?valueprod=$vp");
}
?>


<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
   <title>Homepage</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="new2.css">

	
</head>
<body style="background-image:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url(image/1.PNG); font-family: poppins; -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  margin-top: -50px;">
  
  
  <div class="container">
	<div class="row ">
		<div class="wrapper">
		<br>
			<ul class="nav-area">
				<li><div class="dropdown">
				<button style="font-family: arial; font-weight: normal;" onclick="myFunction()" class="dropbtn">Category</button>
				<div id="myDropdown" class="dropdown-content">
					<a ><button style="color: white; font-size: 16px; font-weight: normal;" class="sliders">Add</button></a >
					<a ><button style="color: white; font-family: arial; font-size: 16px; font-weight: normal;" class="slide">Edit</button></a>
					<a ><button style="color: white; font-size: 16px; font-weight: normal;" class="slider">Delete</button></a >
				</div>
				</div></li>
				

				<li><div class="dropdown">
				<button style="font-family: arial; font-weight: normal;" onclick="myFunctions()" class="dropbtn">Product</button>
				<div id="myDropdownn" class="dropdown-content">
					<a><button style="color: white; font-size: 16px; font-weight: normal;" class="sliderss">Add</button></a >
					<a><button  style="color: white; font-weight: normal; font-family: arial; font-size: 16px;"class="slidee">Edit</button></a>
					<a ><button style="color: white; font-size: 16px; font-weight: normal;" class="slidersss">Delete</button></a>
				</div>
				</div></li>
				<li><a href="login.php?bb=1">Log Out</a>	
				</li>
			</ul>
		</div>
		</div>
		</div>
  
<p> </p>
<div class="container">
<div class="row">
<div class="col-sm-12">
	<!-- Category -->
	<div class="single category">
		<h3 class="side-title">Categories</h3>
		<ul class="list-unstyled">
		<?php
		    while($row=$res->fetch_assoc()){
			echo'<li><a href="product.php?id='.$row["catid"].'">'.$row["name"].'</a></li>';
			}
	    ?>
		</ul>
   </div>
</div> 
</div>
</div>

	<!-- The Modal -->
			<div id="myModal1" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  <span class="close" onclick="close2()">&times;</span>
		  <div class="login-wrap p-0">
		  <form action="homepage.php" class="signin-form" method="post">
		   <div class="d-flex">
				<div class="col-md-6">
					<div class="form-group">
						<input id="getid1" class="form-control" name="categoryid" placeholder="Category ID" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control" name="name" placeholder="Category Name" required>
					</div>
				</div>						
			</div>
			<div class="form-group">
				<input type="submit" name="addcat" class="form-control btn board submit px-3" value="Add">
			</div>
			</form>
			</div>
			</div>
			</div>
			
<!-- The Modal3 -->
			<div id="myModal3" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  <span class="close" onclick="close4()">&times;</span>
		  <div class="login-wrap p-0">
		  <form action="homepage.php" class="signin-form" method="post">
		   <div class="d-flex">
				<div class="col-md-6">
					<div class="form-group">
						<input  class="form-control" name="productid" placeholder="Product ID" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control" name="prodname" placeholder="Product Name" required>
					</div>
				</div>
				</div>	
			<div class="d-flex">
                <div class="col-md-6">
					<div class="form-group">
						<input type="text" class="form-control" name="price" placeholder="Price" required>
					</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
						<input type="text" class="form-control" list="categories" type="text" name="catiddd" id="categorie" placeholder="Category" required>
							<datalist id="categories">
							<?php 
							while($rowc=$resc->fetch_assoc()){
							?>
							<option value="<?php echo $rowc['catid']; ?>"><?php echo $rowc['name'] ?>
							<?php
							}
							?>
							</datalist>
					</div>
					</div>
				</div>
</div>				
			
			<div class="form-group">
				<input type="submit" name="addprod" class="form-control btn board submit px-3" value="Add">
			</div>
			</form>
			</div>
			</div>
			</div>

	<!-- The Modal2 -->
			<div id="myModal2" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  <span class="close" onclick="close3()">&times;</span>
		  <div class="login-wrap p-0">
		  <form action="homepage.php" class="signin-form" method="post">
		   <div class="d-flex">
				<div class="form-group col-md-12">
						<input style="color: black; border: 1px solid gray; width: 100%; padding: 5px 5px; border-radius: 25px;" list="categories" type="text" name="catdelete" id="categorie" placeholder="Category" required>
							<datalist id="categories">
							<?php 
							while($rowc=$resc->fetch_assoc()){
							?>
							<option value="<?php echo $rowc['catid']; ?>"><?php echo $rowc['name'] ?>
							<?php
							}
							?>
							</datalist>
					</div>						
			</div>
			<div class="form-group">
				<input type="submit" name="delete" class="form-control btn board submit px-3" value="Delete">
			</div>
			</form>
			</div>
			</div>
			</div>
			  
<!-- The Modal4 -->
			<div id="myModal4" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  <span class="close" onclick="close5()">&times;</span>
		  <div class="login-wrap p-0">
		  <form action="homepage.php" class="signin-form" method="post">
		   <div class="d-flex">
				<div class="form-group col-md-12">
						<input style="color: black; border: 1px solid gray; width: 100%; padding: 5px 5px; border-radius: 25px;" list="products" type="text" name="prod" id="product" placeholder="Product" required>
							<datalist id="products">
							<?php 
							while($rowprod=$resprod->fetch_assoc()){
							?>
							<option value="<?php echo $rowprod['productid']; ?>"><?php echo $rowprod['prodname'] ?>
							<?php
							}
							?>
							</datalist>
					</div>						
			</div>
			<div class="form-group">
				<input type="submit" name="deleteprod" class="form-control btn board submit px-3" value="Delete">
			</div>
			</form>
			</div>
			</div>
			</div>
			
			<!-- The Modal5 -->
			<div id="myModal5" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  <span class="close" onclick="close6()">&times;</span>
		  <div class="login-wrap p-0">
		  <form action="homepage.php" class="signin-form" method="post">
		   <div class="d-flex">
				<div class="form-group col-md-12">
					<input style="color: black; border: 1px solid gray; width: 100%; padding: 5px 5px; border-radius: 25px;" list="categories" type="text" name="catdelete" id="categorie" placeholder="Category" required>
							<datalist id="categories">
							<?php 
							while($rowc=$resc->fetch_assoc()){
							?>
							<option value="<?php echo $rowc['catid']; ?>"><?php echo $rowc['name'] ?>
							<?php
							}
							?>
							</datalist>
					</div>						
			</div>
			<div class="form-group">
				<input type="submit" name="editcat" class="form-control btn board submit px-3" value="Edit">
			</div>
			</form>
			</div>
			</div>
			</div>
			
			<!-- The Modal6 -->
			<div id="myModal6" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		  <span class="close" onclick="close7()">&times;</span>
		  <div class="login-wrap p-0">
		  <form action="homepage.php" class="signin-form" method="post">
		   <div class="d-flex">
				<div class="form-group col-md-12">
						<input style="color: black; border: 1px solid gray; width: 100%; padding: 5px 5px; border-radius: 25px;" list="products" type="text" name="prod" id="product" placeholder="Product" required>
							<datalist id="products">
							<?php 
							while($rowprod=$resprod->fetch_assoc()){
							?>
							<option value="<?php echo $rowprod['productid']; ?>"><?php echo $rowprod['prodname'] ?>
							<?php
							}
							?>
							</datalist>
					</div>						
			</div>
			<div class="form-group">
				<input type="submit" name="editprod" class="form-control btn board submit px-3" value="Edit">
			</div>
			</form>
			</div>
			</div>
			</div>
	<script src="js/myjs.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script>
//var buttons = document.querySelectorAll('button');
  
	var buttons = document.getElementsByClassName("sliders");
	for (var i=0; i<buttons.length; ++i) {
	  buttons[i].addEventListener('click', clickFunc);
	}

	function clickFunc() {
	  modal1.style.display = "block";
	}

	function close2(){
		modal1.style.display = "none";
	}
			// Get the modal
	var modal1 = document.getElementById("myModal1");
	</script>
	<script>
//var buttons = document.querySelectorAll('button');
  
	var buttons = document.getElementsByClassName("sliderss");
	for (var i=0; i<buttons.length; ++i) {
	  buttons[i].addEventListener('click', clickFunc);
	}

	function clickFunc() {
	  modal3.style.display = "block";
	}

	function close4(){
		modal3.style.display = "none";
	}
			// Get the modal
	var modal3 = document.getElementById("myModal3");
	</script>
	
		<script>
//var buttons = document.querySelectorAll('button');
  
	var buttons = document.getElementsByClassName("slider");
	for (var i=0; i<buttons.length; ++i) {
	  buttons[i].addEventListener('click', clickFunc);
	}

	function clickFunc() {
	  modal2.style.display = "block";
	}

	function close3(){
		modal2.style.display = "none";
	}
			// Get the modal
	var modal2 = document.getElementById("myModal2");
	</script>
	<script>
//var buttons = document.querySelectorAll('button');
  
	var buttons = document.getElementsByClassName("slidersss");
	for (var i=0; i<buttons.length; ++i) {
	  buttons[i].addEventListener('click', clickFunc);
	}

	function clickFunc() {
	  modal4.style.display = "block";
	}

	function close5(){
		modal4.style.display = "none";
	}
			// Get the modal
	var modal4 = document.getElementById("myModal4");
	</script>
		<script>
//var buttons = document.querySelectorAll('button');
  
	var buttons = document.getElementsByClassName("slide");
	for (var i=0; i<buttons.length; ++i) {
	  buttons[i].addEventListener('click', clickFunc);
	}

	function clickFunc() {
	  modal5.style.display = "block";
	}

	function close6(){
		modal5.style.display = "none";
	}
			// Get the modal
	var modal5 = document.getElementById("myModal5");
	</script>
			<script>
//var buttons = document.querySelectorAll('button');
  
	var buttons = document.getElementsByClassName("slidee");
	for (var i=0; i<buttons.length; ++i) {
	  buttons[i].addEventListener('click', clickFunc);
	}

	function clickFunc() {
	  modal6.style.display = "block";
	}

	function close7(){
		modal6.style.display = "none";
	}
			// Get the modal
	var modal6 = document.getElementById("myModal6");
	</script>
</script>

</body>
</html> 
