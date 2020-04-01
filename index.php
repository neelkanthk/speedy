<!DOCTYPE html>
<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162399694-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-162399694-1');
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no" />
        <meta charset="UTF-8" />
        <meta name="description" content="Test your Internet's speed." />
        <meta name="keywords" content="speedy, speedtest, internet, download, upload, mbps, gbps, fast, bandwidth, speed.com, speedy.com, speed.in. speed, internetspeed, uploadspeed, downloadspeed, fast">
        <meta name="author" content="https://www.datatype.in">
        <meta property="og:image" content="https://www.datatype.in/speedy/logo.png" />
        <meta property="og:image:width" content="128"/>
        <meta property="og:image:height" content="128"/>
        <link rel="shortcut icon" href="favicon.ico">
        <title>Speedy-Test your Internet's speed</title>
        <script type="text/javascript" src="speedtest.js"></script>
        <script type="text/javascript">
            function I(i) {
                return document.getElementById(i);
            }
            //INITIALIZE SPEEDTEST
            var s = new Speedtest(); //create speedtest object

            var meterBk = /Trident.*rv:(\d+\.\d+)/i.test(navigator.userAgent) ? "#EAEAEA" : "#80808040";
            var dlColor = "#FF8800",
                    ulColor = "#0099CC";
            var progColor = meterBk;

            //CODE FOR GAUGES
            function drawMeter(c, amount, bk, fg, progress, prog) {
                var ctx = c.getContext("2d");
                var dp = window.devicePixelRatio || 1;
                var cw = c.clientWidth * dp, ch = c.clientHeight * dp;
                var sizScale = ch * 0.0055;
                if (c.width == cw && c.height == ch) {
                    ctx.clearRect(0, 0, cw, ch);
                } else {
                    c.width = cw;
                    c.height = ch;
                }
                ctx.beginPath();
                ctx.strokeStyle = bk;
                ctx.lineWidth = 12 * sizScale;
                ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, Math.PI * 0.1);
                ctx.stroke();
                ctx.beginPath();
                ctx.strokeStyle = fg;
                ctx.lineWidth = 12 * sizScale;
                ctx.arc(c.width / 2, c.height - 58 * sizScale, c.height / 1.8 - ctx.lineWidth, -Math.PI * 1.1, amount * Math.PI * 1.2 - Math.PI * 1.1);
                ctx.stroke();
                if (typeof progress !== "undefined") {
                    ctx.fillStyle = prog;
                    ctx.fillRect(c.width * 0.3, c.height - 16 * sizScale, c.width * 0.4 * progress, 4 * sizScale);
                }
            }
            function mbpsToAmount(s) {
                return 1 - (1 / (Math.pow(1.3, Math.sqrt(s))));
            }
            function format(d) {
                d = Number(d);
                if (d < 10)
                    return d.toFixed(2);
                if (d < 100)
                    return d.toFixed(1);
                return d.toFixed(0);
            }

            //UI CODE
            var uiData = null;
            function startStop() {
                if (s.getState() == 3) {
                    //speedtest is running, abort
                    gtag('event', 'abort', {'event_category': 'SpeedTest', 'event_label': 'SpeedTest Abort'});
                    s.abort();
                    data = null;
                    I("startStopBtn").className = "";
                    initUI();
                } else {
                    //test is not running, begin
                    I("startStopBtn").className = "running";
                    s.onupdate = function (data) {
                        uiData = data;
                    };
                    s.onend = function (aborted) {
                        I("startStopBtn").className = "";
                        updateUI(true);
                    };
                    gtag('event', 'start', {'event_category': 'SpeedTest', 'event_label': 'SpeedTest Start'});
                    s.start();
                }
            }
            //this function reads the data sent back by the test and updates the UI
            function updateUI(forced) {
                if (!forced && s.getState() != 3)
                    return;
                if (uiData == null)
                    return;
                var status = uiData.testState;
                I("ip").textContent = 'Your public IP address: ' + uiData.clientIp;
                I("dlText").textContent = (status == 1 && uiData.dlStatus == 0) ? "..." : format(uiData.dlStatus);
                drawMeter(I("dlMeter"), mbpsToAmount(Number(uiData.dlStatus * (status == 1 ? oscillate() : 1))), meterBk, dlColor, Number(uiData.dlProgress), progColor);
                I("ulText").textContent = (status == 3 && uiData.ulStatus == 0) ? "..." : format(uiData.ulStatus);
                drawMeter(I("ulMeter"), mbpsToAmount(Number(uiData.ulStatus * (status == 3 ? oscillate() : 1))), meterBk, ulColor, Number(uiData.ulProgress), progColor);
                I("pingText").textContent = format(uiData.pingStatus);
                I("jitText").textContent = format(uiData.jitterStatus);
            }
            function oscillate() {
                return 1 + 0.02 * Math.sin(Date.now() / 100);
            }
            //update the UI every frame
            window.requestAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || (function (callback, element) {
                setTimeout(callback, 1000 / 60);
            });
            function frame() {
                requestAnimationFrame(frame);
                updateUI();
            }
            frame(); //start frame loop
            //function to (re)initialize UI
            function initUI() {
                drawMeter(I("dlMeter"), 0, meterBk, dlColor, 0);
                drawMeter(I("ulMeter"), 0, meterBk, ulColor, 0);
                I("dlText").textContent = "";
                I("ulText").textContent = "";
                I("pingText").textContent = "";
                I("jitText").textContent = "";
                I("ip").textContent = "";
            }
        </script>
        <style type="text/css">
            html,body{
                border:none; padding:0; margin:0;
                background:#FFFFFF;
                color:#202020;
            }
            body{
                text-align:center;
                font-family:"Roboto",sans-serif;
            }
            h1{
                color:#404040;
            }
            #startStopBtn{
                display:inline-block;
                margin:0 auto;
                color:#FFFFFF;
                background-color:#00C851;
                border:none;
                border-radius:0.3em;
                transition:all 0.3s;
                box-sizing:border-box;
                width:8em; height:3em;
                line-height:2.7em;
                cursor:pointer;
                box-shadow: 0 0 0 rgba(0,0,0,0.1), inset 0 0 0 rgba(0,0,0,0.1);
            }
            #startStopBtn:hover{
                box-shadow: 0 0 2em rgba(0,0,0,0.1), inset 0 0 1em rgba(0,0,0,0.1);
            }
            #startStopBtn.running{
                background-color:#FF4444;
                border-color:#FF6060;
                color:#FFFFFF;
            }
            #startStopBtn:before{
                content:"Start";
            }
            #startStopBtn.running:before{
                content:"Abort";
            }
            #test{
                margin-top:2em;
                margin-bottom:7em;
            }
            div.testArea{
                display:inline-block;
                width:16em;
                height:12.5em;
                position:relative;
                box-sizing:border-box;
            }
            div.testArea2{
                display:inline-block;
                width:14em;
                height:7em;
                position:relative;
                box-sizing:border-box;
                text-align:center;
            }
            div.testArea div.testName{
                position:absolute;
                top:0.1em; left:0;
                width:100%;
                font-size:1.4em;
                z-index:9;
            }
            div.testArea2 div.testName{
                display:block;
                text-align:center;
                font-size:1.4em;
            }
            div.testArea div.meterText{
                position:absolute;
                bottom:1.55em; left:0;
                width:100%;
                font-size:2.5em;
                z-index:9;
            }
            div.testArea2 div.meterText{
                display:inline-block;
                font-size:2.5em;
            }
            div.meterText:empty:before{
                content:"0.00";
            }
            div.testArea div.unit{
                position:absolute;
                bottom:2em; left:0;
                width:100%;
                z-index:9;
            }
            div.testArea2 div.unit{
                display:inline-block;
            }
            div.testArea canvas{
                position:absolute;
                top:0; left:0; width:100%; height:100%;
                z-index:1;
            }
            div.testGroup{
                display:block;
                margin: 0 auto;
            }
            #logo_title_wrapper {
                width:395px;
                margin-left: 36%;
                overflow: hidden; /* will contain if #first is longer than #second */
            }
            #speedy_logo {
                width: 10px;
                float:left;
            }
            #speedy_title {
                margin-top: 6%;
                overflow: hidden;
            }
            #speedy_tagline{
                margin-left: 19%;
                margin-top: -4%;
            }
            @media all and (max-width:40em){
                body{
                    font-size:0.8em;
                }
            }
        </style>
        <!-- Appzi: Capture Insightful Feedback -->
        <script async src="https://w.appzi.io/bootstrap/bundle.js?token=OTQU9"></script>
        <!-- End Appzi -->

    </head>
    <body>
        <div id="logo_title_wrapper">
            <div id="speedy_logo"><img src="logo.png" /></div>
            <div id="speedy_title">
                <h1>Speedy</h1>
                <p id="speedy_tagline">Test your Internet's speed</p>
            </div>
        </div>

        <p></p>
        <div id="testWrapper">
            <div id="startStopBtn" onclick="startStop()"></div>
            <div id="test">
                <div style="display: none;" class="testGroup">
                    <div class="testArea2">
                        <div class="testName">Ping</div>
                        <div id="pingText" class="meterText" style="color:#AA6060"></div>
                        <div class="unit">ms</div>
                    </div>
                    <div class="testArea2">
                        <div class="testName">Jitter</div>
                        <div id="jitText" class="meterText" style="color:#AA6060"></div>
                        <div class="unit">ms</div>
                    </div>
                </div>
                <div class="testGroup">
                    <div class="testArea">
                        <div class="testName">Download</div>
                        <canvas id="dlMeter" class="meter"></canvas>
                        <div id="dlText" class="meterText"></div>
                        <div class="unit">Mbps</div>
                    </div>
                    <div class="testArea">
                        <div class="testName">Upload</div>
                        <canvas id="ulMeter" class="meter"></canvas>
                        <div id="ulText" class="meterText"></div>
                        <div class="unit">Mbps</div>
                    </div>
                </div>
                <div id="ipArea">
                    <span id="ip"></span>
                    <p></p>
                    <strong>Test Server: </strong><span>13.232.15.239 (Mumbai, India)</span>
                </div>
            </div>
            <p>
                <a href="#" onclick="gtag('event', 'click', {'event_category': 'SpeedyRepository', 'event_label': 'Visit'});">Speedy</a> 
                <span>is based on</span> 
                <a href="https://github.com/librespeed/speedtest" onclick="gtag('event', 'click', {'event_category': 'LibrespeedtestRepository', 'event_label': 'Visit'});" target="_blank">LibreSpeed</a>
            </p>
            <div>Icons made by <a href="https://www.flaticon.com/authors/vectors-market" title="Vectors Market">Vectors Market</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
        </div>
        <script type="text/javascript">setTimeout(function () {
                initUI()
            }, 100);</script>
    </body>
</html>
