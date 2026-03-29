<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Track Multiple Piece Shipment

$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJDWFMiXSwiUGF5bG9hZCI6eyJjbGllbnRJZGVudGl0eSI6eyJjbGllbnRLZXkiOiJsNzY0YmNiODRiZDQyZjQzMTlhNWMzOTBlZmNkZGRlZWViIn0sImF1dGhlbnRpY2F0aW9uUmVhbG0iOiJDTUFDIiwiYWRkaXRpb25hbElkZW50aXR5Ijp7InRpbWVTdGFtcCI6IjI0LUphbi0yMDIzIDA0OjI1OjU1IEVTVCIsImdyYW50X3R5cGUiOiJjbGllbnRfY3JlZGVudGlhbHMiLCJhcGltb2RlIjoiU2FuZGJveCIsImN4c0lzcyI6Imh0dHBzOi8vY3hzYXV0aHNlcnZlci1zdGFnaW5nLmFwcC5wYWFzLmZlZGV4LmNvbS90b2tlbi9vYXV0aDIifSwicGVyc29uYVR5cGUiOiJEaXJlY3RJbnRlZ3JhdG9yX0IyQiJ9LCJleHAiOjE2NzQ1NTU5NTUsImp0aSI6IjQyM2Y4NGVmLTJiNTktNDlkZC05ZjVhLTdkYzU5MzcwM2M2ZCJ9.KvfUZJHZ99XChfHWDJddYEpKUwqaRci9hVcWT7mvTm5tQhhIjEFEbc6Q9t6Bj_8AbdT3OHCamTS2HJkwAwcC069HI0SyuJLxkosI7MRC5A38BFRuH5o2Sb9tnh9ZITepFZCUpstYf_lM08wCxMKP0DcQnmYxBtdUzas9_H3Y6EPe8gdujmPyfFttAYaji035IjUG9bJ9ZKlspcZx_1zNFsA3KXhVW4_1NQ0YUtt97vLh8KCHlXMy4dc2XqqlbD0kdpWeORHex0nz0oAj-v1eeNVIxCOqybHlNnc5aF6VuF6B0UbZE4QPW9UQXPzPhy4N9ZZrGTH1Rs8Qk-bypNdGzzz8jiaG9zvn3ulRY0d1ePNbhLdDU9bAVkIVfJGaEN5moO5-msmmbhe1coa6ZOCdUXpbu2bbMxNbYQI9nxlFINWgE0xKlWCW4tOERqRWe9aKVTxYSiysqT7L2pAGEXxSomqICPbk81e_WXK6XPQaK79bccNWvadvnlH4cOYkdwf5WbgeAyNae7_n0i52d7e3U7b0WBKQ5My-f3Dwv9R55OkQis9TQLbeaCevtiP2LGfttC6m6z1ygMrgP5BDl1yJy6otu4s1fFPYGBMzqz7un7eAnFc1WxT52jJk5PCfvIZriogMVkG4fZr2ip4Ha4AyD74THM3jllNKtk-uBIjorVw';



$data = array(
  "trackingNumberInfo"=> array(
    "trackingNumber"=> "794607673315"
  ),
  "senderEMailAddress"=> "mjamal@tiuconsulting.com",
  "senderContactName"=> "Jamal",
  "trackingEventNotificationDetail"=> array(
    "trackingNotifications"=> [
      array(
        "notificationEventTypes"=> [
          "ON_ESTIMATED_DELIVERY",
          "ON_TENDER",
          "ON_EXCEPTION",
          "ON_DELIVERY"
        ],
        "notificationDetail"=> array(
          "notificationType"=> "HTML",
          "emailDetail"=> array(
            "emailAddress"=> "mjamal@tiuconsulting.com"
          ),
          "localization"=> array(
            "languageCode"=> "en",
            "localeCode"=> "US"
          )
        )
      )
    ]
  )
);


$post_data = json_encode($data);
//print_r($post_data);exit;
$url = 'https://apis-sandbox.fedex.com/track/v1/notifications';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'X-locale: en_US',
  'Authorization: Bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_POST, 1); 
$result = curl_exec($ch);
curl_close ($ch);
print $result; 

exit;
  


// Create Shipment API
$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJDWFMiXSwiUGF5bG9hZCI6eyJjbGllbnRJZGVudGl0eSI6eyJjbGllbnRLZXkiOiJsNzY0YmNiODRiZDQyZjQzMTlhNWMzOTBlZmNkZGRlZWViIn0sImF1dGhlbnRpY2F0aW9uUmVhbG0iOiJDTUFDIiwiYWRkaXRpb25hbElkZW50aXR5Ijp7InRpbWVTdGFtcCI6IjIzLUphbi0yMDIzIDA3OjM3OjQyIEVTVCIsImdyYW50X3R5cGUiOiJjbGllbnRfY3JlZGVudGlhbHMiLCJhcGltb2RlIjoiU2FuZGJveCIsImN4c0lzcyI6Imh0dHBzOi8vY3hzYXV0aHNlcnZlci1zdGFnaW5nLmFwcC5wYWFzLmZlZGV4LmNvbS90b2tlbi9vYXV0aDIifSwicGVyc29uYVR5cGUiOiJEaXJlY3RJbnRlZ3JhdG9yX0IyQiJ9LCJleHAiOjE2NzQ0ODEwNjIsImp0aSI6ImQ2MWU3YTQyLTgwZDItNDBjMy1iODEwLTk0MGUwZjU1NmI1MiJ9.duNmT-SWaofxGOZUmM0wxrH5Txf98G1YczgmLUCzUZ652Dq7GQX_lOwwYkoWKJpDvqCwK3ccYiVUCrbGNe45o4_hiUxrnLltXNnRNGveLCR42hGbmVjxoDAhNu2FrkDb8rDlwV4Re5flWbCcaHuWABE9z2RQxjTkWh5-OWSkmCdm_gHzAJtwG22m9oEWPl1x6OBRQG6Aq0I1B7X-KFUiaFnPAqW34ohmOQS9Ak2Bmo6fYH-ei6qzKRqiRO-TdR7NklLZxvuZuuOEp4SUaKvKJ_9vUrg95tnR7lL-ZVx8dxNXFzUBMWUkWnztL6OTqZq7IhsnVneSioHpTz9O9Anltyp2LVnRghMk_L29-0fYXOBfF42K6OD7pGxOnaVoxkDyyvwNsvU9GxCRo6yH8mOdil9M_CSBNht6xspqi8byFz8mEXNSJDgS6BrIazl53SXYAuDZJLnQieyJu6rRsSJ5XPgRdh9sxlYwB7sGkYFBU5hmodpybE1Pb_Y9SkzMdWt3htjZXyIFDJhVju3SvY19e8DSBN-BVFjQpM51qwLBMrbMMp2Totu1l9Geyd6843XeKnVK0px45Wm2rFT_hHXzCDtDgqirWvmx1qO9N9TPQxZWDJdbnA8Q2NYpWADvG5iRnPb6HTZVBoKwr_3TZfvq4YJJ7Qd92OLJoz3M3b-zs6A';



$data = array(
  "labelResponseOptions"=> "URL_ONLY",
  "requestedShipment"=> array(
    "shipper"=> array(
      "contact"=> array(
        "personName"=> "Pete",
        "phoneNumber"=> "440.716-1820",
        "companyName"=> "LRS"
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
          "phoneNumber"=> "800-578-1904",
          "companyName"=> "TIU Consulting"
        ),
        "address"=> array(
          "streetLines"=> [
            "118 W Streetsboro",
            "Suite 183"
          ],
          "City"=> "Hudson",
          "StateOrProvinceCode"=> "OH",
          "postalCode"=> "44236",
          "countryCode"=> "US"
        )
      )
    ],
    "shipDatestamp"=> "2023-01-25",
    "serviceType"=> "FEDEX_1_DAY_FREIGHT",
    "packagingType"=> "YOUR_PACKAGING",
    "pickupType"=> "USE_SCHEDULED_PICKUP",
    "blockInsightVisibility"=> false,
    "shippingChargesPayment"=> array(
      "paymentType"=> "SENDER"
    ),
    "labelSpecification"=> array(
      "imageType"=> "PDF",
      "labelStockType"=> "PAPER_85X11_TOP_HALF_LABEL"
    ),
    "expressFreightDetail"=> array(
      "bookingConfirmationNumber"=> "123456789812",
      "shippersLoadAndCount"=> 1
    ),
    "requestedPackageLineItems"=> [
      array(
        "weight"=> array(
          "value"=> "151",
          "units"=> "LB"
        ),
        "dimensions"=> array(
          "length"=> 12,
          "width"=> 12,
          "height"=> 12,
          "units"=> "IN"
        )
      )
    ]
  ),
  "accountNumber"=> array(
    "value"=> "740561073"
  )
);


$post_data = json_encode($data);
//print_r($post_data);exit;
$url = 'https://apis-sandbox.fedex.com/ship/v1/shipments';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'X-locale: en_US',
  'Authorization: Bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_POST, 1); 
$result = curl_exec($ch);
curl_close ($ch);
print $result; 

exit;









// Create Tag API 
$token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJDWFMiXSwiUGF5bG9hZCI6eyJjbGllbnRJZGVudGl0eSI6eyJjbGllbnRLZXkiOiJsNzY0YmNiODRiZDQyZjQzMTlhNWMzOTBlZmNkZGRlZWViIn0sImF1dGhlbnRpY2F0aW9uUmVhbG0iOiJDTUFDIiwiYWRkaXRpb25hbElkZW50aXR5Ijp7InRpbWVTdGFtcCI6IjIzLUphbi0yMDIzIDAyOjE5OjU3IEVTVCIsImdyYW50X3R5cGUiOiJjbGllbnRfY3JlZGVudGlhbHMiLCJhcGltb2RlIjoiU2FuZGJveCIsImN4c0lzcyI6Imh0dHBzOi8vY3hzYXV0aHNlcnZlci1zdGFnaW5nLmFwcC5wYWFzLmZlZGV4LmNvbS90b2tlbi9vYXV0aDIifSwicGVyc29uYVR5cGUiOiJEaXJlY3RJbnRlZ3JhdG9yX0IyQiJ9LCJleHAiOjE2NzQ0NjE5OTcsImp0aSI6ImQzN2JiNjc3LTc4NmQtNGExYy1iMGNiLWFlZmMzOTUzN2ZlNCJ9.W-BVmbLVrSRdbwEj8_mo37G-Wm6H_YOKHgXLJMPQyqsHL8ZlM0H5pqpkwmxb7aCRZ_T05zUk1Nq_73DyUpIe5dWbZyl9ljAplMAM7-KQiYlLJQSU_LFBb8neWQozsgxtbMCjMKPCfdAO2oNfU0quDWROxQXrHjQh9raKbq0gfF110kS3FvNlF4FlF9zAR2n1GyM28Kn3YJACJrUAw0HeuR_FRSee0V_gjtAH3rgUy_sErUX7zBHFSZscMo_MnP325628NQZ5i0hgiVr436n10cgj65sh-n9EQSwTx0rLjAnuKo9XwRNzIL9DQ8n6dNj4uQGGBy8o1qIhQOfZHnBf5HlfKX422qdJpI7z0QVmx5S73g28zVVFJd8vJXmGfZZC8LBX6ilRQ42sGrwt8PmHGakkAb1f-uBxRvyxnA1bkemgZUyLUtLwVZhHd3royd2EXByr2863MQp_R09HcLoUtTKdSla2JWgxt91smFIWmKVbdJDJRprWCasXOpcf_DCc_cSA7jznv-Tl6ntN33gsO_I5l8TIvBkwbsm9vR95Zs2atKMq0LabM85oMmwFKT_1cdD1rIXvm_a0A-RXxP6occkutUw18DDhXlyLk3uiBNzPF7qhHsLL23aYR89JP-fyIOj6JsgeP4SJ9p5Nihd96OlD0DSeXnqGXyawJ6roICQ';
 
  $data = array(
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
    "shipDatestamp"=> "2023-01-24",
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
      "readyPickupDateTime"=> "2023-01-24T09:00:00Z",
      "latestPickupDateTime"=> "2023-01-24T14:00:00Z"
    ),
    "requestedPackageLineItems"=> [
      array(
        "weight"=> array(
          "units"=> "LB",
          "value"=> 5
        )
      )
    ]
  ),
  "accountNumber"=> array(
    "value"=> "740561073"
  )
);
   
  $post_data = json_encode($data);
   //print_r($post_data);exit;
   $url = 'https://apis-sandbox.fedex.com/ship/v1/shipments/tag';
   
  $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'X-locale: en_US',
      'Authorization: Bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_POST, 1); 
$result = curl_exec($ch);
curl_close ($ch);
print $result; 
   
exit;
    
?>