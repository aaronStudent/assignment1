
<?php 

   // Start sesison
   session_start();

?>


<!-- Start HTML --> 

<?php 
   // Includes header HTML
   include("layouts/header.php"); 
?>

<div id="main">
   <div id="container">    	
      <h2>Result</h2>
   
      <h4>Search Summary</h4>
      Wine name: <?php echo $_SESSION["wineName"] ?><br>
      Winery name: <?php echo $_SESSION["wineryName"] ?><br>
      Wine region: <?php echo $_SESSION["wineRegion"] ?><br>
      Grape variety: <?php echo $_SESSION["grapeVariety"] ?><br>
      Year between: <?php echo $_SESSION["yearSelection"] ?><br>
      Minimum stock: <?php echo $_SESSION["minimumStock"] ?><br>
      Order: <br>
      Cost: <?php echo $_SESSION["wineCost"] ?><br><br>
      
      <form method="link" action="search.php">
         <input type="submit" value="New Search">
      </form><br><br><br>

      
      <h4>Search Results</h4>
      <table style="width:600px">
         <tr>
            <th>Wine Name</td>
            <th>Grape Varieties</td>
            <th>Year</td>
            <th>Winery</td>
            <th>Region</td>
            <th>Cost</td>
            <th>Stock On Hand</td>
            <th>Available Price</td>
            <th>Total Stock Sold</td>
            <th>Total Revenue</td>
         </tr>
         <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
         </tr>
      </table>
   </div>     
</div>
  
<?php
   // Includes footer HTML and close database connection
   include("layouts/footer.php"); 
?>

<?php
   // remove all session variables
   session_unset();
   
   // destroy the session
   session_destroy();
?>



