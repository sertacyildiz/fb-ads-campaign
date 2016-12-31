<?php

$appID = FACEBOOK_APP_ID;
$appSecret = FACEBOOK_APP_SECRET;
$accessToken = "CAAUygNNkpFYBAO6HeJ73XLQNeINWVnD1HZBLHbgpZA8id7bmChugtbxpdHw9jEwPKfDe344YZBdMCdk55HqZCGHsuCT39ZBOi0915QloZCKSNNXqoZCYyYUJb3zxv9eNEuSZBvV9F2Fus1ZB8SZA6F2AmrfNOQTZCaFhorranzs78I9CduV9MCYabe6yF03m9xyFxwZD";

use FacebookAds\Api;

Api::init($appID, $appSecret, $accessToken);

use FacebookAds\Object\AdCampaign;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\AdGroupFields;
use FacebookAds\Object\Fields\InsightsFields;

//$accountId = 'act_22449792';
//$account = new AdAccount($accountId);


class processor
{
    public static function getAdSets($sId)
    {
        try{
            $campaignId = "6019949106114";
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
        }catch (\FacebookAds\Exception\Exception $e){
            echo "Lütfen 5 dakika sonra tekrar deneyin! Hata:".$e->getMessage();

        }

    }

    public static function getAdInsights($adsetId, $since, $until)
    {


        try{
            if($adsetId != ""){

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



                    }

                }
            }
        }catch (\FacebookAds\Exception\Exception $e){
            echo "Lütfen 5 dakika sonra tekrar deneyin! Hata:".$e->getMessage();

        }


    }
}