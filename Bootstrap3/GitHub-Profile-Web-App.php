<?php
/**
 *
 * GitHub Profile Web App, Version 2.0.0, Bootstrap 3 variant
 *
 * GitHub Profile Web Appis designed to give a rundown of your GitHub Profile on your PHP Website
 * Copyright (C) 2017, 2018  James Phillips <james@jamesphillipsuk.com>
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
  *
  **/

	//Put this block in the header of the page to decrease load time.
    define("PERSONALACCESSTOKEN","IT-GOES-HERE"); //Add your Personal Access Token here
    define("GITHUBUSERNAME","IT-GOES-HERE"); //Add your GitHub username here

	function CallGitHub() //this function pulls the user's GitHub Profile data
	{
		$GitHubURL = "https://api.github.com/user"; //pull your user data from GitHub
		$GitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubPHPApp','Authorization: token ' . PERSONALACCESSTOKEN . '',); //insert your personal access token
		$GitHubcURL = curl_init(); //initialize cURL
		if(curl_error($GitHubcURL))
		{
			echo 'error: ' . curl_error($GitHubcURL); // executes if GitHub dies, or cURL dies
		}
		curl_setopt($GitHubcURL, CURLOPT_URL,$GitHubURL); //Connect to GitHub
		curl_setopt($GitHubcURL, CURLOPT_HTTPHEADER, $GitHubHeaders);  //send our authorization headers
		curl_setopt($GitHubcURL, CURLOPT_RETURNTRANSFER, 1); //don't print it to the screen yet
		curl_setopt($GitHubcURL, CURLOPT_CUSTOMREQUEST, "GET"); //use GET to grab the data
		$GitHubJSON = json_decode(curl_exec($GitHubcURL)); //decode the returned JSON data
		curl_close($GitHubcURL); //close cURL
		return $GitHubJSON; //return the decoded JSON
	}
	$GitHubJSON = CallGitHub(); //grab the return value of CallGitHub()
	$GitHubName = $GitHubJSON->name; //save the name to use later
	$GitHubHTMLURL = $GitHubJSON->html_url; //save the profile url to use later
	$GitHubAvatarURL = $GitHubJSON->avatar_url; //save the avatar url to use later
	$GitHubLogin = $GitHubJSON->login; //save the login name to use later
	$GitHubBio = $GitHubJSON->bio; //save the user bio to use later
	$GitHubPubRepos = $GitHubJSON->public_repos; //save the number of public repos to use later
	$GitHubFollowers = $GitHubJSON->followers; //save the number of followers to use later
	$GitHubFollowing = $GitHubJSON->following; //save the number of users following to use later
	
	function CallGitHubRepos() //this function pulls the user's GitHub repository data
	{
		$GitHubURL = "https://api.github.com/users/" . GITHUBUSERNAME . "/repos"; //the GitHub URL for the user's repos
		$GitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubPHPApp','Authorization: token ' . PERSONALACCESSTOKEN . '',); //insert your personal access token
		$GitHubcURL = curl_init(); //initialize cURL
		if(curl_error($GitHubcURL))
		{
			echo 'error: ' . curl_error($GitHubcURL);  // executes if GitHub dies, or cURL dies
		}
		curl_setopt($GitHubcURL, CURLOPT_URL,$GitHubURL); 		//
		curl_setopt($GitHubcURL, CURLOPT_HTTPHEADER, $GitHubHeaders); 	//These headers are as before
		curl_setopt($GitHubcURL, CURLOPT_RETURNTRANSFER, 1);		//
		curl_setopt($GitHubcURL, CURLOPT_CUSTOMREQUEST, "GET");		//
		$GitHubJSON = json_decode(curl_exec($GitHubcURL)); //decode the response
		curl_close($GitHubcURL); // close cURL
		return $GitHubJSON; //return the value of the decoded JSON data
	}
?>

<!-- INSERT THE SECTION BELOW WHERE YOU WANT YOUR PROFILE TO APPEAR -->
<div id="GitHubAPI" style="margin: 0 auto;">
<?php
	echo "
	<section class='panel panel-info'>
		<div class='panel-heading'>
			<h3><a href='" . $GitHubHTMLURL . "'>Follow " . $GitHubName . " on GitHub</a></h3>
		</div>
		<br />
		<div class='panel-body'>
			<img src='" . $GitHubAvatarURL . "' alt='GitHub Avatar' style='width:24%;height:auto;display:inline-block;margin:0 auto;' />
			<div style='display:inline-block; max-width:74%;'>
				<strong>" . $GitHubName . "</strong>
				<br />
				<em>&nbsp;" . $GitHubLogin . "</em>
				<p>" . $GitHubBio . "</p>
			</div>
			<table style='margin:0 auto;' class='table table-condensed table-responsive'>
				<thead>
					<tr>
						<th>Repos</th>
						<th>Followers</th>
                        <th>Following</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>" . $GitHubPubRepos . "</td>
						<td>" . $GitHubFollowers . "</td>
						<td>" . $GitHubFollowing . "</td>
					</tr>
				</tbody>
			</table>
			<br />"; //Echo out the values we saved in the CallGitHub() function as fromatted HTML and CSS.
	foreach($Repos = CallGitHubRepos() as $Data)
	{
		echo "
			<div>
				<strong><a href='" . $Data->html_url . "'>" . $Data->name . "</a></strong>
				<p>" . $Data->description . "</p>
				<p>Primary Language: " . $Data->language . "</p>
			</div>";
	} //list each of the user's repos individually.  This is optional as calling the function repeatedly adds to page load time drastically.
	echo "
		</div>
	</section>
</div>"; //close off the UI
	//That's all!
?>
