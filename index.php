<?php
/* Resume Infographic Timeline Project
Created by Neil McWilliam for Qimple.com 
Initial Release date = Aug 25, 2014 */

/* Set the default timezone to EST */
date_default_timezone_set('America/Toronto');

/* Set last year for infographic */
$lastYear = date("Y");

/* Set first year for infographic (12 year timeline) */
$firstYear = $lastYear - 11;

// If Form Submitted
if (isset($_POST['profileSelected'])) {
	
	// POST Vars
	$profileSelected = $_POST['profileSelected'];
	
	/* Set JSON file */
	$json = file_get_contents("json_data/".$profileSelected);
	
// If No Form Submitted
} else {
	
	/* Set JSON file */
	$json = file_get_contents("json_data/profile_1071.json");
}

/* json_decode */
$links = json_decode($json, TRUE);

/* z-index settings */
$zIndexSource = 1000;
$zIndexSourceText = 2000;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Neil McWilliam">
	<meta name="description" content="This project loads resume data from json source and displays it in a timeline infographic.">
	<meta name="msapplication-config" content="none"/><!-- IE 404 browserconfig.xml prevent -->
	
	<!-- Page Title -->
	<title>Qimple.com &middot; A resume infographic timeline project.</title>
	
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/infographic.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	
	<!-- IE10 in Windows 8 and Windows Phone 8 Fixes for viewport -->
	<style>
	@-webkit-viewport   { width: device-width; }
	@-moz-viewport      { width: device-width; }
	@-ms-viewport       { width: device-width; }
	@-o-viewport        { width: device-width; }
	@viewport           { width: device-width; }
	</style>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->
	
  </head>

  <body>

	<div class="container-fluid containerWhite" style="border-top: 1px solid rgba(165, 165, 165, 1);">
	  <div class="row">
	    <div class="col-lg-12 center-block">
		  
		  <div class="container">
		    <div class="row">
		      <div class="col-lg-12 text-center">
		      	    
		      	    <div class="row">
		      	      <div class="col-sm-12" style="margin-bottom: 50px;">
			      	    <form class="form-inline" role="form" action="index.php" method="POST" name="profileViewForm" id="profileViewForm">
			      	      <div class="form-group">
			      	        <div class="input-group">
					      	    <select class="form-control" id="profileSelected" name="profileSelected">
					      	      <option value="profile_1071.json" <?php if (isset($_POST['profileSelected']) && $_POST['profileSelected']=='profile_1071.json'){ echo "selected='selected'"; } ?>>Profile 1</option>
					      	      <option value="profile_1093.json" <?php if (isset($_POST['profileSelected']) && $_POST['profileSelected']=='profile_1093.json'){ echo "selected='selected'"; } ?>>Profile 2</option>
					      	      <option value="profile_1056.json" <?php if (isset($_POST['profileSelected']) && $_POST['profileSelected']=='profile_1056.json'){ echo "selected='selected'"; } ?>>Profile 3</option>
					      	    </select>
					      	</div>
					      	<input type="hidden" class="form-control" id="profileViewDetect" name="profileViewDetect" value="yes">
					      	<button type="submit" class="btn btn-default">View</button>
					      </div>
					    </form>
					  </div>
					</div>
		      	    
		      	    		      	    
		      	    <?php
					echo "<div class='row'>";
						echo "<div class='col-xs-12 experienceBox'>";
						
							echo "<p class='titleExperience'><span class='titleStyling'>WORK EXPERIENCE</span></p>";
							
							/* Grab experience */
				      	    foreach($links['experience'] as $key=>$val){
				      	    	
				      	    	/* If $val['end_year'] >= $firstYear */
				      	    	if ($val['end_year'] >= $firstYear || $val['end_year']=="Current"){

				      	    		/* Set required variables */
				      	    		$totalTimelineYears = 12;
				      	    		$firstWorkMonth = $val['start_month'];
				      	    		$firstWorkYear = $val['start_year'];
				      	    		$lastWorkMonth = $val['end_month'];
				      	    		$lastWorkYear = $val['end_year'];
				      	    		
				      	    		/* Currently working here */
				      	    		if (isset($lastWorkYear) && $lastWorkYear=="Current"){
				      	    		
				      	    			/* Set the dates to this year and month */
				      	    			$lastWorkYear = date('Y');
				      	    			$lastWorkMonth = date('n');
				      	    			
				      	    			/* Set the border top right radius to nothing */
				      	    			$topRightRadius = 'border-top-right-radius: 0px 0px;';
				      	    		
				      	    		/* Not currently working here */
				      	    		} else {
				      	    			/* Set the border top right radius to something */
				      	    			$topRightRadius = 'border-top-right-radius: 150px 10px;';
				      	    		}
				      	    		
				      	    		/* Starting Work Year NOT within infographic timeline */
				      	    		if (isset($firstWorkYear) && $firstWorkYear<$firstYear){
				      	    		
				      	    			/* Set all variables to start at the beginning of the timeline */
				      	    			$firstWorkYear = $firstYear;
				      	    			$firstWorkMonth = 1;
				      	    			$divStartingPosition = 0;
				      	    			$paddingLeftYear = 0;
				      	    			$paddingLeftMonth = 0;
				      	    			$paddingLeft = 0;
				      	    			
				      	    			/* Turn off top left radius */
				      	    			$topLeftRadius = 'border-top-left-radius: 0px 0px;';
				      	    			
				      	    		/* Starting Work Year within infographic timeline */
				      	    		} else {
				      	    			
				      	    			/* Turn on top right radius */
				      	    			$topLeftRadius = 'border-top-left-radius: 150px 10px;';
				      	    			
				      	    			/* Determine difference between $firstWorkYear vs $firstYear on timeline */
				      	    			$divStartingPosition = $firstWorkYear - $firstYear;
				      	    			
				      	    			/* Set $paddingLeftYear */
				      	    			$paddingLeftYear = $divStartingPosition / 12;
				      	    			
				      	    			/* Convert $firstWorkMonth to integer */
				      	    			if ($firstWorkMonth=="Jan"){
				      	    				$firstWorkMonth = 1;
				      	    			} else if ($firstWorkMonth=="Feb"){
				      	    				$firstWorkMonth = 2;
				      	    			} else if ($firstWorkMonth=="Mar"){
				      	    				$firstWorkMonth = 3;
				      	    			} else if ($firstWorkMonth=="Apr"){
				      	    				$firstWorkMonth = 4;
				      	    			} else if ($firstWorkMonth=="May"){
				      	    				$firstWorkMonth = 5;
				      	    			} else if ($firstWorkMonth=="Jun"){
				      	    				$firstWorkMonth = 6;
				      	    			} else if ($firstWorkMonth=="Jul"){
				      	    				$firstWorkMonth = 7;
				      	    			} else if ($firstWorkMonth=="Aug"){
				      	    				$firstWorkMonth = 8;
				      	    			} else if ($firstWorkMonth=="Sep"){
				      	    				$firstWorkMonth = 9;
				      	    			} else if ($firstWorkMonth=="Oct"){
				      	    				$firstWorkMonth = 10;
				      	    			} else if ($firstWorkMonth=="Nov"){
				      	    				$firstWorkMonth = 11;
				      	    			} else if ($firstWorkMonth=="Dec"){
				      	    				$firstWorkMonth = 12;
				      	    			}
				      	    			
				      	    			/* Calculate Excess Left padding for Month Start */
				      	    			$paddingLeftMonth = $firstWorkMonth / 144;
				      	    			
				      	    			/* Add $paddingLeftMonth & $paddingLeftYear together to get official starting position */
				      	    			$paddingLeft = ( $paddingLeftMonth + $paddingLeftYear ) * 100;
				      	    			$paddingLeft = round($paddingLeft, 1);
				      	    			
				      	    			/* Set paddingLeft to 0 */
				      	    			if ($paddingLeft <= 0){
				      	    				$paddingLeft = 0;
				      	    			}
				      	    		}
				      	    		
				      	    		/* Calculate total months worked */
				      	    		$d1 = strtotime($firstWorkYear."-".$firstWorkMonth."-01");
				      	    		$d2 = strtotime($lastWorkYear."-".$lastWorkMonth."-01");
				      	    		$min_date = min($d1, $d2);
				      	    		$max_date = max($d1, $d2);
				      	    		$m = 0;
				      	    		while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
				      	    		    $m++;
				      	    		}
				      	    		$totalMonthsWorked = $m;

				      	    		/* Calculate total width */
				      	    		$width = ( $totalMonthsWorked / 144 ) * 100;
				      	    		$width = round($width, 1);
				      	    		
				      	    		/* Calculate right padding */
				      	    		$totalWidthCapable = '100';
				      	    		if (isset($lastWorkYear) && $lastWorkYear=="Current"){
				      	    			$paddingRight = 0;
				      	    		} else {
				      	    			$paddingRight = $totalWidthCapable - $paddingLeft - $width;
				      	    		}
				      	    		
				      	    		/* Add %'s on padding variables */
				      	    		$paddingLeft = 'padding-left:'.$paddingLeft.'%;';
				      	    		$paddingRight = 'padding-right:'.$paddingRight.'%;';
				      	    		
				      	    		/* Select a random color */
				      	    		$color = rand(1, 10);
				      	    		$color = 'color'.$color;
				      	    		
				      	    		/* Increment the z-indexes */
				      	    		$zIndexSource = $zIndexSource - 1;
				      	    		$zIndex = 'z-index:'.$zIndexSource.';';
				      	    		$zIndexText = 'z-index:'.$zIndexSourceText.';';
				      	    		
				      	    		/* Generate the infographic div */
				      	    		echo "<div class='col-xs-12 containerInfographic' style='".$paddingLeft." ".$paddingRight." ".$zIndex."'>";
				      	    			
				      	    			echo "<div class='infographicBlock transparency center-block ".$color."' style='".$zIndex." ".$topLeftRadius." ".$topRightRadius."'>";
				      	    			
				      	    				echo "<div class='infographicText center-block' style='".$zIndexText."'><strong>".$val['title']."</strong><br>".$val['company']."<br><span class='locationText'>".$val['location']."</span></div>";
				      	    			
				      	    			echo "</div>";
				      	    			
				      	    		echo "</div>";
				      	    		
				      	    	/* $val['end_year'] is older than our infographic starting year */	
				      	    	} else {
				      	    		
				      	    		/* More code can be added later */
				      	    	}
				      	    }
			      	    
			      	    echo "</div>";
		      	    echo "</div>";
		      	    
					echo "<div class='row'>";
						echo "<div class='col-xs-12 timelineStyle'>";
				      	    /* Create the timeline*/
				      	    for ($i=$firstYear; $i<=$lastYear; $i++) {
								if ($i > $lastYear){
									break;
								}
				      	        echo "<div class='col-xs-1 yearBox'>".$i."</div>";
				      	    }
				      	echo "</div>";
		      	    echo "</div>";
		      	    
		      	    echo "<div class='row'>";
			      	    echo "<div class='col-lg-12 educationBox'>";
			      	    
				      	    /* Grab education */
				      	    foreach($links['education'] as $key=>$val){
				      	   		
				      	   		/* If $val['graduation_year'] >= $firstYear */
				      	    	if ($val['graduation_year']>=$firstYear || $val['graduation_year']=="Current"){
				      	    		
				      	    		/* Set required variables */
				      	    		$totalTimelineYears = 12;
				      	    		$graduationYear = $val['graduation_year'];
				      	    		$startYear = $val['start_year'];
				      	    		
				      	    		/* If High School, set graduation year */
				      	    		if ($val['level']=="High School"){
				      	    			$startYear = $graduationYear - 4;
				      	    		} 
				      	    		
				      	    		/* Are they currently working there? */
				      	    		if ($graduationYear=="Current"){
				      	    			$graduationYear = date('Y');
				      	    		}
				      	    		
				      	    		/* Determine difference between $startYear vs $firstYear on timeline */
				      	    		$divStartingPosition = $startYear - $firstYear;
				      	    		
				      	    		/* Set $paddingLeftYear */
				      	    		$paddingLeftYear = $divStartingPosition / 12;
				      	    		
				      	    		/* Add $paddingLeftMonth & $paddingLeftYear together to get official starting position */
				      	    		$paddingLeft = $paddingLeftYear * 100;
				      	    		if ($paddingLeft <= 0){
				      	    			$paddingLeft = 0;
				      	    		}
				      	    		
				      	    		/* Calculate total months at school */
				      	    		if ($startYear < $firstYear){
				      	    			$startYear = $firstYear;
				      	    		}
				      	    		$d1 = strtotime($startYear."-01-01");
				      	    		$d2 = strtotime($graduationYear."-01-01");
				      	    		$min_date = min($d1, $d2);
				      	    		$max_date = max($d1, $d2);
				      	    		$m = 0;
				      	    		while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
				      	    		    $m++;
				      	    		}
				      	    		$totalMonthsSchool = $m;

				      	    		/* Calculate total width */
				      	    		$width = ( $totalMonthsSchool / 144 ) * 100;
				      	    		$width = round($width, 1);
				      	    		
				      	    		/* Calculate right padding */
				      	    		$totalWidthCapable = '100';
				      	    		$paddingRight = $totalWidthCapable - $paddingLeft - $width;
				      	    		
				      	    		/* Add %'s on padding variables */
				      	    		$paddingLeft = 'padding-left:'.$paddingLeft.'%;';
				      	    		$paddingRight = 'padding-right:'.$paddingRight.'%;';
				      	    		
				      	    		/* Select a random color */
				      	    		$color = rand(1, 10);
				      	    		$color = 'color'.$color;
				      	    		
				      	    		/* Increment the z-indexes */
				      	    		$zIndexSource = $zIndexSource - 1;
				      	    		$zIndex = 'z-index:'.$zIndexSource.';';
				      	    		$zIndexText = 'z-index:'.$zIndexSourceText.';';
				      	    		
				      	    		/* Generate the infographic data */
				      	    		echo "<div class='col-xs-12 containerInfographic2' style='".$paddingLeft." ".$paddingRight." ".$zIndex."'>";
				      	    			
				      	    			echo "<div class='infographicBlock2 transparency center-block ".$color."' style='".$zIndex."'>";
				      	    			
				      	    				echo "<div class='infographicText2 center-block' style='".$zIndexText."'><strong>".$val['level']."</strong><br>".$val['school']."<br><span class='locationText'>".$val['location']."</span></div>";
				      	    			
				      	    			echo "</div>";
				      	    			
				      	    		echo "</div>";
				      	    		
				      	    	/* $val['graduation_year'] is older than our infographic starting year */	
				      	    	} else {
				      	    		
				      	    		/* Generate the infographic data */
				      	    		echo "<div class='col-xs-12 containerInfographic2' ".$zIndex."'>";
				      	    		
				      	    			echo "<div class='infographicBlock2 center-block style='".$zIndex."'>";
				      	    			
				      	    				echo "<div class='infographicText2 center-block' style='".$zIndexText."'><span class='locationText'>No Educational data within timeline</span></div>";
				      	    			
				      	    			echo "</div>";
				      	    			
				      	    		echo "</div>";
				      	    	}
				      	   		
				      	   		/*echo $val['level']."<br>".$val['school']."<br>".$val['location']."<br>";
				      	   		echo $val['start_year']." ";
				      	   		echo $val['graduation_year']."<br><br>";*/
				      	    }
				      	    
				      	    echo "<p class='titleEducation'><span class='titleStyling2'>EDUCATION</span></p>";
			      	    
			      	    echo "</div>";
		      	    echo "</div>";
		      	    ?>
          
              </div><!-- /col-lg-12 -->
            </div><!-- /row -->
          </div><!-- /container-->
          
        </div><!-- /col-lg-12 -->
      </div><!-- /row -->
    </div><!-- /container-fluid -->

    <div class="footer">
	</div>
	
	<!-- Footer JS (loaded at end for speed) -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.min.js"></script>
	
	<!-- JQuery Placeholder -->
	<script src="js/jquery.placeholder.js"></script>
	<script>
	$(function() {
		// Invoke the plugin
		$('input, textarea').placeholder();
	});
	</script>
	
	<!-- IE10 Viewport Fix -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>
	
  </body>
</html>