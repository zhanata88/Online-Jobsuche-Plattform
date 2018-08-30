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
      <li class="active"><a href="benutzer.php">Benutzer</a></li>
	<li ><a href="bewerber.php">Bewerber</a></li>
	<li><a href="cv.php">Lebenslauf</a></li>
	<li><a href="firma.php">Firmen</a></li>
      <li><a href="job.php">Jobs</a></li>
	    <li><a href="kategorie.php">Kategorie</a></li>
		 <li><a href="apply.php">sich bewerben</a></li>
		<li><a href="view.php">Views</a></li>	
       </ul>

</div>
</nav>

<br>
  <div>
    <form id='searchform' action='benutzer.php' method='get' class="form-inline">
      <a href='benutzer.php'>Alle Benutzern</a> ---  
	  <div class="form-group">
	  <label for="focusedInput">  Suche nach Login des Benutzers: </label>
      <input class="form-control"  id='search' name='search' type='text' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' class="btn btn-default" value='Search' />
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM benutzer WHERE login like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM benutzer";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

 
<br></br>

<div>
  <form id='insertform' action='benutzer.php' method='get'>
<center>
<h1>Neue Benutzer einfuegen:</h1>
<br>
    
	<div class="container">
     <table class="table table-bordered">
	  <thead>
	    <tr>
	      <th>login</th>
		  <th>password</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
		 <div class="form-group">
                <td>
                   <input id='login' name='login' type='text' class="form-control" value='<?php if (isset($_GET['login'])) echo $_GET['login']; ?>' />
                </td>
				<td>
                   <input id='pass' name='pass' type='text' class="form-control" value='<?php if (isset($_GET['pass'])) echo $_GET['pass']; ?>' />
                </td>		  
                 </div>
	      </tr>
           </tbody>  
		   </table>
  <input  type="submit" class="btn btn-info" value="insert" />
</center> 
  </form>
</div>

<?php
  //Handle insert

   if (isset($_GET['login'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO benutzer(kennwort, login)VALUES('" . $_GET['pass'] . "','" . $_GET['login'] ."') ";    
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
	  <th> Benutzer ID </th>
          <th>login</th>
		  <th>password</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
	echo "<td>" . $row['BENUTZER_ID'] . "</td>";
	 echo "<td>" . $row['LOGIN'] . "</td>";
    echo "<td>" . $row['KENNWORT'] . "</td>";      
    echo "</tr>";
  }
?>
    </tbody>
  </table>

<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Benutzer gefunden!</div>
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
