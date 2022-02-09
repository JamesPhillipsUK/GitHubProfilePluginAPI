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
 class call
  {
    private $personalAccessToken = "";
    private $gitHubUsername = "";

    /**
     * Sets the PAT.
     * @param personalAccessToken - the user's GitHub Personal Access Token.
     **/
    public function setPersonalAccessToken($personalAccessToken)
    {
      $this->personalAccessToken = $personalAccessToken;
    }

    /**
     * Sets the Username.
     * @param gitHubUsername - the user's GitHub Username.
     **/
    public function setUsername($gitHubUsername)
    {
      $this->gitHubUsername = $gitHubUsername;
    }

    /**
     * This function pulls the user's GitHub Profile data.
     * @return gitHubJSON - The data as JSON.
     **/
    public function call_github()
    {
      $gitHubURL = "https://api.github.com/users/" . $this->gitHubUsername;// Pull your user data from GitHub.
      $gitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubProfilePluginAPI','Authorization: token ' . $this->personalAccessToken . '',);
      $gitHubcURL = curl_init();// Initialize cURL.
      if (curl_error($gitHubcURL))
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
    public function call_github_repos()
    {
      $gitHubURL = "https://api.github.com/users/" . $this->gitHubUsername . "/repos";// The GitHub URL for the user's repos.
      $gitHubHeaders = array('User-Agent: JamesPhillipsUK-GitHubProfilePluginAPI','Authorization: token ' . $this->personalAccessToken . '',);// Insert your personal access token.
      $gitHubcURL = curl_init();// Initialize cURL.
      if (curl_error($gitHubcURL))
        echo 'error: ' . curl_error($gitHubcURL);// Executes if GitHub dies, or cURL dies.
      curl_setopt($gitHubcURL, CURLOPT_URL, $gitHubURL);
      curl_setopt($gitHubcURL, CURLOPT_HTTPHEADER, $gitHubHeaders);// These headers are as before.
      curl_setopt($gitHubcURL, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($gitHubcURL, CURLOPT_CUSTOMREQUEST, "GET");
      $gitHubJSON = json_decode(curl_exec( $gitHubcURL));// Decode the response.
      curl_close($gitHubcURL);// Close cURL.
      return $gitHubJSON;// Return the value of the decoded JSON data.
    }
  }
}
?>