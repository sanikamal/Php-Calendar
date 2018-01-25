<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('Asia/Kolkata');
$siteURL = "http://localhost/Php-Calendar/";

$currentYear = ((int)$_REQUEST["year"] != 0 )  ? ((int)$_REQUEST["year"]) : date("Y");
$currentMonth = ((int)$_REQUEST["month"] != 0 )  ? ((int)$_REQUEST["month"]) : date("n");
$currentMonth = str_pad($currentMonth, 2, "0", STR_PAD_LEFT);

if ($currentMonth == 1 ) {
  $previousMonth = 12;
  $previousYear = $currentYear -1;
} else if ($currentMonth == 12 ) {
  $nextYear = $currentYear + 1;
  $nextMonth = 1;
} else {
  $previousYear = $currentYear;
  $nextYear = $currentYear;

  $previousMonth = $currentMonth-1;
  $nextMonth = $currentMonth + 1;
}

// variables needed to setup calendar
$first_day = mktime(0,0,0,$currentMonth,1,$currentYear); 
$maxday_month = date("t",$first_day); 
$thismonth = getdate($first_day); 
$week_start_day = $thismonth['wday']; 
if (!$thismonth['wday']) $week_start_day = 7;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sani kamal">
    <meta name="description" content="php calendar- Quest Innovation">
    <meta name="keywords" content="">
    <meta name="title" content="Php calendar">

    <title>Php calendar</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
  </head>
<body>

    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.hellotech633.wordpress.com"><span class="fa fa-home"></span> hellotech</a>
        </div>

      </div>

    </div>

    <div class="container mainbody">
      <div class="page-header">
        <h1>Php Calendar</h1>
      </div>
      <div class="clearfix"></div>

      <div class="container-fluid bg-danger">

        <div class="calendar bg-success">
                    
          <div class="mainheader">
          <table style="width: 100%;">
            <tr>
              <td style="text-align: left;">
                <a href="<?php echo $siteURL; ?>index.php?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear-1; ?>" class="btn btn-primary prev_year" >prev year</a>
                <a href="<?php echo $siteURL; ?>index.php?month=<?php echo $previousMonth; ?>&year=<?php echo $previousYear; ?>" class="btn btn-primary prev_month" >prev month</a>        
              </td>
              <td style="text-align: center;"><h2><?php echo date("F Y",strtotime($currentYear ."-".$currentMonth."-01")); ?></h2></td>
              <td style="text-align: right;">
                <a href="<?php echo $siteURL; ?>index.php?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="btn btn-primary next_month">next month</a>
                <a href="<?php echo $siteURL; ?>index.php?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear+1 ?>" class="btn btn-primary next_year">next year</a>
              </td>
            </tr>
          </table>
          </div>
          <div style="height:5px; clear:both; "></div>
          <div  class="maintable">
            <table class="">
            <tr>
              <td>Mon</td>
              <td>Tue</td>
              <td>Wed</td>
              <td>Thu</td>
              <td>Fri</td>
              <td>Sat</td>
              <td>Sun</td>
            </tr>
            <?php 
            for ($i=1; $i<($maxday_month+$week_start_day); $i++) { 
              
              if (($i % 7) == 1 ) echo "<tr>";
              if ($i < $week_start_day) { echo "<td>&nbsp;</td>"; continue; };
              
              
              $current_day = $i - $week_start_day + 1;
              $cday = str_pad($current_day, 2, "0", STR_PAD_LEFT);
              $currentDayCss = (date("Y-m-d") == $currentYear."-".$currentMonth."-".$cday) ? "selected" : "";
              
              echo "<td class='".$currentDayCss."'>". $current_day . "</td>";
	
              if (($i % 7) == 0 ) echo "</tr>";
            ?>
            
            <?php } 
            if (($i % 7) != 0 ) echo "</tr>";
            ?>
            </table>
          </div>
		  <div style="height:5px; clear:both; "></div>
          <table style="width: 100%;">
            <tr>
              <td align="left" >
                <?php 
                  $todaymonth=str_pad(date("m"), 2, "0", STR_PAD_LEFT);
                  $todayYear=date("Y");		  
                  ?>
                  <a href="<?php echo $siteURL; ?>index.php?month=<?php echo $todaymonth; ?>&year=<?php echo $todayYear; ?>" class="btn btn-primary">Back to today</a>
              </td>
              <td align="right">
                <b>Goto date:</b> &nbsp;
                <select name="month" id="month" class="selectbox">
				<?php 
				for($i=1; $i<=12; $i++) { 
                    $m=str_pad($i, 2, "0", STR_PAD_LEFT);
                    $sel = ($i == $currentMonth) ? " selected ": "";
					echo '<option value="'.$m.'" '.$sel.'>'.date("M", strtotime(date("Y-$i-01"))).'</option>';
				}
				?>
                 </select>
                <select name="year" id="year"  class="selectbox">
				<?php 
				for($i=1902; $i<2038; $i++) {
                    $sel = ($i == $currentYear ) ? " selected ": "";
					echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
				}
				?>
			   </select>
                <input type="button" value="show" class="btn btn-primary" onclick="gotoDate();" >
              </td>
            </tr>
          </table>
          
        </div>
      </div>
      <div style="clear: both; height: 10px;"></div>
    </div>
  <footer>
    <div class="navbar navbar-inverse footer">
      <div class="container-fluid">
        <div class="copyright">
          <a href="http://www.hellotech633.wordpress.com" target="_blank">&copy; hellotech  2018 - <?php echo date("Y"); ?> All rights reserved</a>
        </div>
      </div>
    </div>
  </footer>
  <script>
    function gotoDate() {
      var m = jQuery("#month").val();
      var y = jQuery("#year").val();
      window.location.href = "<?php echo $siteURL; ?>index.php?month="+m+"&year="+y;
    }
  </script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>