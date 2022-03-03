<?php
/**
 * GitHub Profile Plugin API
 *
 * GitHub Profile Plugin API is designed to give a rundown of your GitHub Profile on your PHP Website
 * 
 * @copyright (C) 2017 - 2022  Jesse Phillips <james@jamesphillipsuk.com>
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
 * @author    Jesse Phillips    <james@jamesphillipsuk.com>
 * @version   2.2.0
 * @since     2.1.1
 **/
namespace GitHubProfilePluginAPI
{
  /**
   * call handles calls to and from the GitHub API
   * 
   * @param    string    $personalAccessToken    The user's GitHub Personal Access Token.
   * @param    string    $gitHubUsername         The user's GitHub Username.
   **/
  class call
  {
    private $personalAccessToken = "";
    private $gitHubUsername = "";

    /**
     * Sets the Personal Access Token.
     * 
     * @param    string    $personalAccessToken    The user's GitHub Personal Access Token.
     **/
    public function setPersonalAccessToken(string $personalAccessToken): void
    {
      $this->personalAccessToken = $personalAccessToken;
    }

    /**
     * Sets the Username.
     * 
     * @param    string    $gitHubUsername    The user's GitHub Username.
     **/
    public function setUsername(string $gitHubUsername): void
    {
      $this->gitHubUsername = $gitHubUsername;
    }

    /**
     * This method pulls the user's GitHub Profile data from the GitHub API.
     * 
     * @return    object    The data as JSON, stored in a PHP object.
     **/
    public function call_github(): object
    {
      $gitHubURL = "https://api.github.com/users/" . $this->gitHubUsername;// Pull your user data from GitHub.
      $gitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubProfilePluginAPI','Authorization: token ' . $this->personalAccessToken . '',);
      $gitHubcURL = curl_init();
      if (curl_error($gitHubcURL))
        echo 'error: ' . curl_error( $gitHubcURL);
      curl_setopt($gitHubcURL, CURLOPT_URL, $gitHubURL);
      curl_setopt($gitHubcURL, CURLOPT_HTTPHEADER, $gitHubHeaders);
      curl_setopt($gitHubcURL, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($gitHubcURL, CURLOPT_CUSTOMREQUEST, "GET");
      $gitHubJSON = json_decode(curl_exec($gitHubcURL));// Decode the returned JSON data.
      curl_close( $gitHubcURL);
      return $gitHubJSON;// Return the decoded JSON.
    }

    /**
     * This function pulls the user's GitHub repository data.
     * 
     * @return    array    The data as JSON, stored in a PHP array.
     **/
    public function call_github_repos(): array
    {
      $gitHubURL = "https://api.github.com/users/" . $this->gitHubUsername . "/repos";// The GitHub URL for the user's repos.
      $gitHubHeaders = array('User-Agent: JamesPhillipsUK-GitHubProfilePluginAPI','Authorization: token ' . $this->personalAccessToken . '',);
      $gitHubcURL = curl_init();
      if (curl_error($gitHubcURL))
        echo 'error: ' . curl_error($gitHubcURL);
      curl_setopt($gitHubcURL, CURLOPT_URL, $gitHubURL);
      curl_setopt($gitHubcURL, CURLOPT_HTTPHEADER, $gitHubHeaders);
      curl_setopt($gitHubcURL, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($gitHubcURL, CURLOPT_CUSTOMREQUEST, "GET");
      $gitHubJSON = json_decode(curl_exec($gitHubcURL));// Decode the response.
      curl_close($gitHubcURL);
      return $gitHubJSON;// Return the decoded JSON.
    }
  }
}
?>