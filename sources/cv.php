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
	<li class="active"><a href="cv.php">Lebenslauf</a></li>
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
    <form id='searchform' action='cv.php' method='get' class="form-inline">
      <a href='cv.php'>Alle Lebenslauf</a> ---
    <div class="form-group">
   <label for="focusedInput">  Suche nach Position des Lebenslaufs: </label>
    <input class="form-control"  id='search' name='search' type="text" value='<?php  if (isset($_GET['search'])) echo $_GET['search']; ?>' />
	<input id='submit' type='submit' class="btn btn-default" value='Search' />
	
	</div>
  </form>
</div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM alle_cv WHERE position like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM alle_cv";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

<?php $query="SELECT kategname FROM kategorie";
    $editWR=oci_parse($conn,$query);
    oci_execute($editWR);?>

<br>
<br>
  <div class="container" >
  <form id='insertform' action='cv.php' method='get'>
<center>
<h2>Neue Lebenslauf einfuegen:</h2>
<br>
	<div class="container">
     <table class="table table-striped">
	  <thead>
	    <tr>
	      <th>e-mail des Bewerbers</th>
	      <th>Position</th>
		  <th>Kategorie</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
			<div class="form-group">
	           <input  id='mail' name='mail'type="text"   class="form-control" value='<?php if (isset($_GET['mail'])) echo $_GET['mail']; ?>' />
                </td>
                <td>
                   <input id='position' name='position' type="text" class="form-control" value='<?php if (isset($_GET['position'])) echo $_GET['position']; ?>' />
                </td>
				<td>
				<select class="form-control" name="weekid" id="weekid" value='<?php if (isset($_GET['weekid'])) echo $_GET['weekid']; ?>'>
                   <?php echo '<OPTION VALUE="">'."Select".'</OPTION>';
    while($row = oci_fetch_array($editWR,OCI_ASSOC))
    {
    $WID=$row ['KATEGNAME'];
    echo'<OPTION VALUE='."$WID".'>'.$WID.'</OPTION>';
    }?>
                </select>
				</td>
				</div>
	      </tr>
           </tbody>
        </table>
		
		
		
     <table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Schule</th>
	      <th>Hochschule</th>
		  <th>CVdate</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
			<div class="form-group">
	           <input  id='schule' name='schule'type="text"   class="form-control" value='<?php if (isset($_GET['schule'])) echo $_GET['schule']; ?>' />
                </td>
                <td>
                   <input id='hschule' name='hschule' type="text" class="form-control" value='<?php if (isset($_GET['hschule'])) echo $_GET['hschule']; ?>' />
                </td>
				<td>
                   <input id='update' name='update' type="text"   class="form-control" value='<?php if (isset($_GET['update'])) echo $_GET['update']; ?>' />
                </td>
				
				</div>
	      </tr>
           </tbody>
        </table>
		
		<table class="table table-bordered">
	  <thead>
	    <tr>
	        <th>Erfahrung</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr><div class="form-group">
	        <td>
                   <input id='erfahrung' name='erfahrung' type="text" class="form-control" value='<?php if (isset($_GET['erfahrung'])) echo $_GET['erfahrung']; ?>' />
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
   if (isset($_GET['mail'])) 
  {


    //Prepare insert statementd
	$sql = "INSERT INTO lebenslauf( beschreibung, schule, hochschule, kategname , email , position ,updatedatum) VALUES('" . $_GET['erfahrung'] . "','"  . $_GET['schule'] .  "' ,'"  . $_GET['hschule'] .  "'  ,'"  . $_GET['weekid'] .  "', '"  . $_GET['mail'] .  "', '"  . $_GET['position'] .  "', to_date('" . $_GET['update'] . "','yyyy-mm-dd') )";
   
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
     <tbody>
	 <thead>
      <tr>
       <th>  Name  </th>
  	      <th>Geb.datum</th>
		  <th>      Stadt      </th>
		<th>     Kontakt     </th>
		  <th>kategorie</th>
		  <th>  Position    </th>
		  <th>  Studium   </th>
		  <th>  Erfahrung    </th>
		  <th>  datum   </th>
      </tr>
	   </thead>
    
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
	  
    echo "<tr>";
    echo "<td>" . $row['VORNAME'] ."   " . $row['NACHNAME'] ."</td>";
    echo "<td>"  . $row['GEBURTSDATUM'] . " </td>";
	echo "<td>"  . $row['ORT'] . " </td>";
   echo "<td>" . $row['TELEFONNUMER'] . "</td>";
   echo "<td>"  . $row['KATEGNAME'] . " </td>";
   echo "<td>"  . $row['POSITION'] . " </td>";
      echo "<td>" . $row['SCHULE'] ."  , " . $row['HOCHSCHULE'] ."</td>";
	     echo "<td>"  . $row['BESCHREIBUNG'] . " </td>";
			   echo "<td>"  . $row['UPDATEDATUM'] . " </td>";
    echo "</tr>";
  }
?>
    </tbody>
 </table>
</div>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Lebenslauf gefunden!</div>
</center>
<br></br>
<?php  oci_free_statement($stmt);
oci_close($conn); ?>

</body>
</html>