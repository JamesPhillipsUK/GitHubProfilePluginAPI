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
 * @since     2.1.0
 **/
namespace GitHubProfilePluginAPI
{
  require_once("call.php");

  /**
   * core contains the GitHub Profile, and builds the plugin UI.
   *
   * @param    string    $gitHubavatarURL    The user's avatar as a URL.
   * @param    string    $gitHubBio          The user's GitHub bio.
   * @param    string    $gitHubCompany      The user's primary company on GitHub, if any.
   * @param    int       $gitHubFollowers    The number of followers the user has on GitHub.
   * @param    int       $gitHubFollowing    The number of people the user is following on GitHub.
   * @param    string    $gitHubHTMLURL      The user's profile URL on GitHub.
   * @param    string    $gitHubLogin        The user's GitHub Login name.
   * @param    string    $gitHubName         The user's GitHub given name.
   * @param    int       $gitHubPubRepos     The number of public repos the user has on GitHub.
   * @param    string    $popularLanguages   A list of the user's most popular languages on GitHub.
   * @param    array     $repos              An ordered array of the user's public repos.
  **/
  class core
  {
    private $call;

    //Parts to a profile
    private $avatarURL;
    private $bio;
    private $company;
    private $followers;
    private $following;
    private $hTMLURL;
    private $login;
    private $name;
    private $publicRepos;
    private $popularLanguages;
    private $repos;

    /**
     * Constructor for the core API class.
     * 
     * @param    string    $personalAccessToken    The user's GitHub Personal Access Token.
     * @param    string    $gitHubUsername         The user's GitHub Username.
     **/
    public function __construct(string $personalAccessToken, string $gitHubUsername)
    {
      $this->call = new call();
      $this->call->setPersonalAccessToken($personalAccessToken);
      $this->call->setUsername($gitHubUsername);
    }

    /**
     * A recursive array sorting algorithm used by usort in show().
     * 
     * Sorts two repos by most recent push.
     * 
     * @param    object    $a    One repo structure.
     * @param    object    $b    Another repo structure.
     * @return   int             Signifies to usort the ordering for the two elements.
     **/
    private function repo_sort(object $a, object $b): int
    {
      return ($a->pushed_at > $b->pushed_at) ? -1 : 1;
    }

    /**
     * Collates all of the necessary data to build the plugin, and calls build_ui() to do so.
     * 
     * @param    int    $bootstrapVersion    Takes "4" or "5" to use Bootstrap 4 or 5.
     * @param    int    $numberOfRepos       Number of repos to display, 0 shows all.
     * @param    int    $numberOfLanguages   Number of languages to display, 0 shows all.
     **/
    public function show(int $bootstrapVersion = 4, int $numberOfRepos = 0, int $numberOfLanguages = 3): void
    {
      $gitHubJSON = &$this->call->call_github();// Grab the return value of call_github().
      $unsortedRepos = $this->call->call_github_repos();
      $this->name = $gitHubJSON->name;// Save the name
      $this->company = $gitHubJSON->company;// Save the company.
      $this->hTMLURL = $gitHubJSON->html_url;// Save the profile url.
      $this->avatarURL = $gitHubJSON->avatar_url;// Save the avatar url.
      $this->login = $gitHubJSON->login;// Save the login name.
      $this->bio = $gitHubJSON->bio;// Save the user bio.
      $this->publicRepos = $gitHubJSON->public_repos;// Save the number of public repos.
      $this->followers = $gitHubJSON->followers;// Save the number of followers.
      $this->following = $gitHubJSON->following;// Save the number of users following.
      $languageData = Array();
      foreach ($unsortedRepos as $data)
      {
        if ($data->archived == false && $data->disabled == false)
        {
          if (array_key_exists($data->language, $languageData))
            $languageData[$data->language] += 1;//$data->size;
          else
            $languageData[$data->language] = 1;//$data->size;
        }
      }
      arsort($languageData);
      $this->popularLanguages = "<p><small>Develops with: </small>";
      $count = 0;
      foreach ($languageData as $language => $size)
      {
        if ($count < $numberOfLanguages)
        {
          $this->popularLanguages .= "<span class='badge badge-light'>" . $language . "</span> ";
          $count++;
        }
        else
          break;
      }
      $this->popularLanguages .= "</p>";
      if ($numberOfLanguages == 0)
        $this->popularLanguages = "";
      $sortedRepos = $unsortedRepos;
      usort($sortedRepos, array($this, "repo_sort"));
      if ($numberOfRepos > 0)
        $this->repos = array_splice($sortedRepos, 0, $numberOfRepos);
      else
        $this->repos = $sortedRepos;
      $this->build_ui($bootstrapVersion, $numberOfRepos);
    }

    /**
     * Builds the Plugin UI.
     * 
     * @param    int    $bootstrapVersion    Bootstrap 4 or 5.
     * @param    int    $numberOfRepos       The number of Repos to show.
     **/
    private function build_ui(int $bootstrapVersion, int $numberOfRepos):void
    {
      echo "<style>
#GitHubAPI{margin: 0 auto;}
#GitHubAPI table, #GitHubAPI p{margin-bottom:0;}
#GitHubAPI img{width:100%;}
#GitHubAPI .table td, #GitHubAPI .table th{padding:0 .75rem; font-size:80%;}
#GitHubAPI .repos div{border-top: 1px solid rgba(0,0,0,.125)}
</style>
<div id='GitHubAPI'>
  <aside class='card'>
    <div class='card-header'>
      <strong>" . $this->name . "</strong>&nbsp;&nbsp;(<a href='" . $this->hTMLURL . "'><em>@" . $this->login . "</em></a>)
    </div>
    <div class='card-body container-fluid'>
      <div class='row'>
        <div class='col-3'>
          <img src='" . $this->avatarURL . "' alt='GitHub Avatar' />
        </div>
        <div class='col-9'>
          <p><small>" . $this->bio . "</small></p>" . $this->popularLanguages;
      if ($bootstrapVersion == 5)
        echo "
          <div class='table-responsive'><table class='table'>";
      else
        echo "
          <table class='table table-responsive'>";
      echo "
            <thead>
              <tr>
                <th>Public Repos</th>
                <th>Followers</th>
                <th>Following</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>" . $this->publicRepos . "</td>
                <td>" . $this->followers . "</td>
                <td>" . $this->following . "</td>
              </tr>
            </tbody>
          </table>";
      if ($bootstrapVersion == 5)
        echo "</div>";
      echo "
        </div>
      </div>
      <div class='repos'>";
      if ($numberOfRepos > 0)
        echo "
        <p><strong>Top " . $numberOfRepos . " Active Public Repos: </strong></p>";
      else
        echo "
        <p><strong>Active Public Repos: </strong></p>";// Echo out the values we saved in the call_github() function as formatted HTML and CSS.
      foreach ($this->repos as $data)
      {
        if ($data->archived == false && $data->disabled == false)
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
  </aside>
</div>";// Close off the UI
    }
  }
}
?>