
<!-- Database code -->

<?php
   // Handles database access
   require_once('dblogin.php');

   // Region Database Query
   $regions  = "SELECT region.* ";
   $regions .= "FROM region";   
   
   // Grape Variety Database Query
   $grapes  = "SELECT grape_variety.* ";
   $grapes .= "FROM grape_variety";

   // Wine Year Database Query  
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


<!-- Start HTML --> 

<?php 
   // Includes header HTML
   include("layouts/header.php"); 
?>	
   	
<div id="main">
   <div id="container">			
      <h2>Winestore Database Search</h2>
      
      <form action="answer.php" method="get">
         <fieldset id="field">
	        Wine Name: <input type="text" name="wine" id="wine"/><br>
	        Winery Name: <input type="text" name="winery" id="winery"/><br>
						
	        Region: 
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
            <select name="variety">
               <option value="all">All</option>
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
            
	        Minimum Stock: <input type="text" name="stock" id="stock"/><br>
	        Minimum Order: <input type="text" name="order" id="order"/><br>
	        
            Cost: $<input type="text" name="cost" id="cost"/>
	               <select name="minmax">
	                  <option value="minimum">Minimum</option>
	                  <option value="maximum">Maximum</option>					    	     
	               </select><br></br>
					    
	        <input type="submit" value="Process Search"/>
            <input type="reset" value="Reset Form"/>				

         </fieldset>
      </form>
   </div>
</div>
		
<?php
   // Includes footer HTML 
   include("layouts/footer.php"); 
?>

<!-- Close database connection -->
<?php $dbconn = null; ?>

