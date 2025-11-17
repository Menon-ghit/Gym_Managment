<html>
<head>
  <title>My Account</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="navbar.css">
  <style>

.navbar {
  width: 100%;
  background-color: black;
  overflow: auto;
}

.navbar a {
  float: left;
  padding: 12px;
  color: white;
  text-decoration: none;
  font-size: 17px;
}

.navbar a:hover {
  background-color: lightgrey;
  color: black;
}

.active {
  background-color: grey;
  color: black;
}

@media screen and (max-width: 500px) {
  .navbar a {
    float: none;
    display: block;
  }
}

body{
  font-size:30px;
}

/* --- NEW CSS FOR THE DETAILS TABLE --- */
.details-table {
  width: 80%;
  margin: 20px auto; /* Centers the table */
  border-collapse: collapse; /* Clean borders */
  font-size: 20px; /* Smaller font for a cleaner grid */
  box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Optional: adds a nice shadow */
}

.details-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.details-table td:first-child {
  /* This is the label cell (e.g., "NAME", "PHONE") */
  font-weight: bold;
  background-color: #f4f4f4; /* Light grey background for labels */
  width: 30%; /* Gives the label column a consistent width */
  color: #333;
}

.details-table td:last-child {
  /* This is the value cell (e.g., the actual name or phone number) */
  background-color: #fff;
}
/* --- END OF NEW CSS --- */

</style>

</head>
<body>
  <div class="navbar">
  <a href="index.html"><i class="fa fa-home"></i> &nbsp;Home</a>
  <a href="about.html"><i class="fa fa-question-circle"></i> &nbsp;About Us</a> 
  <a href="merch.html"><i class="fa fa-shopping-bag"></i> &nbsp;Merchandise</a> 
  <a href="contact.html"><i class="fa fa-fw fa-envelope"></i> &nbsp;Contact</a> 
</div>
<br><br>
<?php

   $con=pg_connect("host=localhost dbname=newgym user=postgres");
  // if(!$con){
  //   echo 'Not connected'.'<br>';
  // }
  // else{
  //   echo 'Connected'.'<br>';
  // }

   //if(isset($_POST['submit'])){
  $name=$_POST['firstname'];
   $email=$_POST['email'];
   $experience=$_POST['firstname1'];
   $startdate=$_POST['startdate'];
   $gender=$_POST['gender'];
   $phone=$_POST['phone'];

   $tid = 'T'.'0'.rand(10,99);
   // echo $tid;
   // $comments=$_POST['comments']

   $exid = 'EX0'.rand(1,5);

   $sql=<<<EOF

   INSERT INTO TRAINERS (T_ID, T_Name, Email_ID, Sex, Join_Date, Experience_in_Years, Salary) VALUES ('$tid','$name','$email','$gender','$startdate',$experience,'25000');
   INSERT INTO PHONE(Phone_No, Trainer_ID) VALUES ($phone,'$tid');
   INSERT INTO CONDUCT(Exercise_ID, Trainer_ID) VALUES ('$exid', '$tid');

EOF;

if(!pg_query($con,$sql)){
      echo "<center><br><b style=\"color:red\">";
      echo ' Oops! There seems to be some error in registering you. </b><br>If you are already registered, your details will be diplayed here else please, try again later!';
      echo "</center><br><br>";
     }
      else{
      echo "<center><h2 style=\"color:green\"> Congratulations!</h2>You have successfully joined Kiran's Gym as a <b>TRAINER!</b></center> \n" ;
      echo "<br><br>";

     }

 $sql1=<<<EOF
   select * from Trainers where Email_ID = '$email';
EOF;

// --- MODIFIED PHP SECTION FOR GRID DISPLAY ---

  echo "<center><b>Here are your details: <br><br></b></center>"; // Moved the closing </center> tag here
   $ret = pg_query($con, $sql1);
   if(!$ret) {
      echo pg_last_error($con);
      exit;
   } 
   
   // Start the table
   echo '<table class="details-table">';

   while($row = pg_fetch_row($ret)) {
     // Each 'echo' now creates a table row <tr> with two cells <td>
      echo "<tr><td>ID</td><td>" . $row[0] . "</td></tr>";
      $trid = $row[0]; // Store the Trainer ID for the next query
      echo "<tr><td>NAME</td><td>" . $row[1] . "</td></tr>";
      echo "<tr><td>EMAIL</td><td>" . $row[2] . "</td></tr>";
      echo "<tr><td>GENDER</td><td>" . $row[3] . "</td></tr>";
      echo "<tr><td>START DATE</td><td>" . $row[4] . "</td></tr>";
      echo "<tr><td>EXPERIENCE</td><td>" . $row[5] . " years</td></tr>";
     echo "<tr><td>SALARY</td><td>" . $row[6] . " Rs/Month</td></tr>";
   }

   // End the table
   echo '</table><br>'; // Added a line break for spacing

// --- END OF MODIFIED PHP SECTION ---

   // echo "Operation done successfully\n";


$sql2=<<<EOF
select * from conduct where trainer_id='$trid';
EOF;

  echo "<center><b>To start, you will be conducting the following exercise: </b>";
   $ret2 = pg_query($con, $sql2);
   if(!$ret2) {
      echo pg_last_error($con);
      exit;
  __} 
   while($rows = pg_fetch_row($ret2)) {
      $sql3=<<<EOF
        select ex_name from exercises where e_id = '$rows[0]';
EOF;
   $ret3 = pg_query($con, $sql3);
    while($rowd = pg_fetch_row($ret3)) {
      echo $rowd[0]."<br><br>"."Further briefing will be given shortly.";
s    }
    echo "</center>";
  }
?>
<script>
  alert("You will automatically be logged off when you close this window.")
</script>
  </body>
</html>
