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
  
</head>
<body>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">CareerSuccess</a>
    </div>
    <ul class="nav navbar-nav">
	     <li><a href="benutzer.php">Benutzer</a></li>
	<li ><a href="bewerber.php">Bewerber</a></li>
	<li><a href="cv.php">Lebenslauf</a></li>
	<li><a href="firma.php">Firmen</a></li>
      <li><a href="job.php">Jobs</a></li>
	    <li class="active"><a href="kategorie.php">Kategorie</a></li>
		 <li><a href="apply.php">sich bewerben</a></li>
		<li><a href="view.php">Views</a></li>
     	
    </ul>
  </div>
</nav>
<div class="container">
    <form id='searchform' action='kategorie.php' method='get'class="form-inline">
   <a href='kategorie.php'>Alle kategorie</a> ---  
	  <div class="form-group">
   <label for="focusedInput">  Suche nach kategorie name: </label>
    <input class="form-control" id='search' name='search' type="text" value='<?php  if (isset($_GET['search'])) echo $_GET['search']; ?>' />
	<input id='submit' type='submit' class="btn btn-default" value='Search' />
	</div>

  </form>
</div>
<br>
<br>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM kategorie WHERE kategname like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM kategorie";
  }
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

  <div class="container" >
  <form id='insertform' action='kategorie.php' method='get'>
<center>
<h2>Neue kategorie einfuegen:</h2>
<br>
	<div class="container">
     <table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Kategorie Name</th>
	      <th>beschreibung</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
			<div class="form-group">
	           <input  id='kname' name='kname'type="text"   class="form-control" value='<?php if (isset($_GET['kname'])) echo $_GET['kname']; ?>' />
                </td>
                <td>
                   <input id='beschreibung' name='beschreibung' type="text" class="form-control" value='<?php if (isset($_GET['beschreibung'])) echo $_GET['beschreibung']; ?>' />
				    </div>
                </td>
	      </tr>
           </tbody>
        </table>
        <input  type="submit" class="btn btn-info" value="insert" />
	</center>	
  </form>
</div>


<?php
  //Handle insert
   if (isset($_GET['kname'])) 
  {


    //Prepare insert statementd
	$sql = "INSERT INTO kategorie VALUES('" . $_GET['beschreibung'] . "','"  . $_GET['kname'] .  "')";
   
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
  
 <br>
 <br>
  
<div class="container">
 <table class="table table-bordered">
  <thead>
    <tr>
      <th> kategorie Name</th>
      <th>beschreibung</th>
    </tr>
  </thead>
  <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['KATEGNAME'] . "</td>";
    echo "<td>" . $row['BESCHREIBUNG'] . "</td>";
    echo "</tr>";
  }
?>
  </tbody>
 </table>
</div>

<?php  oci_free_statement($stmt);
oci_close($conn); ?>

</body>
</html>
