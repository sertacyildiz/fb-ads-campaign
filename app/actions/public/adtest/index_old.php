<?php


$accountId = 'act_22449792';
$account = new AdAccount($accountId);

//---CAMPAIGNS---------------------------------------------

//$campaigns = $account->getAdCampaigns(array(
//    AdCampaignFields::ID,
//    AdCampaignFields::NAME,
//), array());


$campaignId = "6019949106114";
//$campaignId = $campaigns[0]->{AdCampaignFields::ID};
$campaign = new AdCampaign($campaignId);


//----ADSETS---------------------------------------------

$adsets = $campaign->getAdSets(array(
    AdSetFields::ID,
    AdSetFields::NAME,
),array(
    //    'time_range' => array(
    //        'since' => '2015-06-01',
    //        'until' => '2015-10-20',
    //    ),
));


foreach($adsets as $adset){

    $adgroups = $adset->getAdGroups(array(
        AdGroupFields::NAME,
    ), array());

    foreach ($adgroups as $adgroup){


//                            if(isset($_POST['start_time'])){ $start_time = $_POST['start_time'];}
//                            //$start_time = "01-07-2015";
//                            $since = date("Y-m-d", strtotime($start_time));

//                            if(isset($_POST['end_time'])){ $end_time = $_POST['end_time'];}
//                            //$end_time = "20-10-2015";
//                            $until = date("Y-m-d", strtotime($end_time));


        $insights = $adgroup->getInsights(array(), array(

//                                'time_range' => array(
//                                    'since' => $since,
//                                    'until' => $until,
//                                ),
        ));

        foreach ($insights as $stats) {

            $stats->getFields(array(
                InsightsFields::FREQUENCY,
                //InsightsFields::ACTIONS,
            ));

            //                        echo "<pre>";
            //                        print_r($stats);
            //                        echo "</pre>";

            //                        foreach ($stats->{InsightsFields::ACTIONS} as $action) {
            //                            $like = $action["action_type"] == 'like' ? $action["value"] : "-";
            //                            $page_engagement = $action["action_type"] == 'page_engagement' ? $action["value"] : "-";
            //                            $post_like = $action["action_type"] == 'post_like' ? $action["value"] : "-";
            //                            $post_engagement = $action["action_type"] == 'post_engagement' ? $action["value"] : "-";
            //                        }

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
                                <td>' . $stats->{InsightsFields::FREQUENCY} . '</td>
                            </tr>';
        }
    }
}