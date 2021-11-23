<?php
session_start();
if(isset($_SESSION['usr']) || isset($_COOKIE['usr'])){
}
else
	header("Location: login.php");

require('connection.php');

if(isset($_GET['id'])){
$idd=$_GET['id'];
$db = connect();
$query ='select distinct product.productid,collection.productid,prodname,price,collection.catid from product,collection,category where product.productid=collection.productid and collection.catid='.$idd;
$stmt = $db->prepare($query);
$stmt->execute();
$res = $stmt->get_result();
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
				<button style="font-family: arial; font-weight: normal;" class="dropbtn"><a href="homepage.php">Home</a></button>
				</div></li>
				
				<li><a href="login.php?bb=1">Log Out</a>	
				</li>
			</ul>
		</div>
		</div>
		</div>
<div class="container">
<div class="row">
<div class="col-sm-12">
	<!-- Category -->
	<div class="single category">
		<h3 class="side-title">Product List</h3>
		<ul class="list-unstyled">
		<?php
		    while($row=$res->fetch_assoc()){
				
			echo'<li>'.$row["prodname"].'<span class="pull-right">'.$row["price"].'</span></li>';
            echo'<p></p>';			
			}
	    ?>
		</ul>
		
   </div>
</div> 
</div>
</div>