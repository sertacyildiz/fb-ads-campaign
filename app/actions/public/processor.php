<?php

$appID = FACEBOOK_APP_ID;
$appSecret = FACEBOOK_APP_SECRET;
$accessToken = ACCESS_TOKEN;

use FacebookAds\Api;

Api::init($appID, $appSecret, $accessToken);

use FacebookAds\Object\Campaign;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\AdGroupFields;
use FacebookAds\Object\Fields\InsightsFields;

//$accountId = 'act_22449792';
//$account = new AdAccount($accountId);


class processor
{
    public static function getAdSets($asId)
    {
        try{
            $campaignId = CAMPAIGN_ID;
            $campaign = new Campaign($campaignId);


            $adsets = $campaign->getAdSets(array(
                AdSetFields::ID,
                AdSetFields::NAME,
            ), array(
                'sort' => 'reach_descending',
//                'sort_by' => 'id',
//                'sort_dir' => 'desc'
            ));



            foreach ($adsets as $adset) {

                $adsetId = substr($asId, 19, 13);
                $current = $adsetId == $adset->{AdSetFields::ID} ? "selected" : "";

                $mt = str_replace("0.", "", microtime());
                $mtime = str_replace(" ", "9", $mt);
                $time = time();

                echo '
                    <option value="'.$mtime . $adset->{AdSetFields::ID} . $time .'" '.$current.'  >' . $adset->{AdSetFields::NAME} . '</option>
                ';

            }
        }catch (\FacebookAds\Exception\Exception $e){

            echo "<div class='exception'> Lütfen 10 dakika sonra tekrar deneyin! Gösterim limitiniz doldu. </div>";
            errorlog($e->getMessage());

        }

    }

    public static function getAdInsights($asId, $since, $until)
    {

        $adsetId = substr($asId, 19, 13);

        try{
            if($asId != ""){

                $adset = new AdSet($adsetId);
                $adset->read(array(
                    AdSetFields::ID,
                    AdSetFields::NAME,
                ), array());



                    $insights = $adset->getInsights(array(), array(

                        'time_range' => array(
                            'since' => $since,
                            'until' => $until,
                        ),
                    ));

                    echo "<pre>";
                    print_r($insights->co);
                    echo "</pre>";

                    foreach ($insights as $keys => $stats) {
                        $stats->getFields(array(
                            InsightsFields::FREQUENCY,
                            InsightsFields::ACTIONS,
                        ));

                        echo '
                    
                        <td>' . $adset->{AdSetFields::NAME} . '</td>
                        <td>' . $stats->{InsightsFields::REACH} . '</td>
                        <td>' . $stats->{InsightsFields::IMPRESSIONS} . '</td>
                        <td>' . $stats->{InsightsFields::WEBSITE_CLICKS} . '</td>
                        <td>' . $stats->{InsightsFields::UNIQUE_CLICKS} . '</td>
                        <td>' . $stats->{InsightsFields::FREQUENCY} . '</td>';

                        /** Check what "unique_actions" contains  **/
//                        var_dump($stats->unique_actions);

                        foreach($stats->unique_actions as $st){
                            if($st["action_type"] == "like"){
                                $likeAction = empty($st["value"]) ? $st["value"] : " - ";
                                echo   '<td>' . $likeAction  . '</td>';
                            }
                            // remove this if isset(like)
                            else{
                                echo   '<td> - </td>';
                                break;
                            }
                        }



                        foreach($stats->unique_actions as $st){
                            if($st["action_type"] == "page_engagement"){
                                $pageengAction = $st["value"];
                                echo   '<td>' . $pageengAction . '</td>';
                            }

                        }

                        foreach($stats->unique_actions as $st){
                            if($st["action_type"] == "post_like"){
                                $postlikeAction = $st["value"];
                                echo   '<td>' . $postlikeAction . '</td>';
                            }

                        }

                        foreach($stats->unique_actions as $st){
                            if($st["action_type"] == "post_engagement"){
                                $postengAction = $st["value"];
                                echo   '<td>' . $postengAction . '</td>';
                            }

                        }




                    }

//                }
            }
        }catch (\FacebookAds\Exception\Exception $e){

            echo "<div class='exception'> Gösterim limitiniz doldu! Lütfen 10 dakika sonra tekrar deneyin...  </div>";
            errorlog($e->getMessage());
        }


    }
}