<?php 
   // Link to database login details
   require_once('dblogin.php');
   
   // Create a database connection 
   $dbconn = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);
   
   if(!$dbconn)
   {
      die('No connection (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
   }   
   echo 'Connected to MySQL on ' . DB_HOST . ', to Database: ' . DB_NAME .".<br/><br/><br/>\n";
?>

<?php 
   // Region Database Query
   $regions  = "SELECT region.* ";
   $regions .= "FROM region";   
   $regionResult = mysqli_query($dbconn, $regions);
   
   if (!$regionResult)
   {
      die("Database query failed while looking for region table.");
   }
   
   // Grape Variety Database Query
   $grapes  = "SELECT grape_variety.* ";
   $grapes .= "FROM grape_variety";
   $grapeResult = mysqli_query($dbconn, $grapes);
   
   if (!$grapeResult)
   {
      die("Database query failed while looking for grape variety table.");
   }
   
   // Wine Year Database Query
   $year  = "SELECT wine.year ";
   $year .= "FROM wine ";
   $year .= "ORDER BY year ASC";
?>


<?php 
   // Include header HTML
   include("layouts/header.php"); 
?>
		
		<div id="main">
			<div id="container">			
				<h2>Winestore Database Search</h2>
		
				<form>
					<fieldset id="field">
						Wine Name: <input type="text" name="wine" id="wine"/><br>
						Winery Name: <input type="text" name="winery" id="winery"/><br>
						
						Region: <select id="region">
                                   <?php  
                                   $rows = mysql_num_rows($regionResult); 
                                   $count=1;

								   while($row = mysqli_fetch_assoc($regionResult))
								   {?>
                                      <option value="<?php $count ?>"><?php echo $row["region_name"]?></option>
								      <?php $count++;  
								   }?>
								</select><br>
								
						Grape Variety: <select id="variety">
                                          <?php  
                                          $rows = mysql_num_rows($grapeResult); 
                                          $count=1;

								          while($row = mysqli_fetch_assoc($grapeResult))
								          {?>
                                 		     <option value="<?php $count ?>"><?php echo $row["variety"]?></option>
								 		     <?php $count++;  
								          }?>
									   </select><br>
								
					    Year: <input type="text" name="year" id="year"/><br>
					    Minimum Stock: <input type="text" name="stock" id="stock"/><br>
					    Minimum Order: <input type="text" name="order" id="order"/><br>
					    Cost: $<input type="text" name="cost" id="cost"/>
					    	  <select>
					    	     <option value="minimum">Minimum</option>
					    	     <option value="maximum">Maximum</option>					    	     
					    	  </select><br></br>
					    
						<input type="reset" value="Reset Form"/>				
						<input type="button" onclick="return processOrder();" value="Process Search"/>
					</fieldset>
				</form>
			</div>
		</div>
		
<?php include("layouts/footer.php"); ?>

<?php 
   //5. Close connection
   mysqli_close($dbconn);
?>

