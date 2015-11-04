<?php
require __DIR__ . '/../library/bootstrap.php';

$clientIp = getClientIp();
$morsedIp = (new Morse\Text())->toMorse($clientIp);

header('Content-Type: text/html; charset=utf-8');
header('X-Your-IP: ' . $clientIp);
header('X-Your-IP-Morse: ' . $morsedIp);
?>
<!doctype html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>What is my IP-address - Morse my IP.</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <link href="css/morsemyip.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="splash-container">
    <div class="splash">
        <h2>Your IP-address is:</h2>
        <h1 class="splash-head"><?php echo $clientIp; ?></h1>
        <p class="splash-subhead">
            ... --- ...
        </p>
        <p>
            Turn on your speakers for the best experience ;-)
        </p>

        <!--[if lte IE 7 ]><bgsound src="morse.php"><![endif]-->
    </div>
</div>

<div class="content-wrapper">
    <div class="footer l-box is-center">
        Created by Espen Hovlandsdal (<a href="http://twitter.com/rexxars">@rexxars</a>)<br />
        <a href="http://espen.codes/">espen.codes</a>
    </div>
</div>

<script src="js/bundle.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="js/modernizr-1.7.min.js"></script>
<script>
var enableSound = <?php echo isset($_GET['noaudio']) ? 'false' : 'true'; ?>;
jQuery(document).ready(function(d){if(!enableSound){return}var b=navigator.userAgent;var c=/iPad/i.test(b)||/iPhone/i.test(b)||/iPod/i.test(b);if(Modernizr.audio&&Modernizr.audio.wav&&!c){d("#wrapper").append(d("<audio />",{src:"morse.php",autoplay:"autoplay"}))}else{if(c){d("#wrapper").append(d("<iframe />",{src:"morse.wav"}))}else{if(d.browser.msie&&parseInt(d.browser.version,10)<8){return}var a=function(e,f){d.ajax({url:e,cache:true,dataType:"script",success:f})};a("/js/swfobject.js",function(){a("/js/tinywav.js",function(){var e=document.createElement("div");e.setAttribute("id","TinyWavBlock");document.getElementById("wrapper").appendChild(e);var f={scale:"noscale",bgcolor:"#FFFFFF"};swfobject.embedSWF("/embed/wavplayer.swf?gui=none","TinyWavBlock","1","1","10.0.32.18","/embed/expressInstall.swf",{},f,f);window.TinyWav.init()})})}}});
<?php
/*
jQuery(document).ready(function($) {
    if (!enableSound) {
        return;
    }

    var ua = navigator.userAgent;
    var iOS = /iPad/i.test(ua) || /iPhone/i.test(ua) || /iPod/i.test(ua);

    if (Modernizr.audio && Modernizr.audio.wav && !iOS) {
        // HTML5 audio!
        $('#wrapper').append($('<audio />', { src: 'morse.php', autoplay: 'autoplay' }));
    } else if (iOS) {
        // iOS requires click action, not in iframe though
        $('#wrapper').append($('<iframe />', { src: 'morse.wav' }));
    } else {
        if ($.browser.msie && parseInt($.browser.version, 10) < 8) {
            return; // bgsound :D
        }

        // Flash, then. Ugh.
        var ls = function(url, callback) {
            $.ajax({
                url: url,
                cache: true,
                dataType: 'script',
                success: callback
            });
        }

        ls("/js/swfobject.js", function() {
            ls("/js/tinywav.js", function() {
                var player = document.createElement("div");
                player.setAttribute("id", "TinyWavBlock");
                document.getElementById('wrapper').appendChild(player);
                var params = {'scale': 'noscale', 'bgcolor': '#FFFFFF'};
                swfobject.embedSWF("/embed/wavplayer.swf?gui=none", "TinyWavBlock", "1", "1", "10.0.32.18", "/embed/expressInstall.swf", {}, params, params);
                window.TinyWav.init();
            });
        });
    }
});
*/
?>
</script>

</body>
</html>