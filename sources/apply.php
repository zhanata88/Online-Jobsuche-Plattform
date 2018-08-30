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
	    <li class="active"><a href="apply.php">sich bewerben</a></li>
		<li><a href="view.php">Views</a></li>	
       </ul>

</div>
</nav>

<div>
    <form id='searchform' action='apply.php' method='get' class="form-inline">
      <a href='benutzer.php'>Alle Bewerbungen</a> ---  
	  <div class="form-group">
	  <label for="focusedInput">  Suche nach Jobid: </label>
      <input class="form-control"  id='search' name='search' type='text' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' class="btn btn-default" value='Search' />
    </form>
  </div>
  
  <?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM apply WHERE vacancyid like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM apply";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

  
<br></br>

<div>
  <form id='insertform' action='apply.php' method='get'>
<center>
<h1>sich bewerben um:</h1>
<br>
    
	<div class="container">
     <table class="table table-bordered">
	  <thead>
	    <tr>
	      <th>email des bewerbers</th>
		  <th> bewerbet sich um Job_ID</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
		 <div class="form-group">
                <td>
				<input id='mail' name='mail' type='text' class="form-control" value='<?php if (isset($_GET['mail'])) echo $_GET['mail']; ?>' />
                  
                </td>
				<td>
                    <input id='vcid' name='vcid' type='number' class="form-control" value='<?php if (isset($_GET['vcid'])) echo $_GET['vcid']; ?>' />
                </td>			  
                 </div>
	      </tr>
           </tbody>  
		   </table>
  <input  type="submit" class="btn btn-info" value="insert" />
</center> 
  </form>
</div>
<br>
<br>

<?php
  //Handle insert

   if (isset($_GET['vcid'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO stellenangeboteBewerben(email, vacancyid) VALUES('" . $_GET['mail'] . "','" . $_GET['vcid'] ."' ) ";    
//Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);


    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
   
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);

    }
    oci_free_statement($insert);
  } 
?>
 

<div class="container">
 <table class="table table-bordered">
    <thead>
      <tr>
	  <th> Job ID </th>
          <th>Vorname</th>
		  <th>Nachname</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
	echo "<td>" . $row['VACANCYID'] . "</td>";
    echo "<td>" . $row['VORNAME'] . "</td>";
    echo "<td>" . $row['NACHNAME'] . "</td>";      
    echo "</tr>";
  }
?>
    </tbody>
  </table>



<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Bewerbung gefunden!</div>
</center>
<br></br>
<br></br>



<?php  oci_free_statement($stmt); ?>


<?php
oci_close($conn);
?>
</div>
</body>
</html>
