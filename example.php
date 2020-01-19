<?php
/**
 * This file contains an example of how GitHubProfileAPI can be used.
 **/
include("GitHubProfileAPI/core.php");// Include the  API.
use GitHubProfileAPI\core as API;// Access the API.

// Please store your Personal Access Token and Username outside of a web-accessible directory and call them with a script so malicious users can't get them.  Above the web root or in a file blocked by your htaccess rules are common choices.
$api = new API("Personal Access Token", "Username");// Create an instance of the Statistics.

?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
  <title>My GitHub Profile</title>
</head>
<body>
  <div class="container">
    <div class="col-10 offset-1">
<?php $api->show(); ?>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>