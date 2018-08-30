
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
	<li class="active"><a href="bewerber.php">Bewerber</a></li>
	<li><a href="cv.php">Lebenslauf</a></li>
	<li><a href="firma.php">Firmen</a></li>
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
    <form id='searchform' action='bewerber.php' method='get' class="form-inline">
      <a href='bewerber.php'>Alle Bewerberinen</a> ---
    
    <div class="form-group">
   <label for="focusedInput">  Suche nach Nachname des Bewerbers: </label>
    <input class="form-control"  id='search' name='search' type="text" value='<?php  if (isset($_GET['search'])) echo $_GET['search']; ?>' />
	<input id='submit' type='submit' class="btn btn-default" value='Search' />
	</div>
  </form>
</div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM bewerber WHERE nachname like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM bewerber";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

  
<br>
<br>
<div>
  <form id='insertform' action='bewerber.php' method='get'>
<center>
<h2>Neue Bewerber einfuegen:</h2>
<br>
    
	<div class="container">
     <table class="table table-bordered">
	  <thead>
	    <tr>
		<th>Benutzer ID</th>
	      <th>Vorname</th>
		  <th>Nachname</th>
  	      <th>Geburtsdatum</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
		 <div class="form-group">
		 <td>
                   <input id='b_id' name='b_id' type='number' class="form-control" value='<?php if (isset($_GET['b_id'])) echo $_GET['b_id']; ?>' />
                </td>
                <td>
                   <input id='vname' name='vname' type='text' class="form-control" value='<?php if (isset($_GET['vname'])) echo $_GET['vname']; ?>' />
                </td>
				<td>
                   <input id='nname' name='nname' type='text' class="form-control" value='<?php if (isset($_GET['nname'])) echo $_GET['nname']; ?>' />
                </td>
				<td>
                   <input id='gdatum' name='gdatum' type='text' class="form-control" value='<?php if (isset($_GET['gdatum'])) echo $_GET['gdatum']; ?>' />
				  </td> 				  
                 </div>
	      </tr>
           </tbody>  
		   </table>
		   
	<table class="table table-bordered">
	  <thead>
	    <tr>
	        <th>Adresse</th>
		  <th>Stadt</th>
		  <th>Tel</th>
		  <th>email</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr><div class="form-group">
	        <td>
                   <input id='adr' name='adr' type="text" class="form-control" value='<?php if (isset($_GET['adr'])) echo $_GET['adr']; ?>' />
                </td>
				<td>
                   <input id='ort' name='ort' type="text" class="form-control" value='<?php if (isset($_GET['ort'])) echo $_GET['ort']; ?>' />
                </td>
				<td>
                   <input id='tel' name='tel' type="text" class="form-control" value='<?php if (isset($_GET['tel'])) echo $_GET['tel']; ?>' />
                </td>
				<td>
                   <input id='mail' name='mail' type="text" class="form-control" value='<?php if (isset($_GET['mail'])) echo $_GET['mail']; ?>' />
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
    $sql = "INSERT INTO bewerber(benutzer_id, geburtsdatum, vorname, nachname,ort, telefonnumer, email, adresse) VALUES('" . $_GET['b_id'] . "' , to_date('" . $_GET['gdatum'] . "','yyyy-mm-dd') , '" . $_GET['vname'] . "',
	'" . $_GET['nname'] . "', '" . $_GET['ort'] . "', '" . $_GET['tel'] . "', '" . $_GET['mail'] . "' , '" . $_GET['adr'] . "')";
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
	  <th> Benutzer id </th>
	      <th>Vorname, Nachname </th>
  	      <th>Geb.datum</th>
		  <th>email</th>
		  <th>Stadt</th>
		  <th>Strasse</th>
		  <th>tel</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
	echo "<td>"  . $row['BENUTZER_ID'] . " </td>";
    echo "<td>" . $row['VORNAME'] ."   " . $row['NACHNAME'] ."</td>";
    echo "<td>"  . $row['GEBURTSDATUM'] . " </td>";
    echo "<td>" . $row['EMAIL'] . "</td>";
	echo "<td>" . $row['ORT'] . "</td>";
	echo "<td>" . $row['ADRESSE'] . "</td>";
	echo "<td>" . $row['TELEFONNUMER'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
 </table>
</div>

<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Bewerber gefunden!</div>
</center>
<br></br>
<?php  oci_free_statement($stmt); ?>

<?php
oci_close($conn);
?>
</div>
</body>
</html>
