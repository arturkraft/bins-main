<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bins collection day - <?php echo $location_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#000" media="(prefers-color-scheme: dark)">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<style>
            :root {
            --background-primary: #fff;
            --color-primary: #333;
            transition: color 300ms, background-color 300ms;
        }

        html[data-theme='dark'] {
            --background-primary: #000;
            --color-primary: #333;
            transition: color 300ms, background-color 300ms;
            filter: invert(1) hue-rotate(180deg);
            height: 100%;
            margin: 0;
            padding: 0;
        }

        html[data-theme='dark'] img {
            filter: invert(1) hue-rotate(180deg)
        }


        html {
            background: var(--background-primary);
            color: var(--color-primary);
            transition: color 300ms, background-color 300ms;

        }

        html, body {
            max-width: 100%;
            min-height: 100%;
            
        }

    body {
        background-size: cover;
        touch-action: manipulation;
    }

    .fc-daygrid-day-number {
        text-decoration: none !important;
    }

    .c-event-main {
        height: 50px;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgb(253 156 20 / 16%);
        background-color: var(--fc-today-bg-color, rgb(253 156 20 / 16%));
    }

    .figure-caption {
        font-family: 'Open Sans Condensed', sans-serif;
        font-size: 1.2em;
        font-weight: 700;
    }


    .ripples-purple .ripple  { 
        background-color : #B721FF ; 
        opacity : .32 ; 
    }

    h1 { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; } 
    h2 { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 2em; font-style: normal; font-variant: normal; font-weight: 200;} 


    .bolder {
        font-weight: 700;
    }

    .thinner {
        font-weight: 300;
    }

    .whitet {
        color: #fff;
    }

    ul.sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        padding: 50px;
        font-size: 17px;
        z-index: 9999 !important;
    }

    .fc-day-today a {
        color: #b7b322 !important;
        font-weight: 600;
    }

    .fc .fc-toolbar-title {
        font-size: 1.4em !important;
        margin: 0;
    }

    @media only screen and (max-width: 640px) {
        .fc .fc-toolbar-title {
            font-size: 1em !important;
            margin: 0;
        }

        .bin {
            width: 80px;
        }
    }

    #tabs {
        padding: 0 !important;
    }



.c-event-main{
    height: 50px;
}
.grayb{
background-color:#737373;
color: #fff;
}
.blueb{
background-color:#007DBB;
color: #fff;
}
.greenb{
background-color:#038831;
color: #fff;
}
.brownb{
background-color:#966757;
color: #fff;
}
.whitet{
color: #fff;
}
.gray{
color: #444;
}
.blue{
color: blue;
}
.green{
color: green;
}
.brown{
color: brown;
}


        .modal-backdrop.show {
          z-index: 9999;
        }

        .bg-secondary{
            background-color: #f5f5f5 !important;
            color: #000 !important;
        }

        .badge{
            width: 7.5rem;
            margin-top:0.3rem;
            padding:0.8rem 0 0 0;
            font-family: Arial,Helvetica,sans-serif !important;
            font-weight: 400 !important;
            border-radius: 1rem;
        }

        .alert{
            font-size: 0.8rem;
        }

        @media (min-width:510px){
            .badge{
                width: 10rem;
            }

            .alert{
                font-size: 1rem;
            }
        }

        .badge p{
            padding-top: 0;
            margin-top: -0.6rem;
        }

        #weather-modal .modal-body, #weather-modal .container{
            padding: 0 !important;
        }

        * {
          margin: 0;
        }

        #content {
            min-height: 100vh;
            height: 100%;
            background-color: #fff;
        }

        #bottom-text {
            position: absolute;
            bottom: 0;
        }

        h1,
        h2,
        h3,
        h4,
        p {
            color: var(--color-primary);

        }

        h1{
            padding-left: 0.1em;
        }

        .grey {
            color: <?php echo $grey->getColour();
            ?>;
        }

        .blue {
            color: <?php echo $blue->getColour();
            ?>;
        }

        .green {
            color: <?php echo $green->getColour();
            ?>;
        }

        .brown {
            color: <?php echo $brown->getColour();
            ?>;
        }


        @font-face {
        font-family: 'icomoon';
        src:  url('https://arturkraft.b-cdn.net/bins-main/fonts/icons.eot?hvdo0f');
        src:  url('https://arturkraft.b-cdn.net/bins-main/fonts/icons.eot?hvdo0f#iefix') format('embedded-opentype'),
            url('https://arturkraft.b-cdn.net/bins-main/fonts/icons.ttf?hvdo0f') format('truetype'),
            url('https://arturkraft.b-cdn.net/bins-main/fonts/icons.woff?hvdo0f') format('woff'),
            url('https://arturkraft.b-cdn.net/bins-main/fonts/icons.svg?hvdo0f#icomoon') format('svg');
        font-weight: normal;
        font-style: normal;
        font-display: block;
        }

        [class^="icon-"], [class*=" icon-"] {
        /* use !important to prevent issues with browser extensions that change fonts */
        font-family: 'icomoon' !important;
        speak: never;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;

        /* Better Font Rendering =========== */
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        }

        .icon-one-finger-swipe-horizontally:before {
        content: "\e905";
        }
        .icon-wind:before {
        content: "\e904";
        }
        .icon-sun:before {
        content: "\e906";
        }
        .icon-rainy:before {
        content: "\e902";
        }
        .icon-cloud:before {
        content: "\e902";
        }
        .icon-weather:before {
        content: "\e902";
        }
        .icon-calendar:before {
        content: "\e953";
        }
        .icon-gift:before {
        content: "\e99f";
        }
        .icon-sort-amount-desc:before {
        content: "\ea4d";
        }
        .icon-system_update:before {
        content: "\e907";
        }
        .icon-delete:before {
        content: "\e903";
        }
        .icon-toggle-on:before {
        content: "\e900";
        }
        .icon-toggle-off:before {
        content: "\e901";
        }
        .icon-cancel-circle:before {
        content: "\ea0d";
        }
        .icon-checkmark:before {
        content: "\ea10";
        }
        .icon-heart-broken:before {
        content: "\e9db";
        }

        .icon-goodli:before { content: '\ea10'; margin-left: -20px; margin-right: 10px; } 

        .icon-badli:before { content: '\ea0d'; margin-left: -20px; margin-right: 10px; } 



.ripple {
  position: absolute;
  background: #aaa;
  border-radius: 50%;
  width: 5px;
  height: 5px;
  animation: rippleEffect .88s 1;
  opacity: 0;
}

@keyframes rippleEffect {
  0% {
    transform: scale(1);
    opacity: 0.4;
  }
  100% {
    transform: scale(100);
    opacity: 0;
  }
}


    </style>



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
    <link rel="manifest" href="/site.webmanifest?v=b">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=b" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=b">
    <meta name="apple-mobile-web-app-title" content="<?php echo $location_name; ?> Bins">
    <meta name="application-name" content="<?php echo $location_name; ?> Bins">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://arturkraft.b-cdn.net/bins-main/js/jquery-ui.min.js"></script>

    <script>
                // Capture the current theme from local storage and adjust the page to use the current theme.
const htmlEl = document.getElementsByTagName('html')[0];
const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
const dismisser = localStorage.getItem('dismiss') ? localStorage.getItem('dismiss') : null;



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

    $( function() {
      $( "#tabs" ).tabs();
    } );
    </script>
    
<?php

echo $gtag;

?>
</head>