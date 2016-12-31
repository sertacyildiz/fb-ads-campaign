<?php

include __DIR__ . "/processor.php";

if(isset($_POST['adsetId'] )){
    $adsetId = $_POST['adsetId'] ;
}else{$adsetId = "6023035079714";}

$sid = "";
$startDate = date("Y-m-d", strtotime('-3 month'));
$endDate = date('Y-m-d');
//$startDate = "2015-07-10";
//$endDate = "2015-08-10";

if (isset($_GET['sid'])) {
    $sid = sanitize_string($_GET['sid']);
}
if (isset($_GET['start'])) {
    $startDate = sanitize_string($_GET['start']);
}
if (isset($_GET['end'])) {
    $endDate = sanitize_string($_GET['end']);
}

?>

<head>
    <link rel="stylesheet" type="text/css" href="/css/public/adtrack.css">
    <script>
        function getAds() {
            var setId = document.getElementById("adSetId").value;
            var start = document.getElementById("startTime").value;
            var end = document.getElementById("endTime").value;
            var url;

            if(start != null && start != '' && end != null && end != ''){
                url = "?sid=" + setId + "&start=" + start + "&end="+ end
            }else if(setId != null ){
                url = "?sid=" + setId
            }

            window.location.href = url;

        }
    </script>
</head>
<body>

<section id="main">
    <?php ?>
    <div id="container">
        <div id="logo">
            <img class="logoImage leftI" src="/images/markakod_logo.png"/>
            <img class="logoImage rightI" src="/images/flo-logo.png"/>
        </div>

        <div id="results">
            <div id="filter">
                <form method="post" action="index" class="bootstrap-frm">
                    <label>Reklam Seti: </label>
                    <select id="adSetId" name="adSetId">
                        <?php processor::getAdSets($sid); ?>
                    </select>
                    <label>Başlangıç: </label><input id="startTime" name="startTime" type="date" value="<?php if (isset($_GET['start'])){echo $_GET['start'];}else{echo $startDate;} ?>" />
                    <label>Bitiş: </label><input id="endTime" name="endTime" type="date" value="<?php if (isset($_GET['end'])){echo $_GET['end'];}else{echo $endDate;} ?>" />
                    <input id="submit" name="submit" type="button" onclick="getAds();" value="Getir" />
                </form>
            </div>

            <table>

                <tr>
                    <th>Set Name</th>
                    <th>Ad Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reach</th>
                    <th>Impressions</th>
                    <th>Click</th>
                    <th>Unique Click</th>
                    <th>Frequency</th>
                    <th>Page Like</th>
                    <th>Page Engagements</th>
                    <th>Post Likes</th>
                    <th>Post Engagements</th>
                </tr>
                <tr>
                    <?php
                    processor::getAdInsights($sid,$startDate,$endDate);
                    ?>
                </tr>
            </table>

        </div>
    </div>

</section>

</body>