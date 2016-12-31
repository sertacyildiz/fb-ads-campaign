<?php
$appID = FACEBOOK_APP_ID;
$appSecret = FACEBOOK_APP_SECRET;
$accessToken = ACCESS_TOKEN;

//$accessToken = "CAAUygNNkpFYBAPBvRRuTzRvjQR49hYHFhL7LqH1EGCrIfZBTJXeBUgodB1VAx4PeEi6ySvAam6xkbONzFbwOBor2TBSkKCL3ogcE3tcqUSzQpuJ5eZC9PJtLyqt7p49wxVKpgwyn3KWBUulPw53yyFeFb9POhTLem470Wd2hHjC4cvFNUReKOjZCcOrPVoZD";

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

$accountId = 'act_22449792';
//$accountId = 'act_266680438';
$account = new AdAccount( $accountId );


//////// CREATIVES

$adcres = $account->getAdCreatives( array(
    AdCreativeFields::ID,
    AdCreativeFields::NAME,
) );

foreach ( $adcres as $adcre ) {
    echo "Creative ID : " . $adcre->{AdSetFields::ID} . PHP_EOL . "<br>";
    echo "Creative NAME : " . $adcre->{AdSetFields::NAME} . PHP_EOL . "<br>";
}
echo "-----------------------------------------------------------------<br /><br />";


//////// ADSETS

$adsets = $account->getAdSets( array(
    AdSetFields::ID,
    AdSetFields::NAME,
    AdSetFields::CAMPAIGN_STATUS,
) );

foreach ( $adsets as $adset ) {
    echo "ID : " . $adset->{AdSetFields::ID} . PHP_EOL . "<br>";
    echo "NAME : " . $adset->{AdSetFields::NAME} . PHP_EOL . "<br>";
    echo "CAMPAIGN_STATUS : " . $adset->{AdSetFields::CAMPAIGN_STATUS} . PHP_EOL . "<br><br />";
}

echo "-----------------------------------------------------------------<br /><br />";

//////// CAMPAIGNS

$campaigns = $account->getAdCampaigns(array(
    AdCampaignFields::ID,
    AdCampaignFields::NAME,
    AdCampaignFields::STATUS,
));

foreach ( $campaigns as $campaign ) {
    echo "ID : " . $campaign->{AdCampaignFields::ID} . PHP_EOL . "<br>";
    echo "NAME : " . $campaign->{AdCampaignFields::NAME} . PHP_EOL . "<br>";
}

echo "-----------------------------------------------------------------<br /><br />";

//////// ADGROUPS

$params = array(
    AdGroupFields::ADGROUP_STATUS => array(
        AdGroup::STATUS_ACTIVE,
        AdGroup::STATUS_PAUSED,
        AdGroup::STATUS_CAMPAIGN_PAUSED,
        AdGroup::STATUS_CAMPAIGN_GROUP_PAUSED,
        AdGroup::STATUS_PENDING_REVIEW,
        AdGroup::STATUS_DISAPPROVED,
        AdGroup::STATUS_PREAPPROVED,
        AdGroup::STATUS_PENDING_BILLING_INFO,
        AdGroup::STATUS_ARCHIVED,
    ),
);

$myadset = new AdSet('6030854330314');
$adgroups = $myadset->getAdGroups(array(
    AdGroupFields::ID,
    AdGroupFields::NAME,
), $params);

// Outputs names of Ad Groups.
foreach ($adgroups as $adgroup) {
    echo "ID : " . $adgroup->{AdGroupFields::ID}.PHP_EOL . "<br>";
    echo "NAME : " . $adgroup->{AdGroupFields::NAME}.PHP_EOL . "<br><br>";
}

$adGroupId = '6030854331914';
$adgroup = new AdGroup( $adGroupId );

$adgroup->read(array(
    AdGroupFields::NAME,
    AdGroupFields::TRACKING_SPECS,
));


echo "<pre>";
print_r($adgroup->{AdGroupFields::TRACKING_SPECS});
echo "</pre>";


//////// INSIGHTS


$stats = $adgroup->getInsights(array(), array(
    //'status' => 'Active',
));

foreach ($stats as $stat) {
    $stat->getFields(array(
        InsightsFields::FREQUENCY,
    ));

    echo "<tr>";
    echo " name: " . $adgroup->{AdGroupFields::NAME} . PHP_EOL . "<br />";
    echo " reach: " . $stat->reach . PHP_EOL . "<br />";
    echo " impressions: " . $stat->impressions . PHP_EOL . "<br />";
    echo " clicks: " . $stat->clicks . PHP_EOL . "<br />";
    echo " unique_clicks: " . $stat->unique_clicks . PHP_EOL . "<br />";
    echo " FREQUENCY: " . $stat->{InsightsFields::FREQUENCY} . PHP_EOL . "<br />";

    echo "</tr><br />";

}


echo "<br />-----------------------------------------------------------------<br /><br />";

//////// CREATIVES

$adgroup->read(array(AdGroupFields::NAME));

$adcreatives = $adgroup->getAdCreatives(array(AdCreativeFields::NAME));

foreach($adcreatives as $adcs){
    echo "name : " . $adcs->{AdCreativeFields::NAME};
}