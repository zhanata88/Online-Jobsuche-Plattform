<?php
  $user = 'a01449508';
  $pass = 'gulmira';
  $database = 'lab';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>

<html>
<title>CareerSuccess: Mitarbeiter</title>
<head>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">CareerSuccess</a>
    </div>
        <ul> 
		<ul class="nav navbar-nav">
      <li><a href="benutzer.php">Benutzer</a></li>
	<li ><a href="bewerber.php">Bewerber</a></li>
	<li><a href="cv.php">Lebenslauf</a></li>
	<li><a href="firma.php">Firmen</a></li>
      <li><a href="job.php">Jobs</a></li>
	    <li><a href="kategorie.php">Kategorie</a></li>
		 <li><a href="apply.php">sich bewerben</a></li>
		<li class="active"><a href="view.php">Views</a></li>	
       </ul>

</div>
</nav>
<br></br>

<div id="wrapper">
<center>
<h1>Min.Gehalt der Stellenangeboten</h1>
  <?php
    $sql = "Select * From vacancy_min_gehalt ";
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <div class="container">
     <table class="table table-bordered">
     <tbody>
    
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['GEHALT'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
  </div>

<h1>Durschnittsgehalt der Stellenangeboten</h1>
  <?php
    $sql = "Select * From gehaltAVG";
  

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <div class="container">
     <table class="table table-bordered">
        <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['GEHALT'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
  </div>

<h1>Die Anzahl der Stellenangeboten  </h1>
  <?php
    $sql = "Select * From job_count";
  

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <div class="container">
     <table class="table table-bordered">
        <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['VACANCYID'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
  </div>

  
<h1>Die Anzahl der Bewerbern</h1>
 <?php
    $sql = "Select * From bewerber_count1 ";
  

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>
  <div class="container">
     <table class="table table-bordered">
        <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['VORNAME'] . "</td>";
    echo "</tr>";
  }
?>

<br>
<br>

</div>
</body>
</html>
