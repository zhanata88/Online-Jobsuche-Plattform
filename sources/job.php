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
	<li><a href="firma.php">Firmen</a></li>
      <li class="active"><a href="job.php">Jobs</a></li>
	    <li><a href="kategorie.php">Kategorie</a></li>
		 <li><a href="apply.php">sich bewerben</a></li>
		<li><a href="view.php">Views</a></li>
    </ul>
  </div>
</nav>

<br></br>
<?php $query="SELECT kategname FROM kategorie";
    $editWR=oci_parse($conn,$query);
    oci_execute($editWR);?>

     
	
	<div class="container">
  <h1> Suche nach vacancyid des Jobs :</h1>
  <form action="job.php" id='searchform' method='get'>
   <a href='job.php'>Alle Jobs</a> ---
    <div class="input-group input-group-lg">
      <input type="text" class="form-control" placeholder="search" id='search' name='search'  value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' > 
      <div class="input-group-btn">
        <input class="btn btn-default" type="submit" value='search'><i class="glyphicon glyphicon-search"></i> </input>
      </div>
    </div>
  </form>
</div>
  
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM alle_jobs WHERE vacancyid like '%" . $_GET['search'] . "%' ";
  } else {
    $sql = "SELECT * FROM alle_jobs";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

	
<br>
<br>
  <div class="container" >
  <form id='insertform' action='job.php' method='get'>
<center>
<h2>Neues Job  einfuegen:</h2>
<br>
	<div class="container">
     <table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Firma name</th>
		  <th>Titel</th>
		  <th>Anstellungsart</th>
		  <th>Kategorie</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
			<div class="form-group">
	           <input  id='fname' name='fname'type="text"   class="form-control" value='<?php if (isset($_GET['fname'])) echo $_GET['fname']; ?>' />
                </td>
				<td>
                   <input id='titel' name='titel' type="text"   class="form-control" value='<?php if (isset($_GET['titel'])) echo $_GET['titel']; ?>' />
                </td>
				<td>
				<select class="form-control"  name='art' id="art" value='<?php if (isset($_GET['art'])) echo $_GET['art']; ?>'>
        <option>Vollzeit</option>
        <option>Teilzeit</option>
        <option>Gerinfuegig</option>
        <option>Praktikum</option>
      </select>
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
	      <th>Gehalt</th>
		  <th>Beginzeit</th>
		  <th>Endzeit</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
			<div class="form-group">
	           <input  id='gehalt' name='gehalt' type='number'  class="form-control" value='<?php if (isset($_GET['gehalt'])) echo $_GET['gehalt']; ?>' />
                </td>
                <td>
                   <input id='bzeit' name='bzeit' type="text" class="form-control" value='<?php if (isset($_GET['bzeit'])) echo $_GET['bzeit']; ?>' />
                </td>
				<td>
                   <input id='ezeit' name='ezeit' type="text"   class="form-control" value='<?php if (isset($_GET['ezeit'])) echo $_GET['ezeit']; ?>' />
                </td>
				
				</div>
	      </tr>
           </tbody>
        </table>
		
		<table class="table table-striped">
	  <thead>
	    <tr>
	         <th>Beschreibung</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr><div class="form-group">
	        <td>
                   <input id='beschreibung' name='beschreibung' type="text" class="form-control" value='<?php if (isset($_GET['beschreibung'])) echo $_GET['beschreibung']; ?>' />
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
   if (isset($_GET['fname'])) 
  {


    //Prepare insert statementd
	$sql = "INSERT INTO stellenangebote(beschreibung, title, gehalt, kategname, endzeit, beginzeit, firma_name, anstelungsart)VALUES( '"  . $_GET['beschreibung'] .  "'  ,'" . $_GET['titel'] . "','"  . $_GET['gehalt'] .  "' ,
	'"  . $_GET['weekid'] .  "', to_date('" . $_GET['ezeit'] . "','yyyy-mm-dd') , to_date('" . $_GET['bzeit'] . "','yyyy-mm-dd') ,    '"  . $_GET['fname'] .  "' , '"  . $_GET['art'] .  "' )";
   
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
  <h2> </h2>
  <p> </p>            
  <table class="table table-bordered">
    <thead>
      <tr>
	   <th>Job id</th>
        <th>Titel</th>
		<th>Kategorie</th>
		<th>Anstellungsart</th>
        <th>Aktiv (von bis)</th>
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
	echo "<td>" . $row['ENDZEIT'] . " , " . $row['BEGINZEIT'] .  "</td>";
	echo "<td>" . $row['BESCHREIBUNG'] . "</td>"; 
	echo "<td>" . $row['GEHALT'] . "</td>";  
	echo "<td>" . $row['ORT'] .  " , " . $row['ADRESSE'] .  " , " . $row['EMAIL'] . " , " . $row['TELEFONNUMER'] .  "</td>";
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