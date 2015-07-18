<?php

   // Start session
   session_start();
   
   // Prevent direct access to page
   if (basename($_SERVER[HTTP_REFERER]) != "search.php") 
   {header("Location: search.php"); exit;}

   // Store retrieved values in local variables
   $wine = $_GET["wine"];
   $winery = $_GET["winery"];
   $region = $_GET["region"];
   $variety = $_GET["variety"];
   $year1 = $_GET["year1"];
   $year2 = $_GET["year2"];
   $stock = $_GET["stock"];
   $order = $_GET["order"];
   $cost1 = $_GET["cost1"];
   $cost2 = $_GET["cost2"];
   
   // Establish connection to database
   require_once('dblogin.php');   
   
   
   /* ----- Validate input and resolve query for 'wine name' search ----- */
   if (strlen($wine) == 0)
   {
      // Search field empty
      $wineQuery = "SELECT * FROM wine";
      $wineResult = $dbconn->query($wineQuery);
      $_SESSION["wineNameTest"] = $wineResult->fetchAll();
         
      $rows = 0;         
      foreach ($wineResult as $row)
      {
         $rows++;
      }
      $_SESSION["wineName"] = "No search input, matched all " . $rows . " wine name results.";
   }
   else
   {
      // Search field invalid
      if (!preg_match("/^[a-zA-Z]{1,50}$/", $wine))
      {
         $_SESSION["wineName"] = "Invalid search term, please use only letters and spaces (max 50) in search";
         $wineQuery = "SELECT * FROM wine";
         $wineResult = $dbconn->query($wineQuery);
      }
      else
      {
         // Search field valid
         $wineQuery = "SELECT * FROM wine WHERE wine_name LIKE '$wine'";  // Needs to be corrected to allow partial matches !!    
         $wineResult = $dbconn->query($wineQuery);
         
         $rows = 0;         
         foreach ($wineResult as $row)
         {
            $rows++;
         }   
         $_SESSION["wineName"] = $wine . ". Found " . $rows . " result(s).";
      }
   }
   
   
   /* ----- Validate input and resolve query for 'winery name' search ----- */
   if (strlen($winery) == 0)
   {
      // Search field empty
      $wineryQuery = "SELECT * FROM winery";
      $wineryResult = $dbconn->query($wineryQuery);
         
      $rows = 0;         
      foreach ($wineryResult as $row)
      {
         $rows++;
      }         
      $_SESSION["wineryName"] = "No search input, matched all " . $rows . " winery name results.";
   }
   else
   {
      // Search field invalid
      if (!preg_match("/^[a-zA-Z]{1,100}$/", $winery))
      {
         $_SESSION["wineryName"] = "Invalid search term, please use only letters and spaces (max 100) in search";
         $wineryQuery = "SELECT * FROM winery";
         $wineryResult = $dbconn->query($wineryQuery);
      }
      else
      {
         // Search field valid
         $wineryQuery = "SELECT * FROM winery WHERE winery_name LIKE '$winery'";  // Needs to be corrected to allow partial matches !!    
         $wineryResult = $dbconn->query($wineryQuery);
         
         $rows = 0;         
         foreach ($wineryResult as $row)
         {
            $rows++;
         }   
         $_SESSION["wineryName"] = $winery . ". Found " . $rows . " result(s).";
      }
   }

   
   /* ----- Resolve query for 'wine region' selection ----- */
   if($region == "1")
   {
      // All regions selected
      $regionQuery  = "SELECT * FROM region ";
      $regionResult = $dbconn->query($regionQuery);
      
      $rows = -1;         
      foreach ($regionResult as $row)
      {
         $rows++;
      }         
      $_SESSION["wineRegion"] = "All selected, matched all " . $rows . " region results.";     
   }
   else
   {
      // Specific region selected
      $regionQuery  = "SELECT * FROM region WHERE region.region_id = $region";
      $regionResult = $dbconn->query($regionQuery);
      
      $row = $regionResult->fetch(PDO::FETCH_OBJ);
      $_SESSION["wineRegion"] = $row->region_name . ".";      
   }
   
   
   /* ----- Resolve query for 'grape variety' selection ----- */
   if($variety == "all")
   {
      // All varities selected
      $varietyQuery  = "SELECT * FROM grape_variety ";
      $varietyResult = $dbconn->query($varietyQuery);
      
      $rows = 0;         
      foreach ($varietyResult as $row)
      {
         $rows++;
      }         
      $_SESSION["grapeVariety"] = "All selected, matched all " . $rows . " grape variety results.";      
   }
   else
   {
      // Specific variety selected
      $varietyQuery  = "SELECT * FROM grape_variety WHERE grape_variety.variety_id = $variety";
      $varietyResult = $dbconn->query($varietyQuery);
      
      $row = $varietyResult->fetch(PDO::FETCH_OBJ);
      $_SESSION["grapeVariety"] = $row->variety . ".";         
   }
   
   
   /* ----- Resolve query for 'year' selection ----- */
   if($year1 > $year2)
   {
      // Ensure smaller value is first
      $temp = $year1;
      $year1 = $year2;
      $year2 = $temp;
   }
   
   $yearQuery = "SELECT * FROM wine WHERE wine.year>='$year1' && wine.year<='$year2'";
   $yearResult = $dbconn->query($yearQuery);
   
   $rows = 0;         
   foreach ($yearResult as $row)
   {
      $rows++;
   }         
   $_SESSION["yearSelection"] = $year1 . " to " . $year2 . ". Found " . $rows . " result(s).";
   
   
   /* ----- Resolve query and input validation for 'minimum stock' selection ----- */
   if($stock == null)
   {
      // Any stock level selected
      $stockQuery = "SELECT * FROM inventory WHERE inventory.inventory_id != 2";
      $stockResult = $dbconn->query($stockQuery);
      
      $rows = 0;         
      foreach ($stockResult as $row)
      {
         $rows++;
      }         
      $_SESSION["minimumStock"] = "No search input, matched all " . $rows . " stock level results.";      
   }
   else
   {
      if (!preg_match("/^[0-9]{1,4}$/", $stock))
      {         
         // Invalid search
         $_SESSION["minimumStock"] = "Invalid search term, please choose a number 1-9999";
         $stockQuery = "SELECT * FROM inventory WHERE inventory.inventory_id != 2";
         $stockResult = $dbconn->query($stockQuery);         
      }
      else
      {
         // Valid search
         $stockQuery = "SELECT * FROM inventory WHERE inventory.inventory_id != 2 && inventory.on_hand >= '$stock'";
         $stockResult = $dbconn->query($stockQuery);
         
         $rows = 0;         
         foreach ($stockResult as $row)
         {
            $rows++;
         }         
         $_SESSION["minimumStock"] = $stock . ". Found " . $rows . " result(s).";
      }      
   }
   
   
   /* ----- Resolve query and input validation for 'previously ordered' selection ----- */
   
   
   /* ----- Resolve query and input validation for 'cost' selection ----- */
   if($cost1 != null || $cost2 != null)
   {   
      if((!preg_match("/^$|^\d+(\.\d{1,2})?$/", $cost1)) || (!preg_match("/^$|^\d+(\.\d{1,2})?$/", $cost2)))
      {
         // Invalid entry in to cost field
         $_SESSION["wineCost"] = "Invalid search term, please use a dollar and cents amount i.e. 16.50";
         $costQuery = "SELECT * FROM inventory";
         $costResult = $dbconn->query($costQuery);      
      }
      
      else if($cost1 != null && $cost2 != null)
      {    
         if($cost1 > $cost2)
         {
            // Ensure smaller value is first
            $temp = $cost1;
            $cost1 = $cost2;
            $cost2 = $temp;
         }
         
         $costQuery = "SELECT * FROM inventory WHERE inventory.cost >= '$cost1' && inventory.cost <= '$cost2' && inventory.inventory_id != 2";    
         $costResult = $dbconn->query($costQuery);
         
         $rows = 0;         
         foreach ($costResult as $row)
         {
            $rows++;
         }   
         $_SESSION["wineCost"] = "$" . $cost1 . " - $" . $cost2 . ". Found " . $rows . " result(s).";        
      }
      
      else if($cost1 != null && $cost2 == null)
      {
         $costQuery = "SELECT * FROM inventory WHERE inventory.cost >= '$cost1' && inventory.inventory_id != 2";    
         $costResult = $dbconn->query($costQuery);
         
         $rows = 0;         
         foreach ($costResult as $row)
         {
            $rows++;
         }   
         $_SESSION["wineCost"] = "$" . $cost1 . " or more. Found " . $rows . " result(s)."; 
      } 
   
      else if($cost1 == null && $cost2 != null)
      {
         $costQuery = "SELECT * FROM inventory WHERE inventory.cost <= '$cost2' && inventory.inventory_id != 2";    
         $costResult = $dbconn->query($costQuery);
         
         $rows = 0;         
         foreach ($costResult as $row)
         {
            $rows++;
         }   
         $_SESSION["wineCost"] = "$" . $cost2 . " or less. Found " . $rows . " result(s)."; 
      }      
   }  
   else
   {
      // Both cost fields empty
      $costQuery = "SELECT * FROM inventory WHERE inventory.inventory_id != 2";    
      $costResult = $dbconn->query($costQuery);
      
      $rows = 0;         
      foreach ($costResult as $row)
      {
         $rows++;
      }   
      $_SESSION["wineCost"] = "No cost specified. Found " . $rows . " result(s) of any cost.";  
   }
   
   
   // Redirect to result page
   $resultsPageURL = "result.php";
   header("Location: {$resultsPageURL}"); exit();
   
?>
