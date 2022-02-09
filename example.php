<?php
/**
 * This file contains an example of how GitHubProfilePluginAPI can be used.
 **/
include("GitHubProfilePluginAPI/core.php");// Include the API.
use GitHubProfilePluginAPI\core as GHPP;// Access the API.

// Please store your Personal Access Token and Username outside of a web-accessible directory and call them with a script so malicious users can't get them.  Above the web root or in a file blocked by your htaccess rules are common choices.
$profile = new GHPP("Personal Access Token", "Username");// Create an instance of the Statistics.

?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <title>My GitHub Profile</title>
</head>
<body>
  <br />
  <div class="container">
    <div class="col-12">
<?php

$bootstrapVersion = 5; //Optional, defaults to 4.
$numberOfRepos = 5; //Optional, defaults to show all.
$numberOfLanguages = 3; //Optional, defaults to 3.

$profile->show($bootstrapVersion, $numberOfRepos, $numberOfLanguages); 

?>
    </div>
  </div>
  <br />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>