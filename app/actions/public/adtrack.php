<?php

//---CONFIG---------------------------------------------

$appID = FACEBOOK_APP_ID;
$appSecret = FACEBOOK_APP_SECRET;
$accessToken = "write_your_access_token_here";

use FacebookAds\Api;

Api::init($appID,$appSecret,$accessToken);

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

$accountId = 'act_00000000';
$account = new AdAccount( $accountId );

//---CAMPAIGNS---------------------------------------------

$campaigns = $account->getAdCampaigns(array(
    AdCampaignFields::ID,
    AdCampaignFields::NAME,
),array());


$campaignId = $campaigns[0]->{AdCampaignFields::ID};
$campaign = new AdCampaign($campaignId);


//----ADSETS---------------------------------------------

$adsets = $campaign->getAdSets( array(
    AdSetFields::ID,
    AdSetFields::NAME,
    AdSetFields::START_TIME,
    AdSetFields::END_TIME,
) );


$adsetId = $adsets[0]->{AdSetFields::ID};
$adset = new AdSet($adsetId);

//---ADGROUPS---------------------------------------------

$adgroups = $adset->getAdGroups(array(
    AdGroupFields::ID,
    AdGroupFields::NAME,
), array());

$adgroupId = 'write_adgroup_id_here';
//$adgroupId = $adgroups[0]->{AdGroupFields::ID};
$adgroup = new AdGroup($adgroupId);

$adgroup->read(array(
    AdGroupFields::ID,
    AdGroupFields::NAME,
));

//---INSIGHTS---------------------------------------------

$insights = $adgroup->getInsights(array(),array());

//foreach ($insights as $stats) {
//
//    $stats->getFields(array(
//        InsightsFields::FREQUENCY,
//    ));
//
//    echo " ad name : " . $adgroup->{AdGroupFields::NAME} . PHP_EOL . "<br />";
//    echo " reach : " . $stats->{InsightsFields::REACH} . PHP_EOL . "<br />";
//    echo " impressions : " . $stats->{InsightsFields::IMPRESSIONS} . PHP_EOL . "<br />";
//    echo " clicks : " . $stats->{InsightsFields::CLICKS} . PHP_EOL . "<br />";
//    echo " unique clicks : " . $stats->{InsightsFields::UNIQUE_CLICKS} . PHP_EOL . "<br />";
//    echo " frequency: " . $stats->{InsightsFields::FREQUENCY} . PHP_EOL . "<br />";
//}
//
?>
