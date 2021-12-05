# Spotify Now Playing
This PHP file shows a very simple web page of what is currently playing on your Spotify account.
![](https://i.imgur.com/tKPu6TT.png)

The page refreshes every 10 seconds to get data from Spotify.
You can also use this as a browser source in OBS or StreamLabs to show your currently playing track in-stream.

# How to use
Edit the $redirectUri variable to your RedirectURI on the Shopify Developer portal. Enter your ClientID and ClientSecret in the $session array. Done!

# Dependencies:
  - Bootstrap 5
  - Javascript
  - [Spotify Web API PHP](https://github.com/jwilsson/spotify-web-api-php "Spotify Web API PHP")
  - PHP 7.3 or later.
  - PHP cURL extension (Usually included with PHP).
