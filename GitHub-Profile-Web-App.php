<?php
//Put this block in the header of the page to decrease load time.
	function CallGitHub() //this function pulls the user's GitHub Profile data
	{
		$GitHubURL = "https://api.github.com/user"; //pull your user data from GitHub
		$GitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubPHPApp','Authorization: token INSERT YOUR TOKEN HERE',); //insert your personal access token
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
		$GitHubURL = "https://api.github.com/users/YOUR GITHUB USERNAME/repos"; //the GitHub URL for the user's repos
		$GitHubHeaders = array('User-Agent: jamesphillipsuk-GitHubPHPApp','Authorization: token INSERT YOUR TOKEN HERE',); //insert your personal access token
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
<div id="GitHubAPI" style="margin: 0 auto 0 auto;">

<?php
	echo "
	<div style='width:94%;margin: 0 auto 0 auto;padding:0 1% 0 1%;border: 0.1rem #CECECE solid;border-radius:0.5rem;'>
		<h4><a style='color: inherit;text-decoration:none;' href='" . $GitHubHTMLURL . "'>Follow " . $GitHubName . " on GitHub</a></h4>
		<hr style='margin:0 0 0 0;' />
		<img src='" . $GitHubAvatarURL . "' alt='GitHub Avatar' style='width:25%;height:auto;display:inline-block;margin:0 auto 0 auto;' />
		<div style='display:inline-block; max-width:75%;'>
			<strong style='font-size:1rem;'>" . $GitHubName . "</strong>
			<br />
			<em style='font-size:0.8rem;'>&nbsp;" . $GitHubLogin . "</em>
			<p style='font-size:0.6rem;'>" . $GitHubBio . "</p>
		</div>
		<table style='border: 0.1rem #CECECE solid;font-size:0.8rem; margin:0 auto 0 auto;'>
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
		<div style='width:90%;height:auto;display:block;margin:0 auto 0.2rem auto;background-color:#ECECEC;'>
			<h5 style='font-size:0.8rem;'><a style='color: inherit;text-decoration:none;' href='" . $Data->html_url . "'>" . $Data->name . "</a></h5>
			<p style='font-size:0.6rem;'>" . $Data->description . "</p>
			<p style='font-size:0.8rem;'>Primary Language: " . $Data->language . "</p>
		</div>";
	} //list each of the user's repos individually.  This is optional as calling the function repeatedly adds to page load time drastically.
  
	echo "</div>"; //close off the UI
	
?>

</div>
<?php
	//That's all!
?>
