
<!-- Database code -->

<?php
   // Handles database access
   require_once('dblogin.php');
?>



<!-- Start HTML --> 

<?php 
   // Includes header HTML
   include("layouts/header.php"); 
?>	
   	
<div id="main">
   <div id="container">			
      <h2>Winestore Database Search</h2>
      
      <!-- Search criteria form -->
      <form action="answer.php" method="get">
         <fieldset id="field">
	        Wine Name: <input type="text" name="wine" id="wine"/><br>
	        Winery Name: <input type="text" name="winery" id="winery"/><br>
						
	        Region:
            <?php 
               $regions  = "SELECT region.* ";
               $regions .= "FROM region"; 
            ?>
            
            <select name="region">
               <?php
                  $count=1;
                  foreach ($dbconn->query($regions) as $row){
               ?>
               <option value="<?php echo $count ?>"><?php echo $row["region_name"]?></option>
               <?php
                  $count++; }               
               ?>  
            </select><br>

	        Grape Variety:
            <?php 
               $grapes  = "SELECT grape_variety.* ";
               $grapes .= "FROM grape_variety";
            ?>
            
            <select name="variety">
               <option value="all">All</option>                         <!-- THIS IS AN ADDED VALUE AND MUST BE CONSIDERED IN ANSWER/RESULTS  -->
               <?php
                  $count=1;
                  foreach ($dbconn->query($grapes) as $row)
                  {
               ?>
               <option value="<?php echo $count ?>"><?php echo $row["variety"]?></option>
               <?php
                  $count++; }               
               ?> 
            </select><br>
				
            Year:
            <?php 
               $ascYear = $dbconn->prepare("SELECT wine.year 
                           					FROM wine 
                           					ORDER BY year ASC");
               $ascYear->execute();
               $minYear = $ascYear->fetchColumn();
            
               $descYear = $dbconn->prepare("SELECT wine.year 
                                       		 FROM wine 
                                       		 ORDER BY year DESC");
               $descYear->execute();
               $maxYear = $descYear->fetchColumn();
            ?>
            
            <select name="year1">
               <?php  
                  for($i = $minYear; $i<$maxYear; $i++)
                  { ?>
                     <option value="<?php echo $i ?>"><?php echo $i ?></option> <?php 
                  } 
               ?>
            </select>
            to
            <select name="year2">
               <?php 
                  for($i = $maxYear; $i>$minYear; $i--)
                  { ?>
                     <option value="<?php echo $i ?>"><?php echo $i ?></option> <?php 
                  } 
               ?>
            </select><br>
            
	        Minimum Stock Available: <input type="text" name="stock" id="stock"/><br>
	        Minimum Previously Ordered: <input type="text" name="order" id="order"/><br>
	        
            Cost: $<input type="text" name="cost1" id="cost1"/> to $<input type="text" name="cost2" id="cost2"/>
            
            <br></br>
					    
	        <input type="submit" value="Process Search"/>
            <input type="reset" value="Reset Form"/>				

         </fieldset>
      </form>
   </div>
</div>
		
<?php
   // Includes footer HTML and close database connection
   include("layouts/footer.php"); 
?>

