<?php include("layouts/header.php"); ?>
		
		<div id="main">
			<h2>Answer</h2>
			
			The wine name is: <?php echo $_GET["wine"]; ?><br>
			The winery name is: <?php echo $_GET["winery"]; ?><br>
			The winery region is: <?php echo $_GET["region"]; ?><br>
			The grape variety is: <?php echo $_GET["variety"]; ?><br>
			The year is between: <?php echo $_GET["year1"]; ?> and <?php echo $_GET["year2"]; ?><br>
			The stock is: <?php echo $_GET["stock"]; ?><br>
			The order is: <?php echo $_GET["order"]; ?><br>
			The cost is: $<?php echo $_GET["cost"]; ?> <?php echo $_GET["minmax"];?><br>
		</div>
		
<?php include("layouts/footer.php"); ?>