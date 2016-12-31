<?php

$appID = FACEBOOK_APP_ID;
$appSecret = FACEBOOK_APP_SECRET;
$accessToken = ACCESS_TOKEN;

use FacebookAds\Api;

Api::init($appID, $appSecret, $accessToken);

use FacebookAds\Object\AdUser;
use FacebookAds\Object\AdCampaign;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdGroup;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Fields\AdCampaignFields;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\AdGroupFields;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Values\InsightsPresets;
use FacebookAds\Object\Fields\InsightsFields;

//$accountId = 'act_22449792';
//$account = new AdAccount($accountId);


class processor
{
    public static function getAdSets($sId)
    {

        $campaignId = CAMPAIGN_ID;
        $campaign = new AdCampaign($campaignId);


        $adsets = $campaign->getAdSets(array(
            AdSetFields::ID,
            AdSetFields::NAME,
        ), array());



        foreach ($adsets as $adset) {
            $current = $sId == $adset->{AdSetFields::ID} ? "selected" : "";

            echo '
                <option value="' . $adset->{AdSetFields::ID} . '" '.$current.'  >' . $adset->{AdSetFields::NAME} . '</option>
            ';

        }

    }

    public static function getAdInsights($adsetId, $since, $until)
    {

        $adset = new AdSet($adsetId);
        $adset->read(array(
            AdSetFields::ID,
            AdSetFields::NAME,
        ), array());

        $adgroups = $adset->getAdGroups(array(
            AdGroupFields::ID,
            AdGroupFields::NAME,
        ), array());

        foreach ($adgroups as $adgroup) {

            $adgroup->read(array(
                AdGroupFields::ID,
                AdGroupFields::NAME,
            ),array());

            $insights = $adgroup->getInsights(array(), array(

                    'time_range' => array(
                        'since' => $since,
                        'until' => $until,
                    ),
            ));


            foreach ($insights as $keys => $stats) {

                $stats->getFields(array(
                    InsightsFields::FREQUENCY,
                    InsightsFields::ACTIONS,
                ));

                echo '
                    <tr>
                        <td>' . $adset->{AdSetFields::NAME} . '</td>
                        <td>' . $adgroup->{AdGroupFields::NAME} . '</td>
                        <td>' . $stats->{InsightsFields::DATE_START} . '</td>
                        <td>' . $stats->{InsightsFields::DATE_STOP} . '</td>
                        <td>' . $stats->{InsightsFields::REACH} . '</td>
                        <td>' . $stats->{InsightsFields::IMPRESSIONS} . '</td>
                        <td>' . $stats->{InsightsFields::CLICKS} . '</td>
                        <td>' . $stats->{InsightsFields::UNIQUE_CLICKS} . '</td>
                        <td>' . $stats->{InsightsFields::FREQUENCY} . '</td>';

                    foreach($stats->actions as $st){
                        if($st["action_type"] == "like"){
                            $likeAction = $st["value"];
                         echo   '<td>' . $likeAction . '</td>';
                        }

                    }

                    foreach($stats->actions as $st){
                        if($st["action_type"] == "page_engagement"){
                            $pageengAction = $st["value"];
                            echo   '<td>' . $pageengAction . '</td>';
                        }

                    }

                    foreach($stats->actions as $st){
                        if($st["action_type"] == "post_like"){
                            $postlikeAction = $st["value"];
                            echo   '<td>' . $postlikeAction . '</td>';
                        }

                    }

                    foreach($stats->actions as $st){
                        if($st["action_type"] == "post_engagement"){
                            $postengAction = $st["value"];
                            echo   '<td>' . $postengAction . '</td>';
                        }

                    }

                echo '</tr>';


//                $i = 0;
//                while(isset($stats->actions[$i])){
//                    if($stats->actions[$i]["action_type"] == "like"){
//                        $like = $stats->actions[$i]["value"];
//                        if(isset($like)){
//                            $likeAction = $like;
//                        }else{
//                            $likeAction = "-";
//                        }
//
//                        echo "like".$likeAction."<br><br>";
//                    }
//
//                    if($stats->actions[$i]["action_type"] == "post_like"){
//                        $postlike =  $stats->actions[$i]["value"];
//                        if(isset($postlike)){
//                            $postlikeAction = $postlike;
//                        }else{
//                            $postlikeAction = "-";
//                        }
//                        echo "post_like".$postlikeAction."<br><br>";
//                    }
//
//                    if($stats->actions[$i]["action_type"] == "page_engagements"){
//                        $pageeng =  $stats->actions[$i]["value"];
//                        if(isset($pageeng)){
//                            $pageengAction = $pageeng;
//                        }else{
//                            $pageengAction = "-";
//                        }
//                        echo "page_engagements".$pageengAction."<br><br>";
//                    }
//
//                    if($stats->actions[$i]["action_type"] == "post_engagements"){
//                        $posteng =  $stats->actions[$i]["value"];
//                        if(isset($posteng)){
//                            $postengAction = $posteng;
//                        }else{
//                            $postengAction = "-";
//                        }
//                        echo "post_engagements".$postengAction."<br><br>";
//                    }
//
//                    $i++;
//                }


//                echo '
//                    <tr>
//                        <td>' . $adset->{AdSetFields::NAME} . '</td>
//                        <td>' . $adgroup->{AdGroupFields::NAME} . '</td>
//                        <td>' . $stats->{InsightsFields::DATE_START} . '</td>
//                        <td>' . $stats->{InsightsFields::DATE_STOP} . '</td>
//                        <td>' . $stats->{InsightsFields::REACH} . '</td>
//                        <td>' . $stats->{InsightsFields::IMPRESSIONS} . '</td>
//                        <td>' . $stats->{InsightsFields::CLICKS} . '</td>
//                        <td>' . $stats->{InsightsFields::UNIQUE_CLICKS} . '</td>
//                        <td>' . $stats->{InsightsFields::FREQUENCY} . '</td>
//                        <td>' . $likeAction . '</td>
//                        <td>' . $pageengAction . '</td>
//                        <td>' . $postlikeAction . '</td>
//                        <td>' . $postengAction . '</td>
//                    </tr>';

            }

            $statsFields = array(
                'actions',
            );

            $params = array(
                'date_preset' => InsightsPresets::TODAY,
            );

            $facebookPageEngagement = "";
            $statsss = $adgroup->getInsights($statsFields, array());

//            foreach($statsss as $keyStats => $responseStats){
//                $responseStatsArray = $responseStats->actions;
//                $facebookPageEngagement = $responseStatsArray['comment'];
//
//                echo "-->".$facebookPageEngagement;
//            }
        }




    }
}