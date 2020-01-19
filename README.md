# GitHub Profile API

A fully-responsive PHP 7 API to display a breakdown of a user's GitHub profile on a webpage.

## Features

- Runs entirely on Server-Side.
- Responsive design with Bootstrap 4.
- Secure data transfer through Personal Access Keys and the GitHub API.
- Easy Setup.

## Installation

1. Generate a Personal Access Token for GitHub
2. Save the GitHubProfileAPI Directory
3. Create an instance of the API on the page where you'll be displaying your profile.

```PHP
<?php
include("GitHubProfileAPI/core.php");// Include the  API.
use GitHubProfileAPI\core as API;// Access the API.

// Please store your Personal Access Token and Username outside of a web-accessible directory and call them with a script so malicious users can't get them.  Above the web root or in a file blocked by your htaccess rules are common choices.
$api = new API("Personal Access Token", "Username");// Create an instance of the Statistics.
?>
```

4. Show the profile breakdown wherever you want it.

```PHP
...
  <div class="container">
    <div class="col-10 offset-1">
<?php $api->show(); ?>
    </div>
  </div>
...
```

## System Requirements

- PHP 7 or above.
- Bootstrap 4.4 or above.
- FontAwesome 5.11 or above.

## Example

<table>
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="50%">
      <img src="https://github.com/JamesPhillipsUK/GitHub-Profile-Web-App/blob/master/Example.png" alt="Example" />
    </td>
    <td width="25%">&nbsp;</td>
  </tr>
</table>

## Bug-finding

I hope you don't have too many problems with the GitHub Profile API.  But - if you do find any bugs, please report them as issues in the GitHub repo, no matter how small.

### More From me

If you want to see more of what I do, you can visit: [jamesphillipsuk.com](https://jamesphillipsuk.com "My Website!").
If you want to donate to my development efforts, you can send donations via PayPal.Me at [paypal.me/JamesPhillipsUK](https://paypal.me/JamesPhillipsUK "My PayPal.Me").
