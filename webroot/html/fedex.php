<?php
//phpinfo();
error_reporting(E_ALL);
ini_set('display_errors', '1');
 
// For Generating Access Token
$url = 'https://apis-sandbox.fedex.com/oauth/token';
$body = 'grant_type=client_credentials&client_id=l764bcb84bd42f4319a5c390efcdddeeeb&client_secret=8c0221b401624b9bb5b3ad5e67365e1b';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_POST, 1); 
$result = curl_exec($ch);
curl_close ($ch);
print $result;
exit; 
 
// For Track API  

$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJDWFMiXSwiUGF5bG9hZCI6eyJjbGllbnRJZGVudGl0eSI6eyJjbGllbnRLZXkiOiJsNzY0YmNiODRiZDQyZjQzMTlhNWMzOTBlZmNkZGRlZWViIn0sImF1dGhlbnRpY2F0aW9uUmVhbG0iOiJDTUFDIiwiYWRkaXRpb25hbElkZW50aXR5Ijp7InRpbWVTdGFtcCI6IjA5LUp1bi0yMDIzIDA1OjI3OjExIEVTVCIsImdyYW50X3R5cGUiOiJjbGllbnRfY3JlZGVudGlhbHMiLCJhcGltb2RlIjoiU2FuZGJveCIsImN4c0lzcyI6Imh0dHBzOi8vY3hzYXV0aHNlcnZlci1zdGFnaW5nLmFwcC5wYWFzLmZlZGV4LmNvbS90b2tlbi9vYXV0aDIifSwicGVyc29uYVR5cGUiOiJEaXJlY3RJbnRlZ3JhdG9yX0IyQiJ9LCJleHAiOjE2ODYzMTAwMzEsImp0aSI6ImFmZWNjNDliLWJmMjMtNDUxMy04MTVmLWRmMTcxMjJmNjNiNCJ9.JkMy_qmnhT-mQEmSZFOJOERy9Wr6k9LDboWShlLfifoK381_O4KnZ2Ug6iFSJbAggRbqhRlUEa8DY0L6Fd5vj1U1mt42GP0pVYZzm4Meyp9nVqo06WAXQ6JyxYk5GZDyW56CHG3pdsNJgWhnipT6dKvigUHDHSl8NEFbeiSopGrkiVG0A3xC5LyK0l33tjMaM2CtCDh-jhywR4ErkanP4WPnEKXexZd_rqOZVT9NPreFzKCf4Ggf25rlH1sTRdlxBkIbjpgDLFfqI129vPvV5uAFREgUTXbyTKbhVZ5uPNl_3FAMBZkuADr04W4-i95epKdtyZoQGAMZX0opYyuotEknlC1BWtsveJxMcJVjbONfpN7vNcihF8ZMNbxq5Use-uj92G8d8lsy0HrG_7iW4unlDkmZUj5YEkNgBzdxaL2QlRNYV9iciXHVtDsSyfhTVSYmeaoqjYK_EnefjpewYHHMeMihlB2eEOVEHqOlSeJHrUJ02zj-BZt8xvRLMHOBl-0PAiE4lZTZRbMxG_erAgcUpsev0-X0D-gmkfXgy_PLGebLM_Iy6YxS9X8nc2WbiRymv3bSOd7NjsZvsExSY9rdY2WMVnpaxD6JYctaTuNao5GZhV9pQ_4A8OHVWfi5xX_coV-mV4E4oN7aMtHTY7eSf5aaI293Yh01E70BLPc';
  
$url = 'https://apis-sandbox.fedex.com/track/v1/trackingnumbers';
$body = array(
  "trackingInfo"=> [
    array(
      "trackingNumberInfo"=> array(
        "trackingNumber"=> "02394653001023698293"
      )
    )
  ],
  "includeDetailedScans"=> true
);
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer $token","X-locale: en_US"));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_POST, 1); 
$result = curl_exec($ch);
curl_close ($ch);
echo "<pre>";
print_r($result);


exit;

// For Ship API Create Tag

$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJDWFMiXSwiUGF5bG9hZCI6eyJjbGllbnRJZGVudGl0eSI6eyJjbGllbnRLZXkiOiJsNzY0YmNiODRiZDQyZjQzMTlhNWMzOTBlZmNkZGRlZWViIn0sImF1dGhlbnRpY2F0aW9uUmVhbG0iOiJDTUFDIiwiYWRkaXRpb25hbElkZW50aXR5Ijp7InRpbWVTdGFtcCI6IjE5LUphbi0yMDIzIDAzOjU0OjQzIEVTVCIsImdyYW50X3R5cGUiOiJjbGllbnRfY3JlZGVudGlhbHMiLCJhcGltb2RlIjoiU2FuZGJveCIsImN4c0lzcyI6Imh0dHBzOi8vY3hzYXV0aHNlcnZlci1zdGFnaW5nLmFwcC5wYWFzLmZlZGV4LmNvbS90b2tlbi9vYXV0aDIifSwicGVyc29uYVR5cGUiOiJEaXJlY3RJbnRlZ3JhdG9yX0IyQiJ9LCJleHAiOjE2NzQxMjIwODMsImp0aSI6ImNjY2I4NWE4LWI1MTItNDljNS1iZWM0LTA3MjE4ZjcxNTJiNSJ9.cU77ZQXpt-zbX9D_5w7EX-6dv6hUIi11VOrMzt-gGhK4eZ8Xw7_BuKZEoA5uAab8_OeEGLhwT76wmpga4JyVD3Db_UgSYYEr0D1CBNVaWdc7lXlgXOzhp5JJrhL0MCLwqRCbnMaheh_pD3GEWkS1eENMYGVi-Qo0NV7wcj2YcbxCVx0DIBo6IBpkNHslJxl363wxGxq1qnLLKmCtkOhOCcigr-vch9KwmxdLDEungKbfEY0Da6K-_f3X83oAtrBAPTghghT-0mVTzUJKrujTsvoScl8LIdxhpE9_bqyHO5-MOmv2lmrbTS9QGaf6_rokz5RyEsR0au37BcxWEHKdTSzqmXPMJnKA-i6gM-eOH-bkmWyIZsqsKQ7npcA-3nUlr6ibjMFKMUVmA-_GH-tAu0cWB980OEqvz9PIq8apQt4c7pfMZySYeq0jujJUq5BksvQgxERnJ1R5yWgHgxfNSLDAN_gg2P9lV_r1pPcJT0VuVy4vlVka5mC2wl2s3Xy5K_T85VwSlGzGtz1xqqav3M65-1jimTZ2fxRM1MjWBMKUVTlmU-6ZJh1abBGfS5IFteBMDrWj5lbEVD8KuSvZQ7VNgUoAoQZnhes6shqDNwGhsuWBmltfeo_gP-5VMQ1_iuZJUy1eiQgWqfpOAnv7pSjE6HvNKUSYoFB6i8xZc8s';


$url = 'https://apis-sandbox.fedex.com/ship/v1/shipments/tag';

$body = array(
  "requestedShipment"=> array(
    "shipper"=> array(
      "contact"=> array(
        "personName"=> "Pete",
        "phoneNumber"=> "440.716-1820"
      ),
      "address"=> array(
        "streetLines"=> [
          "5455 Detroit Rd, Suite B"
        ],
        "City"=> "Sheffield Village",
        "StateOrProvinceCode"=> "OH",
        "postalCode"=> "44054",
        "countryCode"=> "US"
      )
    ),
    "recipients"=> [
      array(
        "contact"=> array(
          "personName"=> "Ash Malhotra",
          "phoneNumber"=> "800-578-1904"
        ),
        "address"=> array(
          "streetLines"=> [
            "118 W Streetsboro"
          ],
          "City"=> "Hudson",
          "StateOrProvinceCode"=> "OH",
          "postalCode"=> "44236",
          "countryCode"=> "US"
        )
      )
    ],
    "shipDatestamp"=> "2023-01-20",
    "pickupType"=> "CONTACT_FEDEX_TO_SCHEDULE",
    "serviceType"=> "PRIORITY_OVERNIGHT",
    "packagingType"=> "FEDEX_BOX",
    "shippingChargesPayment"=> array(
      "paymentType"=> "SENDER",
      "payor"=> array(
        "responsibleParty"=> array(
          "accountNumber"=> array(
            "value"=> "740561073"
          )
        )
      )
    ),
    "shipmentSpecialServices"=> array(
      "specialServiceTypes"=> [
        "RETURN_SHIPMENT"
      ],
      "returnShipmentDetail"=> array(
        "returnType"=> "FEDEX_TAG"
      )
    ),
    "blockInsightVisibility"=> false,
    "pickupDetail"=> array(
      "readyPickupDateTime"=> "2023-01-20T09=>00=>00Z",
      "latestPickupDateTime"=> "2023-01-20T14=>00=>00Z"
    ),
    "requestedPackageLineItems"=> [
      array(
        "weight"=> array(
          "units"=> "LB",
          "value"=> "5"
        )
      )
    ]
  ),
  "accountNumber"=> array(
    "value"=> "740561073"
  )
);
 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer $token","X-locale: en_US"));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_POST, 1); 
$result = curl_exec($ch);
curl_close ($ch);

/* $final_decoded_data = json_decode($result);
foreach($final_decoded_data as $key => $val){
  echo $key . ': ' . $val . '<br>';
}
 */
print $result;

/* 
<?php

$request = new HttpRequest();
$request->setUrl('https://apis-sandbox.fedex.com/ship/v1/shipments/tag');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'Authorization' => 'Bearer ',
  'X-locale' => 'en_US',
  'Content-Type' => 'application/json'
));

$request->setBody(input); // 'input' refers to JSON Payload

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}
 */

exit;
/* 
$request = new HttpRequest();echo "Hiiiiiiiiiii";exit;
$request->setUrl('https://apis-sandbox.fedex.com/oauth/token');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'Content-Type' => 'application/x-www-form-urlencoded'
));

$input = array("grant_type"=>"client_credentials","client_id"=>"l764bcb84bd42f4319a5c390efcdddeeeb", "client_secret"=> "8c0221b401624b9bb5b3ad5e67365e1b");
$request->setBody($input); // 'input' refers to JSON Payload

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
} */