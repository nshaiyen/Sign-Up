<?php
// This page attempts to log a user in
try{
  session_start();
  $ID = $_POST["ID"];
  $pass = $_POST["password"];
  $dbh = new PDO('mysql:host=classdb.it.mtu.edu;dbname=bamalets', "", "");
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// This checks the user name and password(ENCRYPTED) 
  foreach ( $dbh->query("call properLogin(\"".$ID."\",ENCODE(\"".$pass."\",'123'))") as $row) {

    if($row[0] == 1 ){
        $_SESSION["name"] = $_POST["ID"];
    }else {
        // If fail redirects to login page
        header("Location: https://classdb.it.mtu.edu/~lscatron/loginPAGE.php"); /* Redirect browser */
        $_SESSION["fail"] = true; 
        exit();
    }
  // This function gets the users name
  $dbh = new PDO('mysql:host=classdb.it.mtu.edu;dbname=bamalets', "", "");
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  foreach ( $dbh->query("call getSName(\"".$ID."\")") as $row) {
      $_SESSION["Sname"] = $row[0];
  }

}} catch(PDOException $e) {
    print "Error! " . $e->getMessage()."<br/>";
    die();
}

 #$_SESSION["name"] = $_POST["username"];

?>

<html>
    <head>
        <title>Husky Tester</title>
        <link rel="icon" href="https://thumbs.gfycat.com/ScarceBrightBrontosaurus-max-1mb.gif">
        <link rel="stylesheet" type="text/css" href="mainStyle.css">
    </head>
  <!--Top Nav Bar-->
  <div id = "top">
  <div class="topnav">
    <a href="home.php">Home</a>
    <?php
      if(!isset($_SESSION["name"])) {
        echo "<a href=\"loginPAGE.php\">Login</a>";
        echo "<a href=\"about.php\">About</a>";
      }

     else {
        echo "<a href=\"about.php\">About</a>";
        echo "<a href=\"todo.php\">Todo</a>";
        echo "<a href=\"grades.php\">Grades</a>";
        echo "<a href=\"logout.php\">Logout</a>";
      }
    ?>


  </div>
</div>
<body>
  <div>
   <p id = "log">
<?php
  echo "Welcome ".$_SESSION["Sname"].".";
?>
    </p>
  </div>
</body>
