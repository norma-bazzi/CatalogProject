<?php
session_start();
if(isset($_SESSION['usr']) || isset($_COOKIE['usr'])){
}
else
	header("Location: login.php");

require('connection.php');
$db = connect();

if(isset($_GET['valuecat'])){
	$id=$_GET['valuecat'];
	$query ='select catid,name from category where catid='.$id;
	$stmt = $db->prepare($query);
	$stmt->execute();
	$res = $stmt->get_result();
}
else{
if(isset($_GET['valueprod'])){
		$prodid=$_GET['valueprod'];
		$queryp = 'select productid, price ,prodname from product where productid='.$prodid;
		$stmtp = $db->prepare($queryp);
		$stmtp->execute();
		$resp = $stmtp->get_result();
		while($rowp=$resp->fetch_assoc()) 
        $n=$rowp['prodname'];
	
	    $queryi = 'select productid, price from product where productid='.$prodid;
		$stmti = $db->prepare($queryi);
		$stmti->execute();
		$resi = $stmti->get_result();
		while($rowi=$resi->fetch_assoc()) 
        $p=$rowi['price'];
	}
}

if(isset($_POST['updatecat'])){
	$idcat = $_POST['idcat'];
	$namecat = $_POST['namecat'];
	
	$query = "update `category` SET `catid`=?,`name`=?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('is',$idcat,$namecat);
	$stmt->execute();
	$query = "update `collection` SET `catid`=?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('i',$idcat);
	$stmt->execute();
}

if(isset($_POST['updateprod'])){
	$productid = $_POST['productid'];
	$productname = $_POST['productname'];
	$productprice = $_POST['productprice'];
	
	$query = "update `product` SET `productid`=?,`prodname`=? ,`price`=?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('isi',$productid ,$productname,$productprice);
	$stmt->execute();
	$query = "update `collection` SET `productid`=?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('i',$productid);
	$stmt->execute();
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
	<link rel="stylesheet" href="css/style.css">
	
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
				<button style="font-family: arial; font-weight: normal;" class="dropbtn"><a href="homepage.php">Home</a></button>
				</div></li>
				
				<li><a href="login.php?bb=1">Log Out</a>	
				</li>
			</ul>
		</div>
		</div>
		</div>
	<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 color="white" >Update Category / Product</h3><br><br>
		      	<form action="update.php" class="signin-form" method="Post">
			     <div class="d-flex" >
				<div class="col-md-10" id="move" >				
				<h6> &nbsp &nbsp Update A Category</h6><br>
		      		<div class="form-group">
		      			<input class="form-control" name="idcat" placeholder="Category ID" value="<?php if(isset($_GET['valuecat'])) echo $id; ?>" >
		      		</div>
					<div class="form-group">
		      			<input class="form-control" name="namecat" placeholder="Category Name" value="<?php if(isset($_GET['valuecat'])){ while($row=$res->fetch_assoc()) echo $row['name'];} ?>">
		      		</div>
	                <div class="form-group">
						<input type="submit" name="updatecat" class="form-control btn btn-primary submit px-3" value="Update Category">
	                </div>
					</form>
				</div>
				<div class = "vertical"></div>
				<div class="col-md-10" >			  
				<h6> &nbsp &nbsp Update A Product</h6><br>
				<form action="update.php" class="signin-form" method="Post">
					<div class="form-group">
		      			<input class="form-control" name="productid" placeholder="Product ID" value="<?php if(isset($_GET['valueprod'])) echo $prodid ?>" >
		      		</div>
					<div class="form-group" >
						<input class="form-control" name="productname" placeholder="Product Name" value="<?php if(isset($_GET['valueprod'])) echo $n ?>" >
					</div>
					<div class="form-group" >
						<input class="form-control" name="productprice" placeholder="Product Price" value="<?php if(isset($_GET['valueprod'])) echo $p ?>">
					</div>
					<div class="form-group">
						<input type="submit" name="updateprod" class="form-control btn btn-primary submit px-3" value="Update Product">
	                </div>
				</form>
				</div>	
	            </div>
		      </div>
				</div>
			</div>
		</div>

</body>
</html> 

