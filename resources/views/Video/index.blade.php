<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos</title>
</head>

<body>
    <div style="    display: flex;    justify-content: center;">
        <video width="1080px" height="auto" autoplay controls id="videoPlayer" style="    width: 100%;    height: 95vh;">
            <source src="/videos/1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>


    <script>
        var nextVideo = ["/videos/1.mp4", "/videos/2.mp4", "/videos/3.mp4", "/videos/4.mp4", "/videos/5.mp4", "/videos/6.mp4"];
        //var nextVideo = ["videos/tvservicioalcliente.mp4"];
        var curVideo = 0;
        var validador = 0;
        var videoPlaye = document.getElementById('videoPlayer');
        videoPlaye.autoplay = true;
        videoPlaye.load();
        videoPlaye.volume = 0.2;

        videoPlaye.onended = function() {
            if (curVideo < nextVideo.length) {
                if (validador == 0 && curVideo == 0) {
                    curVideo = 1;
                }
                videoPlaye.src = nextVideo[curVideo];
                ++curVideo;
                if (curVideo == nextVideo.length) {
                    curVideo = 0;
                    validador = 1;
                }
            }
        }
    </script>
</body>

</html>