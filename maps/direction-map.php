<?php
    session_start();
    if(isset($_GET['driving_mode'])){
        $driving_mode_get = $_GET['driving_mode'];
        if($driving_mode_get == 'bicycle'){
            $driving_mode = 'BICYCLING';
            $bicycle_active = 'active';
        }
        elseif($driving_mode_get == 'walking'){
            $driving_mode = 'WALKING';
            $walking_active = 'active';
        }
        else{
            $driving_mode = 'DRIVING';
            $driving_active = 'active';
        }
    }
    else{
        $driving_mode = 'DRIVING';
        $driving_active = 'active';
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- playground-hide -->
    <script>
      const process = { env: {} };
      process.env.GOOGLE_MAPS_API_KEY =
        "AIzaSyCg00mHPgPKiKuODJTQaYhet6MDIivqUBk";
    </script>
    <!-- playground-hide-end -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
#map{
    height: 100%;
}
html,
body{
    height: 100%;
    margin: 0;
    padding: 0;
}
.box-shadow{
    box-shadow: rgb(221 221 221) 0px 0px 7px 1px;
    border-radius: 4px;
}
#floating-panel{
    position: absolute;
    top: 0px;
    z-index: 5;
    width: 31%;
    left: 0px;
    background: #fff;
    min-height: 100%;
    border-radius: 0px;
}

.deactive {
    left: -31% !important;
}



#floating-panel .form-group input {
    width: 100%;
    padding: 6px 8px;
    font-size: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    height: 40px;
}

#floating-panel .form-group {
    padding: 10px 12px;
    display: flex;
}

#floating-panel .form-group input:focus {
    outline: auto;
    outline-color: #b7cdf19c;
}
#floating-panel .form-group ul {
    margin: 0px;
    list-style: none;
    display: flex;
    padding: 0px;
}

#floating-panel .form-group ul li {
    margin: 4px 4px;
    border-radius: 20px;
    border: 1px solid #9cc0f940;
    padding: 7px 12px;
    line-height: 14px;
    background: #fff;
}
#floating-panel .form-group ul li.active {
    background: #9cc0f940;
}
#floating-panel .form-group ul li a {
    font-size: 14px;
    color: #2b2b2b;
    font-weight: 500;
    text-decoration: none;
}
#floating-panel .form-group ul li a svg {
    font-size: 16px;
    margin-bottom: -3px;
    color: #2b2b2b;
    font-weight: 500;
}
#floating-panel .form-group ul li.active a svg, 
#floating-panel .form-group ul li.active a {
    color: #00539b;
}
#floating-panel .form-group ul li:hover
{
    background: #9cc0f940;
}
#floating-panel .form-group ul li:hover a{
    color: #00539b;
}
.address_details {
    float: left;
    width: 70%;
}

.address_time {
    width: 30%;
    float: right;
    margin: 6px 0px;
}

.address_details p {
    margin-bottom: 0px;
    font-size: 15px;
    font-weight: 500;
    color: #6c6c6c;
}

.address_time p {
    margin: 0px;
    font-size: 13px;
    text-align: right;
    font-weight: 500;
    color: #BA6F18;
}

.address_time span {
    text-align: right;
    float: right;
    font-size: 12px;
    font-weight: 500;
    color: #747070;
}
.hidden-tab {
    top: 40%;
    bottom: 40%;
    position: absolute;
    left: 100%;
}
.hidden-tab a {
    background: #fff;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    padding: 6px 0px;
}
.hidden-tab svg {
    font-size: 26px;
    margin-left: -7px;
    margin-right: -3px;
    margin-bottom: -7px;
    color: #06f;
}


/* mobile-floating-panel-header */
.mobile-floating-panel-top{
    display: none;
    position: absolute;
    z-index: 5;
    width: 100%;
    margin-top: 10px;
}
.mobile-floating-panel-top .back {
    width: 20%;
    margin: auto;
}

.mobile-floating-panel-top .center {
    width: 40%;
    margin: auto;
}

.mobile-floating-panel-top .right {
    width: 20%;
    margin: 4px auto;
}
.mobile-floating-panel-top .back a{
    padding: 6px 9px;
    background: #fff;
    font-size: 16px;
    color: #116df8;
}
.mobile-floating-panel-top .back a:hover {
    transition: 0.3s;
    color: #2479fb;
}

.mobile-floating-panel-top .back a svg ,
.mobile-floating-panel-top .right p svg{
    margin-bottom: -2px;
    font-weight: 600;
}
.mobile-floating-panel-top .right{
    float: right;
}
.mobile-floating-panel-top .right p{
    padding: 5px 9px;
    background: #fff;
    font-size: 16px;
    width: 33px;
    text-align: right;
    margin: auto;
    margin-right: 0px;
    color: #116df8;
}

.mobile-floating-panel-top .center h4 {
    margin: 0px;
    text-align: center;
    font-size: 16px;
    font-weight: 700;
    color: #2b2b2b;
}


.mobile-floating-panel-bottom{
    display: none;
    position: absolute;
    z-index: 5;
    height: auto;
    background: #fff;
    width: 100%;
    border-radius: 10px;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    padding-top: 0px;
    padding-bottom: 15px;
}
#mobile-floating-panel{
    bottom: 0px;
}
.m-deactive{
    bottom: -170px !important;
    transition: 0.3s !important;
}
.mobile-floating-panel-bottom .m-hidden_btn-section {
    text-align: center;
    padding: 10px 0px;
}
.mobile-floating-panel-bottom .m-hidden_btn-section span {
    color: #116df8;
    font-weight: 700;
}
.m-tab {
    height: 5px;
    background: #57a9f7;
    width: 50px;
    margin: auto;
    border: none;
    border-radius: 4px;
    margin-bottom: 12px;
}

.mobile-floating-panel-bottom .pro-main-section {
    width: 100%;
    display: inline-flex;
    margin: 6px 0px;
}
.mobile-floating-panel-bottom .pro-main-section .profile-section {
    width: 65%;
    margin: 0px;
    display: flex;
}

.mobile-floating-panel-bottom .pro-main-section .contact-btn {
    width: 35%;
    text-align: center;
    margin: auto;
}

.mobile-floating-panel-bottom .pro-main-section .profile-section  .profile-img img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 1px solid #116df8;
}

.mobile-floating-panel-bottom .pro-main-section .profile-section .profile-img {
    margin: auto 10px;
}

.mobile-floating-panel-bottom .pro-main-section .profile-section .profile-details h4 {
    font-size: 16px;
    margin-bottom: 0px;
    font-weight: 600;
    color: #2b2b2b;
}

.mobile-floating-panel-bottom .pro-main-section .profile-section .profile-details {
    margin: auto 2px;
}

.mobile-floating-panel-bottom .pro-main-section .profile-section .profile-details p {
    margin-bottom: 0px;
    font-size: 12px;
    color: #545252;
    font-weight: 500;
}
.mobile-floating-panel-bottom .pro-main-section .contact-btn a {
    text-align: center;
    background: #116df8;
    padding: 10px 9px;
    border: none;
    border-radius: 50%;
    margin: auto 3px;
}

.mobile-floating-panel-bottom .pro-main-section .contact-btn a svg {
    font-size: 22px;
    margin-bottom: -5px;
    color: #fff;
}

.mobile-floating-panel-bottom .pro-main-section .contact-btn a:hover {
    transition: 0.3s;
    background: #2479fb;
}

.mobile-floating-panel-bottom .address-details {
    display: inline-flex;
    width: 100%;
    margin: 10px auto;
}

.mobile-floating-panel-bottom .address-details .location-icon {
    width: 15%;
    margin: auto;
    text-align: center;
}

.mobile-floating-panel-bottom .address-details .address {
    width: 85%;
    margin: auto;
}

.mobile-floating-panel-bottom .address-details .location-icon svg {
    font-size: 20px;
    color: #116df8;
    margin-bottom: -4px;
}

.mobile-floating-panel-bottom .address-details .address p {
    margin: auto;
    font-size: 13px;
    font-weight: 400;
    color: #7e7e7e;
}
.mobile-floating-panel-bottom .address-details .address h4 {
    font-size: 16px;
    margin: 0;
    font-weight: 600;
    color: #515050;
}

.mobile-floating-panel-bottom .address-details .address h4 span {
    font-size: 12px;
    color: #116df8;
}
.mobile-floating-panel-bottom .order-action {
    margin: 3px 10px;
}

.mobile-floating-panel-bottom .order-action a {
    background: #126df7;
    color: #fff;
    font-weight: 600;
}

.mobile-floating-panel-bottom .order-action a:hover {
    transition: 0.3s;
    background: #2479fb;
}


img[src="data:image/svg+xml,%3Csvg%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2069%2029%22%3E%3Cg%20opacity%3D%22.6%22%20fill%3D%22%23fff%22%20stroke%3D%22%23fff%22%20stroke-width%3D%221.5%22%3E%3Cpath%20d%3D%22M17.4706%207.33616L18.0118%206.79504%2017.4599%206.26493C16.0963%204.95519%2014.2582%203.94522%2011.7008%203.94522c-4.613699999999999%200-8.50262%203.7551699999999997-8.50262%208.395779999999998C3.19818%2016.9817%207.0871%2020.7368%2011.7008%2020.7368%2014.1712%2020.7368%2016.0773%2019.918%2017.574%2018.3689%2019.1435%2016.796%2019.5956%2014.6326%2019.5956%2012.957%2019.5956%2012.4338%2019.5516%2011.9316%2019.4661%2011.5041L19.3455%2010.9012H10.9508V14.4954H15.7809C15.6085%2015.092%2015.3488%2015.524%2015.0318%2015.8415%2014.403%2016.4629%2013.4495%2017.1509%2011.7008%2017.1509%209.04835%2017.1509%206.96482%2015.0197%206.96482%2012.341%206.96482%209.66239%209.04835%207.53119%2011.7008%207.53119%2013.137%207.53119%2014.176%208.09189%2014.9578%208.82348L15.4876%209.31922%2016.0006%208.80619%2017.4706%207.33616z%22/%3E%3Cpath%20d%3D%22M24.8656%2020.7286C27.9546%2020.7286%2030.4692%2018.3094%2030.4692%2015.0594%2030.4692%2011.7913%2027.953%209.39011%2024.8656%209.39011%2021.7783%209.39011%2019.2621%2011.7913%2019.2621%2015.0594c0%203.25%202.514499999999998%205.6692%205.6035%205.6692zM24.8656%2012.8282C25.8796%2012.8282%2026.8422%2013.6652%2026.8422%2015.0594%2026.8422%2016.4399%2025.8769%2017.2905%2024.8656%2017.2905%2023.8557%2017.2905%2022.8891%2016.4331%2022.8891%2015.0594%2022.8891%2013.672%2023.853%2012.8282%2024.8656%2012.8282z%22/%3E%3Cpath%20d%3D%22M35.7511%2017.2905v0H35.7469C34.737%2017.2905%2033.7703%2016.4331%2033.7703%2015.0594%2033.7703%2013.672%2034.7343%2012.8282%2035.7469%2012.8282%2036.7608%2012.8282%2037.7234%2013.6652%2037.7234%2015.0594%2037.7234%2016.4439%2036.7554%2017.2962%2035.7511%2017.2905zM35.7387%2020.7286C38.8277%2020.7286%2041.3422%2018.3094%2041.3422%2015.0594%2041.3422%2011.7913%2038.826%209.39011%2035.7387%209.39011%2032.6513%209.39011%2030.1351%2011.7913%2030.1351%2015.0594%2030.1351%2018.3102%2032.6587%2020.7286%2035.7387%2020.7286z%22/%3E%3Cpath%20d%3D%22M51.953%2010.4357V9.68573H48.3999V9.80826C47.8499%209.54648%2047.1977%209.38187%2046.4808%209.38187%2043.5971%209.38187%2041.0168%2011.8998%2041.0168%2015.0758%2041.0168%2017.2027%2042.1808%2019.0237%2043.8201%2019.9895L43.7543%2020.0168%2041.8737%2020.797%2041.1808%2021.0844%2041.4684%2021.7772C42.0912%2023.2776%2043.746%2025.1469%2046.5219%2025.1469%2047.9324%2025.1469%2049.3089%2024.7324%2050.3359%2023.7376%2051.3691%2022.7367%2051.953%2021.2411%2051.953%2019.2723v-8.8366zm-7.2194%209.9844L44.7334%2020.4196C45.2886%2020.6201%2045.878%2020.7286%2046.4808%2020.7286%2047.1616%2020.7286%2047.7866%2020.5819%2048.3218%2020.3395%2048.2342%2020.7286%2048.0801%2021.0105%2047.8966%2021.2077%2047.6154%2021.5099%2047.1764%2021.7088%2046.5219%2021.7088%2045.61%2021.7088%2045.0018%2021.0612%2044.7336%2020.4201zM46.6697%2012.8282C47.6419%2012.8282%2048.5477%2013.6765%2048.5477%2015.084%2048.5477%2016.4636%2047.6521%2017.2987%2046.6697%2017.2987%2045.6269%2017.2987%2044.6767%2016.4249%2044.6767%2015.084%2044.6767%2013.7086%2045.6362%2012.8282%2046.6697%2012.8282zM55.7387%205.22083v-.75H52.0788V20.4412H55.7387V5.220829999999999z%22/%3E%3Cpath%20d%3D%22M63.9128%2016.0614L63.2945%2015.6492%2062.8766%2016.2637C62.4204%2016.9346%2061.8664%2017.3069%2061.0741%2017.3069%2060.6435%2017.3069%2060.3146%2017.2088%2060.0544%2017.0447%2059.9844%2017.0006%2059.9161%2016.9496%2059.8498%2016.8911L65.5497%2014.5286%2066.2322%2014.2456%2065.9596%2013.5589%2065.7406%2013.0075C65.2878%2011.8%2063.8507%209.39832%2060.8278%209.39832%2057.8445%209.39832%2055.5034%2011.7619%2055.5034%2015.0676%2055.5034%2018.2151%2057.8256%2020.7369%2061.0659%2020.7369%2063.6702%2020.7369%2065.177%2019.1378%2065.7942%2018.2213L66.2152%2017.5963%2065.5882%2017.1783%2063.9128%2016.0614zM61.3461%2012.8511L59.4108%2013.6526C59.7903%2013.0783%2060.4215%2012.7954%2060.9017%2012.7954%2061.067%2012.7954%2061.2153%2012.8161%2061.3461%2012.8511z%22/%3E%3C/g%3E%3Cpath%20d%3D%22M11.7008%2019.9868C7.48776%2019.9868%203.94818%2016.554%203.94818%2012.341%203.94818%208.12803%207.48776%204.69522%2011.7008%204.69522%2014.0331%204.69522%2015.692%205.60681%2016.9403%206.80583L15.4703%208.27586C14.5751%207.43819%2013.3597%206.78119%2011.7008%206.78119%208.62108%206.78119%206.21482%209.26135%206.21482%2012.341%206.21482%2015.4207%208.62108%2017.9009%2011.7008%2017.9009%2013.6964%2017.9009%2014.8297%2017.0961%2015.5606%2016.3734%2016.1601%2015.7738%2016.5461%2014.9197%2016.6939%2013.7454h-4.9931V11.6512h7.0298C18.8045%2012.0207%2018.8456%2012.4724%2018.8456%2012.957%2018.8456%2014.5255%2018.4186%2016.4637%2017.0389%2017.8434%2015.692%2019.2395%2013.9838%2019.9868%2011.7008%2019.9868z%22%20fill%3D%22%234285F4%22/%3E%3Cpath%20d%3D%22M29.7192%2015.0594C29.7192%2017.8927%2027.5429%2019.9786%2024.8656%2019.9786%2022.1884%2019.9786%2020.0121%2017.8927%2020.0121%2015.0594%2020.0121%2012.2096%2022.1884%2010.1401%2024.8656%2010.1401%2027.5429%2010.1401%2029.7192%2012.2096%2029.7192%2015.0594zM27.5922%2015.0594C27.5922%2013.2855%2026.3274%2012.0782%2024.8656%2012.0782S22.1391%2013.2937%2022.1391%2015.0594C22.1391%2016.8086%2023.4038%2018.0405%2024.8656%2018.0405S27.5922%2016.8168%2027.5922%2015.0594z%22%20fill%3D%22%23E94235%22/%3E%3Cpath%20d%3D%22M40.5922%2015.0594C40.5922%2017.8927%2038.4159%2019.9786%2035.7387%2019.9786%2033.0696%2019.9786%2030.8851%2017.8927%2030.8851%2015.0594%2030.8851%2012.2096%2033.0614%2010.1401%2035.7387%2010.1401%2038.4159%2010.1401%2040.5922%2012.2096%2040.5922%2015.0594zM38.4734%2015.0594C38.4734%2013.2855%2037.2087%2012.0782%2035.7469%2012.0782%2034.2851%2012.0782%2033.0203%2013.2937%2033.0203%2015.0594%2033.0203%2016.8086%2034.2851%2018.0405%2035.7469%2018.0405%2037.2087%2018.0487%2038.4734%2016.8168%2038.4734%2015.0594z%22%20fill%3D%22%23FABB05%22/%3E%3Cpath%20d%3D%22M51.203%2010.4357v8.8366C51.203%2022.9105%2049.0595%2024.3969%2046.5219%2024.3969%2044.132%2024.3969%2042.7031%2022.7955%2042.161%2021.4897L44.0417%2020.7095C44.3784%2021.5143%2045.1997%2022.4588%2046.5219%2022.4588%2048.1479%2022.4588%2049.1499%2021.4487%2049.1499%2019.568V18.8617H49.0759C48.5914%2019.4612%2047.6552%2019.9786%2046.4808%2019.9786%2044.0171%2019.9786%2041.7668%2017.8352%2041.7668%2015.0758%2041.7668%2012.3%2044.0253%2010.1319%2046.4808%2010.1319%2047.6552%2010.1319%2048.5914%2010.6575%2049.0759%2011.2323H49.1499V10.4357H51.203zM49.2977%2015.084C49.2977%2013.3512%2048.1397%2012.0782%2046.6697%2012.0782%2045.175%2012.0782%2043.9267%2013.3429%2043.9267%2015.084%2043.9267%2016.8004%2045.175%2018.0487%2046.6697%2018.0487%2048.1397%2018.0487%2049.2977%2016.8004%2049.2977%2015.084z%22%20fill%3D%22%234285F4%22/%3E%3Cpath%20d%3D%22M54.9887%205.22083V19.6912H52.8288V5.220829999999999H54.9887z%22%20fill%3D%22%2334A853%22/%3E%3Cpath%20d%3D%22M63.4968%2016.6854L65.1722%2017.8023C64.6301%2018.6072%2063.3244%2019.9869%2061.0659%2019.9869%2058.2655%2019.9869%2056.2534%2017.827%2056.2534%2015.0676%2056.2534%2012.1439%2058.2901%2010.1483%2060.8278%2010.1483%2063.3818%2010.1483%2064.6301%2012.1768%2065.0408%2013.2773L65.2625%2013.8357%2058.6843%2016.5623C59.1853%2017.5478%2059.9737%2018.0569%2061.0741%2018.0569%2062.1746%2018.0569%2062.9384%2017.5067%2063.4968%2016.6854zM58.3312%2014.9115L62.7331%2013.0884C62.4867%2012.4724%2061.764%2012.0454%2060.9017%2012.0454%2059.8012%2012.0454%2058.2737%2013.0145%2058.3312%2014.9115z%22%20fill%3D%22%23E94235%22/%3E%3C/svg%3E"] {
    display: none; 
}

.gmnoprint {
    display: none;
}

.gm-style .gm-style-cc a, .gm-style .gm-style-cc button, .gm-style .gm-style-cc span {
    display: none;
}

.gm-style .gm-style-cc a, .gm-style .gm-style-cc button, .gm-style .gm-style-cc div {
    display: none;
}


@media screen and (max-width: 992px) {
    div#floating-panel {
        display: none;
    }
    .mobile-floating-panel-top{
        display: flex;
    }
    .mobile-floating-panel-bottom{
        display: block;
    }
    
}
@media screen and (max-width:767px) {
    
}
@media screen and (max-width: 576px) {
    .mobile-floating-panel-bottom .pro-main-section .profile-section .profile-details h4{
        font-size: 15px;
    }
    .mobile-floating-panel-bottom .address-details .address h4{
        font-size: 14px;
    }
    .mobile-floating-panel-bottom .address-details .address h4 span{
        font-size: 10px;
    }
    .mobile-floating-panel-bottom .address-details .address p{
        font-size: 12px;
    }
}
    </style>
    
</head>
<body>
    
    <div id="floating-panel" class=" box-shadow">
        <div class="form-group my-0">
            <input type="text" id="to" value="Rangpur" placeholder="Destination">
        </div>
        <div class="form-group my-0">
            <ul>
                <li class="<?=$driving_active;?>">
                    <a href="index.php?order_id=120000"><span class="iconify" data-icon="healthicons:basic-motorcycle"></span> Bike</a>
                </li>
                <li class="<?=$bicycle_active;?>">
                    <a href="index.php?order_id=120000&driving_mode=bicycle"><span class="iconify" data-icon="bi:bicycle"></span> Bicycle</a>
                </li>
                <li class="<?=$walking_active;?>">
                    <a href="index.php?order_id=120000&driving_mode=walking"><span class="iconify" data-icon="healthicons:exercise-walking"></span> Walking</a>
                </li>
            </ul>
        </div>
        <div class="border-bottom mx-auto" style="width: 95%;"></div>

        <div class="form-group d-block my-3">
            <div class="address_details">
                <p id="address_details_view"></p>
            </div>
            <div class="address_time">
                <p id="duration_view"></p>
                <span id="distance_view"></span>
            </div>
        </div>

        <div class="hidden-tab">
            <!-- <a href=""><span class="iconify" data-icon="ep:arrow-right-bold"></span></a> -->
            <a onclick="hidden_tab()" id="hidden_tab_id"><span class="iconify" data-icon="ic:round-keyboard-arrow-left"></span></a>
        </div>
        <!-- <div class="form-group">
            <select id="mode" class="form-control">
                <option value="DRIVING">Driving</option>
                <option value="WALKING">Walking</option>
                <option value="BICYCLING">Bicycling</option>
                <option value="TRANSIT">Transit</option>
            </select>
        </div> -->
        <!-- important form  -->
        <input type="hidden" id="from">
    </div>

    <div class="mobile-floating-panel-top ">
        <div class="back">
            <a href="" class="box-shadow"><span class="iconify" data-icon="ep:arrow-left-bold"></span></a>
        </div>
        <div class="center text-center">
            <h4>Order Delivery</h4>
        </div>
        <div class="right">
            <p class="box-shadow"><span class="iconify" data-icon="bx:current-location"></span></p>
        </div>
    </div>
    <div id="mobile-floating-panel" class="mobile-floating-panel-bottom box-shadow ">
        <div onclick="m_hidden_tab()" class="m-hidden_btn-section">
            <!-- <span onclick="m_hidden_tab()">*****</span> -->
            <div class="m-tab"></div>
        </div>
        <div class="pro-main-section">
            <div class="profile-section">
                <div class="profile-img">
                    <img class="img-fluid" src="https://www.evna.care/uploads/profile_208568117user_id_195.jpg" alt="">
                </div>
                <div class="profile-details">
                    <h4>Zillur Rahman</h4>
                    <p>Coustomer</p>
                </div>
            </div>
            <div class="contact-btn">
                <a href=""><span class="iconify" data-icon="heroicons:chat-bubble-left-right"></span></a>
                <a href="tel:01724343698"><span class="iconify" data-icon="fluent:call-12-regular"></span></a>
            </div>
        </div>
        <div class="address-details">
            <div class="location-icon">
                <span class="iconify" data-icon="akar-icons:location"></span>
            </div>
            <div class="address">
                <h4>Duration <span id="duration_view2"></span></h4>
                <p>Dhaka Bangladesh</p>
            </div>
        </div>
        <div class="order-action">
            <a href="" class="btn form-control">Delivery</a>
        </div>
    </div>


    <div id="map"></div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/3/3.0.0/iconify.min.js"></script>
    
    <!-- <script src="main.js"></script> -->

    <script>
        
        function hidden_tab(){
            var element = document.getElementById("floating-panel");
            element.classList.toggle("deactive");
        }
    </script>
    <script>
        function m_hidden_tab(){
            var element = document.getElementById("mobile-floating-panel");
            element.classList.toggle("m-deactive");
        }
    </script>

    <script>
        // function getCoordinates(){
        // fetch("https://maps.googleapis.com/maps/api/geocode/json?latlng="+address+'&key=AIzaSyCg00mHPgPKiKuODJTQaYhet6MDIivqUBk')
        //     .then(response => response.json())
        //     .then(data => {
        //         const latitude = data.results[0].geometry.location.lat;
        //         const longitude = data.results[0].geometry.location.lng;
        //         console.log({latitude, longitude})
        //     })
        // }




        // navigator.geolocation.getCurrentPosition(getCoordinates, initMap);
        // function getCoordinates(position){
        //     var lat = position.coords.latitude;
        //     var lon = position.coords.longitude;

        //     fetch("https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+','+lon+'&key=AIzaSyCg00mHPgPKiKuODJTQaYhet6MDIivqUBk')
        //     .then(response => response.json())
        //     .then(data => {
        //         var address = data.results[0].formatted_address;
        //         document.getElementById("from").value = address;
        //         // console.log(data);
        //     })
        // }

        navigator.geolocation.getCurrentPosition(initMap);
        function initMap(position){
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            // document.getElementById("from").value = '{ lat: '+lat + ', lng: ' + lon+ ' }';

            const directionsRenderer = new google.maps.DirectionsRenderer();
            const directionsService = new google.maps.DirectionsService(); 

            const map = new google.maps.Map(document.getElementById("map"),
            {
                zoom: 14,
                center: { lat: lat, lng: lon },
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: true,
                fullscreenControl: false,
                
            });

            const markerIcon = {
                path: 'M107 133 c-25 -59 -44 -110 -41 -112 3 -3 25 6 49 19 l45 25 45 -25 c24 -13 46 -22 49 -19 7 6 -84 219 -94 219 -4 0 -28 -48 -53 -107z',
                fillColor: "#0364FF",
                fillOpacity: 1,
                strokeWeight: 0,
                rotation: 180,
                scale: 0.10,
                scaledSize: 1,
                anchor: new google.maps.Point(15, 30),
                
            };
            
            new google.maps.Marker({
                position: map.getCenter(),
                icon: markerIcon,
                map: map,
                offset: "100%",
            });


            directionsRenderer.setMap(map);

            // calculateAndDisplayRoute(directionsService, directionsRenderer);
            // document.getElementById("mode").addEventListener("change",() => {
            //     calculateAndDisplayRoute(directionsService,directionsRenderer);
            // });
            calculateAndDisplayRoute(directionsService, directionsRenderer);
            document.getElementById("to").addEventListener("change",() => {
                calculateAndDisplayRoute(directionsService,directionsRenderer);
            });
        }
        

        
        function calculateAndDisplayRoute(directionsService, directionsRenderer){
            // const selectedMode = document.getElementById("mode").value;
            const selectedMode = '<?=$driving_mode;?>';
            directionsService
            .route({
                
                // ******************* here direction start location input  *************
                origin: { lat: 23.754815359966834, lng: 90.38428091878507 }, // Haight.
                // destination: { lat: 37.768, lng: -122.511 }, 
                // travelMode: google.maps.TravelMode[selectedMode],

                // origin: document.getElementById("from").value, // Haight.
              
              
              // ******************* here direction End location input  *************
                destination: document.getElementById("to").value, 
                travelMode: google.maps.TravelMode[selectedMode],
            })
            .then((response) => {
                directionsRenderer.setDirections(response);
                var distance = response.routes[0].legs[0].distance.text;
                var duration = response.routes[0].legs[0].duration.text;
                var start_address = response.routes[0].legs[0].start_address;
                var end_address = response.routes[0].legs[0].end_address;

                document.getElementById("address_details_view").innerHTML = start_address +'<b> To </b>'+ end_address;
                document.getElementById("duration_view").innerHTML = duration;
                document.getElementById("duration_view2").innerHTML = duration;
                document.getElementById("distance_view").innerHTML = distance;

                console.log(distance);
                console.log(duration);
                console.log(start_address);
                console.log(end_address);
            })
            .catch((e) => console.log("Directions request failed due to " + status));
        }
    </script>

    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCg00mHPgPKiKuODJTQaYhet6MDIivqUBk&callback=initMap&v=weekly" defer ></script>
</body>
</html>
