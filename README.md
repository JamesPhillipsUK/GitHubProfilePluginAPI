# GitHub Profile Plugin API

This PHP API provides a fully-responsive website plugin featuring a breakdown of a given user's GitHub profile.

## Features

- Runs entirely on Server-Side with any version of PHP 7 or 8.
- Responsive design with Bootstrap 4 or 5.
- Secure data transfer through Personal Access Keys and the GitHub API.
- Easy Setup.

## How to Use

### Example Usage

1. Generate a Personal Access Token for GitHub
2. Save the GitHubProfilePluginAPI Directory
3. Create an instance of the API on the page where you'll be displaying your profile.

```PHP
<?php
include("GitHubProfilePluginAPI/core.php");// Include the API.
use GitHubProfilePluginAPI\core as GHPP;// Access the API.

// Please store your Personal Access Token and Username outside of a web-accessible directory and call them with a script so malicious users can't get them.  Above the web root or in a file blocked by your htaccess rules are common choices.
$profile = new GHPP("Personal Access Token", "Username");// Create your profile.
?>
```

4. Show your profile breakdown wherever you want it.

```PHP
...
  <div class="container">
    <div class="col-12 col-sm-10 offset-sm-1">
<?php

$profile->show(); 

//or

$bootstrapVersion = 5; //Optional, defaults to 4.
$numberOfRepos = 5; //Optional, defaults to show all.
$numberOfLanguages = 3; //Optional, defaults to 3.
$profile->show($bootstrapVersion, $numberOfRepos, $numberOfLanguages); 

?>
    </div>
  </div>
...
```

### API Documentation

View the complete API documentation here: [jamesphillipsuk.github.io/GitHubProfilePluginAPI](https://jamesphillipsuk.github.io/GitHubProfilePluginAPI/).

## System Requirements

- PHP 7 or 8.
- Bootstrap 4 or 5.
- FontAwesome 5.11 or above.

## Example

<table>
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="50%">
      <img src="https://github.com/JamesPhillipsUK/GitHub-Profile-Web-App/blob/main/Example.png" alt="Example" />
    </td>
    <td width="25%">&nbsp;</td>
  </tr>
</table>

## Bug-finding

I hope you don't have too many problems with the GitHub Profile Plugin API.  But - if you do find any bugs, please report them as issues in the GitHub repo, no matter how small.

### More From me

If you want to see more of what I do, you can visit: [jamesphillipsuk.com](https://jamesphillipsuk.com "My Website!").
If you want to donate to my development efforts, you can send donations via PayPal.Me at [paypal.me/JamesPhillipsUK](https://paypal.me/JamesPhillipsUK "My PayPal.Me").
