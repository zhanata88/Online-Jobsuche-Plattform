
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
	<li><a href="bewerber.php">Bewerber</a></li>
	<li><a href="cv.php">Lebenslauf</a></li>
	<li class="active"><a href="firma.php">Firmen</a></li>
      <li><a href="job.php">Jobs</a></li>
	    <li><a href="kategorie.php">Kategorie</a></li>
		 <li><a href="apply.php">sich bewerben</a></li>
		<li><a href="view.php">Views</a></li>	
    </ul>
  </div>
</nav>

<br></br>

<div id="wrapper">
<center>
  <div>
    <form id='searchform' action='firma.php' method='get' class="form-inline">
      <a href='firma.php'>Alle Arbeitgebern</a> ---
    
    <div class="form-group">
   <label for="focusedInput">  Suche nach Name des Firmas: </label>
    <input class="form-control"  id='search' name='search' type="text" value='<?php  if (isset($_GET['search'])) echo $_GET['search']; ?>' />
	<input id='submit' type='submit' class="btn btn-default" value='Search' />
	</div>
  </form>
</div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM arbeitgeber WHERE firma_name like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM arbeitgeber";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

  
<br>
<br>
<div>
  <form id='insertform' action='firma.php' method='get'>
<center>
<h2>Neuer Arbeitgeber einfuegen:</h2>
<br>
    
	<div class="container">
     <table class="table table-bordered">
	  <thead>
	    <tr>
	     <th>Benutzer id</th>
	      <th>Firma name</th>
		  <th>Bereich</th>
  	      <th>Adresse</th>
		  <th>Stadt</th>
		  <th>TEL</th>
		  <th>email</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
		 <div class="form-group">
		 
		 <td>
                   <input id='b_id' name='b_id' type='number' class="form-control" value='<?php if (isset($_GET['b_id'])) echo $_GET['b_id']; ?>' />
                </td>
                <td>
                   <input id='fname' name='fname' type='text' class="form-control" value='<?php if (isset($_GET['fname'])) echo $_GET['fname']; ?>' />
                </td>
				<td>
                   <input id='bereich' name='bereich' type='text' class="form-control" value='<?php if (isset($_GET['bereich'])) echo $_GET['bereich']; ?>' />
                </td>
				<td>
                   <input id='adress' name='adress' type='text' class="form-control" value='<?php if (isset($_GET['adress'])) echo $_GET['adress']; ?>' />
				  </td> 	
					<td>
                   <input id='ort' name='ort' type='text' class="form-control" value='<?php if (isset($_GET['ort'])) echo $_GET['ort']; ?>' />
				  </td> 			
					<td>
                   <input id='tel' name='tel' type='text' class="form-control" value='<?php if (isset($_GET['tel'])) echo $_GET['tel']; ?>' />
				  </td> 
					<td>
                   <input id='mail' name='mail' type='text' class="form-control" value='<?php if (isset($_GET['mail'])) echo $_GET['mail']; ?>' />
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
   if (isset($_GET['b_id'])) 
  {

    //Prepare insert statementd
    $sql = "INSERT INTO arbeitgeber(firma_name, adresse, benutzer_id, bereich, ort, telefonnumer, email) VALUES('" . $_GET['fname'] . "' ,  '" . $_GET['adress'] . "', '" . $_GET['b_id'] . "', '" . $_GET['bereich'] . "', '" . $_GET['ort'] . "', '" . $_GET['tel'] . "', '" . $_GET['mail'] . "' )";
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
	      <th>Benutzer ID</th>
	      <th>Firma Name</th>
  	      <th>Bereich</th>
		  <th>Adresse</th>
		  <th>Tel</th>
		  <th>E-mail</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
	echo "<td>" . $row['BENUTZER_ID'] .   " </td>";
    echo "<td>" . $row['FIRMA_NAME'] .   " </td>";
    echo "<td>"  . $row['BEREICH'] . " </td>";
    echo "<td>" . $row['ORT'] ."  , " . $row['ADRESSE'] ."</td>";
	echo "<td>" . $row['TELEFONNUMER'] . "</td>";
	echo "<td>" . $row['EMAIL'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
 </table>
</div>

<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Firma gefunden!</div>
</center>
<br></br>
<?php  oci_free_statement($stmt); ?>

<?php
oci_close($conn);
?>
</div>
</body>
</html>
