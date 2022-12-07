<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bins collection day - <?php echo $location_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="<?php echo $current_festivity != $festivity[0] ? '#eb6123' : '#fff';  ?>" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="<?php echo $current_festivity != $festivity[0] ? '#eb6123' : '#000';  ?>" media="(prefers-color-scheme: dark)">
    <meta name="apple-mobile-web-app-title" content="<?php echo $location_name; ?> Bins">
    <meta name="application-name" content="<?php echo $location_name; ?> Bins">
    <style>
    
        #loading {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 1;
        background-color: #0C4622;
        color: #fff;
        z-index: 999999;
        }
        #loading h1{
        color: #fff;
        }
        html[data-theme=dark] #loading {
        filter: invert(1) hue-rotate(180deg);
        background-color: #0C4622 !important;
        color: #fff;
        z-index: 999999;
        }
        .bins-ren a{
            color: #7bdcb5; 
            font-size: 18px; 
            font-weight: 400; 
            letter-spacing: .09rem; 
            line-height: 1.4; 
            text-decoration: none; 
            /* text-decoration-color: #ff746d; */
            border-bottom: 2px solid #ff746d;
            padding-bottom: 4px.
        }

        .bins-ren{
            padding: 20px;
        }

        .bins-ren a:hover{
            color: #ff746d;
        }
        html[data-theme=dark] .bins-ren a {
        filter: invert(1) hue-rotate(180deg);
        }
        
        .chcontainer {
          display: flex;
          justify-content: left;
          align-items: left;
          width: 20px;
          height: 20px;
          padding-left: 40px;
        }
        
        .chevron {
          position: absolute;
            width: 0.7rem;
            height: 0.16rem;
          opacity: 0;
          transform: scale(0.3);
          -webkit-animation: move-chevron 3s ease-out infinite;
                  animation: move-chevron 3s ease-out infinite;
        }
        
        .chevron:first-child {
          -webkit-animation: move-chevron 3s ease-out 1s infinite;
                  animation: move-chevron 3s ease-out 1s infinite;
        }
        
        .chevron:nth-child(2) {
          -webkit-animation: move-chevron 3s ease-out 2s infinite;
                  animation: move-chevron 3s ease-out 2s infinite;
        }
        
        .chevron:before,
        .chevron:after {
          content: "";
          position: absolute;
          top: 0;
          height: 100%;
          width: 50%;
          background: #2c3e50;
        }
        
        .chevron:before {
          left: 0;
          transform: skewY(-30deg);
        }
        
        .chevron:after {
          right: 0;
          width: 50%;
          transform: skewY(30deg);
        }
        
        @-webkit-keyframes move-chevron {
          25% {
            opacity: 0;
            transform: translateY(3.2rem) scale(0.5);
          }
          33.3% {
            opacity: 1;
            transform: translateY(2.08rem);
          }
          66.6% {
            opacity: 1;
            transform: translateY(1.52rem);
          }
          100% {
            opacity: 1;
          }
        }
        
        @keyframes move-chevron {
          25% {
            opacity: 0;
            transform: translateY(3.2rem) scale(0.5);
          }
          33.3% {
            opacity: 1;
            transform: translateY(2.08rem);
          }
          66.6% {
            opacity: 1;
            transform: translateY(1.52rem);
          }
          100% {
            opacity: 1;
          }
        }
        .text-muted{
            padding: 0 0 30px 65px; margin-top: -5px; font-size: 14px;
        }
    </style>

<?php
if ($offline != 1){
    echo '
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://bins.b-cdn.net/bins-main/js/jquery-ui.min.js"></script>';
} else {
    include_once 'js-top.ini';
}
?>
    <script>
                // Capture the current theme from local storage and adjust the page to use the current theme.
const htmlEl = document.getElementsByTagName('html')[0];
const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
<?php 
if ($show_octopus == 1) {
?>
const dismisser = localStorage.getItem('dismiss') ? localStorage.getItem('dismiss') : null;
<?php 
}
?>



// When the user changes the theme, we need to save the new value on local storage
const toggleTheme = (theme) => {
    htmlEl.dataset.theme = theme;
    localStorage.setItem('theme', theme);
    $('#'+theme).addClass('d-none');
    if (theme=='dark'){
        $('#light').removeClass('d-none');
        }else{
        $('#dark').removeClass('d-none');    
        }
}

document.addEventListener('gesturestart', function(e) {
    e.preventDefault();
    // special hack to prevent zoom-to-tabs gesture in safari
    document.body.style.zoom = 0.99;
});

document.addEventListener('gesturechange', function(e) {
    e.preventDefault();
    // special hack to prevent zoom-to-tabs gesture in safari
    document.body.style.zoom = 0.99;
});

document.addEventListener('gestureend', function(e) {
    e.preventDefault();
    // special hack to prevent zoom-to-tabs gesture in safari
    document.body.style.zoom = 0.99;
});

    $( function() {
      $( "#tabs" ).tabs();
    } );
    
    


  function removeTip(){
      const tipState = localStorage.getItem('weather-tip') ? localStorage.getItem('weather-tip') : null;
    if (tipState != null){
          $('#weather-tip').addClass('d-none');
      }
  }

window.onload = function() {
  removeTip();
};

  

function weatherModalOpened() {
        localStorage.setItem('weather-tip', 'off');
        $('#weather-tip').addClass('d-none');
}
    
    // if ('serviceWorker' in navigator) {
    //     caches.keys().then(function(cacheNames) {
    //         cacheNames.forEach(function(cacheName) {
    //         caches.delete(cacheName);
    //         });
    //     });
    // }


   
    </script>
<?php
if ($offline != 1){
    echo '
    <link rel="stylesheet" href="https://bins.b-cdn.net/bins-main/css/jquery-ui.min.css">
    <link rel="stylesheet" href="https://bins.b-cdn.net/bins-main/css/styling-min.css">';
} else {
    include_once 'css-top.ini';
}
?>
    
    <link rel="manifest" href="./manifest.webmanifest" />
    <?php if($offline != 1) {
        ?>
    
    <!-- <script async src="https://cdn.jsdelivr.net/npm/pwacompat" crossorigin="anonymous"></script> -->
    <script>
    // Check compatibility for the browser we're running this in
            if ("serviceWorker" in navigator) {
            if (navigator.serviceWorker.controller) {
                console.log("[PWA Builder] active service worker found, no need to register");
            } else {
                // Register the service worker
                navigator.serviceWorker
                .register("sw.js?v=<?php echo rand(100,999); ?>", {
                    scope: "./"
                })
                .then(function (reg) {
                    console.log("[PWA Builder] Service worker has been registered for scope: " + reg.scope);
                });
            }
            }
            
            
            let displayMode = 'browser';
            const mqStandAlone = '(display-mode: standalone)';
            if (navigator.standalone || window.matchMedia(mqStandAlone).matches) {
                displayMode = 'standalone';
                $('#uwaga').removeClass('d-none');
                console.log('yes, PWA');
            }
            else{
            console.log("not PWA");
            }
    </script>
    <?php
    }
    ?>
    <link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/12.9__iPad_Pro_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/11__iPad_Pro__10.5__iPad_Pro_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/10.9__iPad_Air_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/10.5__iPad_Air_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/10.2__iPad_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_14_Pro_Max__iPhone_14_Max__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_14_Pro__iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_11_Pro_Max__iPhone_XS_Max_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/iPhone_11__iPhone_XR_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/12.9__iPad_Pro_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/11__iPad_Pro__10.5__iPad_Pro_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/10.9__iPad_Air_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/10.5__iPad_Air_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/10.2__iPad_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_14_Pro_Max__iPhone_14_Max__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_14_Pro__iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_11_Pro_Max__iPhone_XS_Max_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/iPhone_11__iPhone_XR_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait.png">
    <link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=b">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=b">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=b" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=b">
    <?php
    if ($current_festivity == $festivity[1]){
    ?>
    <style>
        html[data-theme=dark] {
            --background-primary: #555 !important;
            background-color: #ffefe8 !important;
            --color-primary: #333;
            transition: color .3s,background-color .3s;
        }

        body {
            background: rgb(255,255,255);
            background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(255,186,0,1) 50%, rgba(235,97,35,1) 100%)!important;
            transition: color .3s,background-color .3s;


            background-image: url('../bins-main/img/spider.png');
            background-repeat: no-repeat;
            background-size: 386px 640px;
            background-position: right 10px top 10px;
        }

        
        .ui-widget-header {
            border-top: 1px solid #eb6123;
        }
        .ui-widget.ui-widget-content {
            border: 1px solid #eb6123;
            border-top: 0;
        }
        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
            border: 1px solid #eb6123;
            background: #eb6123;
            font-weight: normal;
            color: #fff;
        }

        .ui-widget-header, .alert, .badge{
            background-color: #eb6123 !important;
            color: #fff;
        }

        .badge p, .fs-4 {
            color: #fff !important;
        }

        .ui-widget-content {
            border: 1px solid #ddd;
            background: #ffffff96;
            background-image: url('../bins-main/img/spider-min.png');
            background-repeat: no-repeat;
            background-size: 386px 640px;
            background-position: right 0px top 10px;
            transition: color .3s,background-color .3s;
        }


        @media screen and (max-width: 640px) {
            .ui-widget-content {
                border: 1px solid #ddd;
                background: #ffffff96;
                background-image: url('../bins-main/img/spider-min.png');
                background-repeat: no-repeat;
                background-size: 193px 320px;
                background-position: right 0px top 10px;
                transition: color .3s,background-color .3s;
            }
        }
    </style>
    <?php
    }
    ?>
    
</head>