
<?php
  $user = 'a01449508';
  $pass = 'gulmira';
  $database = 'lab';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>

<html>
<title>jobsuche plattform: CareerSuccess</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">CareerSuccess</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="benutzer.php">Benutzer</a></li>
	<li><a href="bewerber.php">Bewerber</a></li>
	<li><a href="cv.php">Lebenslauf</a></li>
	<li><a href="firma.php">Firmen</a></li>
      <li><a href="job.php">Jobs</a></li>
	<li> <a href="kategorie.php">Kategorie</a></li>
	 <li><a href="apply.php">sich bewerben</a></li>
		<li><a href="view.php">Views</a></li>	
    </ul>
  </div>
</nav>

<?php $query="SELECT kategname FROM kategorie";
    $editWR=oci_parse($conn,$query);
    oci_execute($editWR);?>

<div class="container">
  <form id='searchform' action="index.php"  method='get'>
   <center>
<h2> Job finden by Kategorie und Anstellungsart:</h2>
     <table class="table table-striped">
	  <thead>
	    <tr>
		  <th>Kategorie</th>
		  <th>Anstellungsart</th>
	    </tr>
	  </thead>
	  <tbody>
	  <div class="form-group">
	     <tr>
	        <td>
      <select class="form-control"  name="weekid" id="weekid" value='<?php if (isset($_GET['weekid'])) echo $_GET['weekid']; ?>'>
                   <?php echo '<OPTION VALUE="">'."Select".'</OPTION>';
    while($row = oci_fetch_array($editWR,OCI_ASSOC))
    {
    $WID=$row ['KATEGNAME'];
    echo'<OPTION VALUE='."$WID".'>'.$WID.'</OPTION>'; 
    }?> </select>  </td>
	<td>
	<select class="form-control"   name='art' id="art" value='<?php if (isset($_GET['art'])) echo $_GET['art']; ?>'>
	<OPTION VALUE="">Select</OPTION>';
        <option>Vollzeit</option>
        <option>Teilzeit</option>
        <option>Gerinfuegig</option>
        <option>Praktikum</option>
      </select>
</td>
				</div>
	      </tr>
           </tbody>
        </table>
        <input  type="submit" class="btn btn-info" value="los" />
	</center>	
  </form>
</div>

 <div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="16.jpg" alt="Chania" width="460" height="345">
        <div class="carousel-caption">
          <h3>Promotion</h3>
          <p>How to Achieve Career Success?</p>
        </div>
      </div>

      <div class="item">
        <img src="11.jpg" alt="Chania" width="460" height="345">
        <div class="carousel-caption">
          <h3>Your Chance</h3>
          <p>Key to Career Success.</p>
        </div>
      </div>
    
      <div class="item">
        <img src="12.jpg" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Future</h3>
          <p>Secret to Career Success.</p>
        </div>
      </div>

      <div class="item">
        <img src="13.jpg" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Just add CV</h3>
          <p>Does Your Resume Make a Good First Impression?</p>
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div> 
 
<?php
  // check if search view of list view
  if (isset($_GET['weekid'])) {
    $sql = "SELECT * FROM alle_jobs WHERE kategname like '%" . $_GET['weekid'] . "%' and ANSTELUNGSART like '%" . $_GET['art'] . "%' ";
  } else {
    $sql = "SELECT * FROM alle_jobs";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

<div class="container">
  <h2> </h2>
  <p> </p>            
  <table class="table table-bordered">
    <thead>
      <tr>
	  <th>CVid</th>
        <th>Titel</th>
		<th>Kategorie</th>
		<th>Anstellungsart</th>      
        <th>Beschreibung</th>
        <th>Gehalt</th>
		<th>Kontakt info</th>
      </tr>
    </thead>
	<tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo " <tr>";
	echo "<td>" . $row['VACANCYID'] . "</td>";
    echo "<td>" . $row['TITLE'] . "</td>";
    echo "<td>" . $row['KATEGNAME'] . "</td>"; 
    echo "<td>" . $row['ANSTELUNGSART'] . "</td>"; 
	echo "<td>" . $row['BESCHREIBUNG'] . "</td>"; 
	echo "<td>" . $row['GEHALT'] . "</td>";  
	echo "<td>"  . $row['ORT'] .  " , " . $row['ADRESSE'] .  " , " . $row['EMAIL'] . " , " . $row['TELEFONNUMER'] .  "</td>";
	echo " </tr>";
  }
?>
</tbody> 
</table> </div>
   
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Stellenangebot(en) gefunden!</div>
<?php  oci_free_statement($stmt);
oci_close($conn); ?>
</body>
</html>

