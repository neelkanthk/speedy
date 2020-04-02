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
        <meta name="keywords" content="speedy,speedtest,speed test,internet,download,upload,mbps,gbps,fast,bandwidth,speedy.com,speedy.in,speed,internet speed test,upload speed,download speed,broadband speed test,my internet speed is slow, how to check internet speed, slow download speed,3g speed test,4g speed test,VoLTE,5g speed,mobile internet,mobile internet speed,mobile internet speed test">
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
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <!-- Appzi: Capture Insightful Feedback -->
        <script async src="https://w.appzi.io/bootstrap/bundle.js?token=OTQU9"></script>
        <!-- End Appzi -->

    </head>
    <body>
        <div id="logo_title_wrapper">
            <div id="speedy_logo"><img src="logo.png" width="100px" height="100px" /></div>
            <div id="speedy_title">
                <h1>Speedy</h1>
                <h3 id="speedy_tagline">Test your Internet's speed</h3>
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
                </div>
                <div id="social_share_container">
                    <!-- Sharingbutton Facebook -->
                    <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.datatype.in%2Fspeedy" target="_blank" rel="noopener" aria-label="">
                        <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- Sharingbutton Twitter -->
                    <a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=Speedy%20-%20Test%20your%20Internet&#x27;s%20speed&amp;url=https%3A%2F%2Fwww.datatype.in%2Fspeedy" target="_blank" rel="noopener" aria-label="">
                        <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- Sharingbutton LinkedIn -->
                    <a class="resp-sharing-button__link" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https%3A%2F%2Fwww.datatype.in%2Fspeedy&amp;title=Speedy%20-%20Test%20your%20Internet&#x27;s%20speed&amp;summary=Speedy%20-%20Test%20your%20Internet&#x27;s%20speed&amp;source=https%3A%2F%2Fwww.datatype.in%2Fspeedy" target="_blank" rel="noopener" aria-label="">
                        <div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- Sharingbutton WhatsApp -->
                    <a class="resp-sharing-button__link" href="whatsapp://send?text=Speedy%20-%20Test%20your%20Internet&#x27;s%20speed%20https%3A%2F%2Fwww.datatype.in%2Fspeedy" target="_blank" rel="noopener" aria-label="">
                        <div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"/></svg>
                            </div>
                        </div>
                    </a>

                    <!-- Sharingbutton Telegram -->
                    <a class="resp-sharing-button__link" href="https://telegram.me/share/url?text=Speedy%20-%20Test%20your%20Internet&#x27;s%20speed&amp;url=https%3A%2F%2Fwww.datatype.in%2Fspeedy" target="_blank" rel="noopener" aria-label="">
                        <div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M.707 8.475C.275 8.64 0 9.508 0 9.508s.284.867.718 1.03l5.09 1.897 1.986 6.38a1.102 1.102 0 0 0 1.75.527l2.96-2.41a.405.405 0 0 1 .494-.013l5.34 3.87a1.1 1.1 0 0 0 1.046.135 1.1 1.1 0 0 0 .682-.803l3.91-18.795A1.102 1.102 0 0 0 22.5.075L.706 8.475z"/></svg>
                            </div>
                        </div>
                    </a>

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
