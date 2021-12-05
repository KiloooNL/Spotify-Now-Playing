<?php
require 'vendor/autoload.php';

// Set this to whatever your Redirect Uri is on the Spotify dev app
$redirectUri = 'https://audiolink.com.au/spotify/index.php';

// If you want marquee (moving song title)
$marquee = false;

$session = new SpotifyWebAPI\Session(
'ClientID',
'ClientSecret',
$redirectUri
);

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
$session->requestAccessToken($_GET['code']);
$api->setAccessToken($session->getAccessToken());
} else {
$options = [
'scope' => [
'user-read-email', 'user-library-read', 'user-read-playback-position','user-read-recently-played', 'user-read-currently-playing', 'user-read-playback-state'
],
];

header('Location: ' . $session->getAuthorizeUrl($options));
die();
}

$artist = '';
$album = '';
$track = '';

$trackInfo = $api->getMyCurrentTrack();
if(isset($trackInfo)) {
    $track = $trackInfo->item->name;
    $artists = $trackInfo->item->album->artists;
    foreach($artists as $value) {
        $artist = $value->name;
    }
    $image = $trackInfo->item->album->images[1];
    $image = $image->url;
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
        }
        .card {
            flex-direction: row;
        }

        .card img {
            max-width: 90px;
            max-height:90px;;
        }

        .marquee {
            width: auto;
            margin: 0 auto;
            overflow: hidden;
            box-sizing: border-box;
        }

        .marquee span {
            display: inline-block;
            width: max-content;

            padding-left: 100%;
            /* show the marquee just outside the paragraph */
            will-change: transform;
            animation: marquee 10s linear;
        }

        @keyframes marquee {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-100%, 0); }
        }
        /* Respect user preferences about animations */
        @media (prefers-reduced-motion: reduce) {
            .marquee span {
                animation-iteration-count: 1;
                animation-duration: 0.05;
                /* instead of animation: none, so an animationend event is
                 * still available, if previously attached.
                 */
                width: auto;
                padding-left: 0;
            }
        }
    </style>
</head>
<body class="text-nowrap">
<div class="card rounded" style="width: 350px; background-color: #21262d; color: white;">
    <img src="<?php echo $image; ?>" class="img-rounded m-2" alt="">
    <div class="card-body">
        <span class="card-title text-muted">Now playing</span>
        <p class="card-text">
            <?php if($marquee) { ?>
            <span><?php echo $artist; ?></span>
		<div class="marquee">
		    <span><?php echo $track; ?></span>
		</div>
            <?php } else {
                echo $artist . '<br />';
                echo $track;
                } ?>
        </p>
    </div>
</div>

</body>
</html>
<?php
}
?>
<script>
    var delay = ( function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    delay(function(){
        var url="<?php echo $redirectUri; ?>";
        window.location.href=url;
    }, 10000 );
</script>

<?php ?>
