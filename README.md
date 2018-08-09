SdkBonusApi - sdk-class for loyalty_api_v106 from funidst.org + RABBIT-queue

1.Installation.

1.1. composer.json file:

{
    "require": {
        "php":">=5.3.0",
        "bonusapi-rabbit/sdkapi-rabbit": "dev-master"
    },
    "prefer-stable": true,
    "minimum-stability": "dev"

}

1.2. composer install

2.Basic usage.

//...

/**
require_once 'vendor/autoload.php';

use SdkBonusApi\SdkBonusApi;

$bonusapi = new SdkBonusApi();

$arr['numberapi'] = '1'; 
$arr['postparamstring'] = 'TID=777/IDUser=55'; 

$bonusapi->requestApi($arr);
**/