<?php
/**
 * GitHub Profile Plugin API, Version 2.1.1.
 *
 * GitHub Profile Plugin API is designed to give a rundown of your GitHub Profile on your PHP Website
 * Copyright (C) 2017 - 2022  Jesse Phillips <james@jamesphillipsuk.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 **/
namespace GitHubProfilePluginAPI
{
 class core
  {
    private $personalAccessToken = "";
    private $gitHubUsername = "";

    /**
     * Constructor for the core API class.
     * @param personalAccessToken - the user's GitHub Personal Access Token.
     * @param gitHubUsername - the user's GitHub Username.
     **/
    public function __construct($personalAccessToken, $gitHubUsername)
    {
      $this->personalAccessToken = $personalAccessToken;
      $this->gitHubUsername = $gitHubUsername;
    }

    /**
     * This function pulls the user's GitHub Profile data.
     * @return gitHubJSON - The data as JSON.
     **/
    private function call_github()
    {
      $gitHubURL = "https://api.github.com/users/" . $this->gitHubUsername;// Pull your user data from GitHub.
      $gitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubProfilePluginAPI','Authorization: token ' . $this->personalAccessToken . '',);
      $gitHubcURL = curl_init();// Initialize cURL.
      if(curl_error($gitHubcURL))
        echo 'error: ' . curl_error( $gitHubcURL);// Executes if GitHub dies, or cURL dies.
      curl_setopt($gitHubcURL, CURLOPT_URL, $gitHubURL);// Connect to GitHub.
      curl_setopt($gitHubcURL, CURLOPT_HTTPHEADER, $gitHubHeaders);// Send our authorization headers.
      curl_setopt($gitHubcURL, CURLOPT_RETURNTRANSFER, 1);// Don't print it to the screen yet.
      curl_setopt($gitHubcURL, CURLOPT_CUSTOMREQUEST, "GET");// Use GET to grab the data.
      $gitHubJSON = json_decode(curl_exec($gitHubcURL));// Decode the returned JSON data.
      curl_close( $gitHubcURL);// Close cURL.
      return $gitHubJSON;// Return the decoded JSON.
    }

    /**
     * This function pulls the user's GitHub repository data.
     * @return gitHubJSON - The data as JSON.
     **/
    private function call_github_repos()
    {
      $gitHubURL = "https://api.github.com/users/" . $this->gitHubUsername . "/repos";// The GitHub URL for the user's repos.
      $gitHubHeaders = array('User-Agent: JamesPhillipsUK-GitHubProfilePluginAPI','Authorization: token ' . $this->personalAccessToken . '',);// Insert your personal access token.
      $gitHubcURL = curl_init();// Initialize cURL.
      if(curl_error($gitHubcURL))
        echo 'error: ' . curl_error($gitHubcURL);// Executes if GitHub dies, or cURL dies.
      curl_setopt($gitHubcURL, CURLOPT_URL, $gitHubURL);
      curl_setopt($gitHubcURL, CURLOPT_HTTPHEADER, $gitHubHeaders);// These headers are as before.
      curl_setopt($gitHubcURL, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($gitHubcURL, CURLOPT_CUSTOMREQUEST, "GET");
      $gitHubJSON = json_decode(curl_exec( $gitHubcURL));// Decode the response.
      curl_close($gitHubcURL);// Close cURL.
      return $gitHubJSON;// Return the value of the decoded JSON data.
    }

    /**
     * A recursive array sorting algorithm used by usort in show().
     * Sorts two repos by most recent push.
     * @param a - one repo structure.
     * @param b - another repo structure.
     * @return array - The repos.
     **/
    private function repo_sort($a, $b)
    {
      return ($a->pushed_at > $b->pushed_at) ? -1 : 1;
    }

    /**
     * Collates all of the necessary data to build the plugin, and calls build_ui() to do so.
     **/
    public function show()
    {
      $repos = $this->call_github_repos();
      $gitHubJSON = $this->call_github();// Grab the return value of call_github().
      $gitHubName = $gitHubJSON->name;// Save the name to use later.
      $gitHubCompany = $gitHubJSON->company;// Save the company to use later.
      $gitHubHTMLURL = $gitHubJSON->html_url;// Save the profile url to use later.
      $gitHubAvatarURL = $gitHubJSON->avatar_url;// Save the avatar url to use later.
      $gitHubLogin = $gitHubJSON->login;// Save the login name to use later.
      $gitHubBio = $gitHubJSON->bio;// Save the user bio to use later.
      $gitHubPubRepos = $gitHubJSON->public_repos;// Save the number of public repos to use later.
      $gitHubFollowers = $gitHubJSON->followers;// Save the number of followers to use later.
      $gitHubFollowing = $gitHubJSON->following;// Save the number of users following to use later.
      $languageData = Array();
      foreach($repos as $data)
      {
        if($data->archived == false && $data->disabled == false)
        {
          if(array_key_exists($data->language, $languageData))
            $languageData[$data->language] += 1;//$data->size;
          else
            $languageData[$data->language] = 1;//$data->size;
        }
      }
      arsort($languageData);
      $popularLanguages = "<p><small>Develops with: </small>";
      $count = 0;
      foreach ($languageData as $language => $size)
      {
        if($count < 3)
        {
          $popularLanguages .= "<span class='badge badge-light'>" . $language . "</span> ";
          $count++;
        }
        else
          break;
      }
      $popularLanguages .= "</p>";
      usort($repos, array($this, "repo_sort"));
      $this->build_ui($gitHubAvatarURL, $gitHubBio, $gitHubCompany, $gitHubFollowers, $gitHubFollowing, $gitHubHTMLURL, $gitHubLogin, $gitHubName, $gitHubPubRepos, $popularLanguages, $repos);
    }

    /**
     * Builds the Plugin UI.
     * @param gitHubAvatarURL - the user's avatar as a URL.
     * @param gitHubBio - the user's GitHub bio.
     * @param gitHubCompany - the user's primary company on GitHub, if any.
     * @param gitHubFollowers - the number of followers the user has on GitHub.
     * @param gitHubFollowing - the number of people the user is following on GitHub.
     * @param gitHubHTMLURL - the user's profile URL on GitHub.
     * @param gitHubLogin - the user's GitHub Login name.
     * @param gitHubName - the user's GitHub given name.
     * @param gitHubPubRepos - the number of public repos the user has on GitHub.
     * @param popularLanguages - a list of the user's most popular languages on GitHub.
     * @param repos - an ordered array of the user's public repos.
     **/
    private function build_ui($gitHubAvatarURL, $gitHubBio, $gitHubCompany, $gitHubFollowers, $gitHubFollowing, $gitHubHTMLURL, $gitHubLogin, $gitHubName, $gitHubPubRepos, $popularLanguages, $repos)
    {
      echo "<style>
#GitHubAPI{margin: 0 auto;}
#GitHubAPI table, #GitHubAPI p{margin-bottom:0;}
#GitHubAPI img{width:100%;}
#GitHubAPI .table td, #GitHubAPI .table th{padding:0 .75rem; font-size:80%;}
#GitHubAPI .repos div{border-top: 1px solid rgba(0,0,0,.125)}
</style>
<div id='GitHubAPI'>
  <section class='card'>
    <div class='card-header'>
      <a href='" . $gitHubHTMLURL . "'><strong>" . $gitHubName . "</strong><em>&nbsp;&nbsp;" . $gitHubLogin . "</em></a>
    </div>
    <div class='card-body container-fluid'>
      <div class='row'>
        <div class='col-3'>
          <img src='" . $gitHubAvatarURL . "' alt='GitHub Avatar' />
        </div>
        <div class='col-9'>
          <p><small>" . $gitHubBio . "</small></p>" . $popularLanguages . "
          <table class='table table-responsive'>
            <thead>
              <tr>
                <th>Public Repos</th>
                <th>Followers</th>
                <th>Following</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>" . $gitHubPubRepos . "</td>
                <td>" . $gitHubFollowers . "</td>
                <td>" . $gitHubFollowing . "</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class='repos'>
        <p><strong>Active Public Repos: </strong></p>";// Echo out the values we saved in the call_github() function as fromatted HTML and CSS.
      foreach($repos as $data)
      {
        if($data->archived == false && $data->disabled == false)
          echo "
      <div>
        <strong><a href='" . $data->html_url . "'>" . $data->name . "</a></strong>
        <p><small>" . $data->description . "</small></p>
        <p><span class='badge badge-light'><i class='fas fa-code'></i>&nbsp;" . $data->language . "</span> <span class='badge badge-light'><i class='fas fa-balance-scale'></i>&nbsp;" . $data->license->name . "</span> <span class='badge badge-light'><i class='fas fa-star'></i>&nbsp" . $data->stargazers_count . "</span> <span class='badge badge-light'><i class='fas fa-code-branch'></i>&nbsp;" . $data->forks_count . "</span> <span class='badge badge-light'><i class='fas fa-exclamation-circle'></i>&nbsp;" . $data->open_issues_count . "</span></p>
      </div>";
      }// List each of the user's repos individually.  This is optional as calling the function repeatedly adds to page load time drastically.
      echo "
      </div>
    </div>
  </section>
</div>";// Close off the UI
    }
  }
}
?>