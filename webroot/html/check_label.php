<?php

if(!empty($_POST)) {
 
    $body = 'grant_type=client_credentials&client_id=l764bcb84bd42f4319a5c390efcdddeeeb&client_secret=8c0221b401624b9bb5b3ad5e67365e1b';
    $url = 'https://apis-sandbox.fedex.com/oauth/token';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $json = json_decode($response, true);
    curl_close($ch);
    //print_r($json);
    $token = $json["access_token"];


    $data = array(
        "labelResponseOptions"=> "URL_ONLY",
        "requestedShipment"=> array(
            "shipper"=> array(
            "contact"=> array(
                "personName"=> $_POST['personName'],
                "phoneNumber"=> $_POST['phoneNumber'],
                "companyName"=> $_POST['companyName']
            ),
            "address"=> array(
                "streetLines"=> [
                    $_POST['streetLines']
                ],
                "City"=> $_POST['City'],
                "StateOrProvinceCode"=> $_POST['StateOrProvinceCode'],
                "postalCode"=> $_POST['postalCode'],
                "countryCode"=> $_POST['countryCode']
            )
            ),
            "recipients"=> [
            array(
                "contact"=> array(
                "personName"=> $_POST['personNameR'],
                "phoneNumber"=>$_POST['phoneNumberR'],
                "companyName"=> $_POST['companyNameR']
                ),
                "address"=> array(
                "streetLines"=> [
                    $_POST['streetLines1R'],
                    $_POST['streetLines2R']
                ],
                "City"=> $_POST['CityR'],
                "StateOrProvinceCode"=> $_POST['StateOrProvinceCodeR'],
                "postalCode"=> $_POST['postalCodeR'],
                "countryCode"=> $_POST['countryCodeR']
                )
            )
            ],
            "shipDatestamp"=> $_POST['shipDatestamp'],
            "serviceType"=> "STANDARD_OVERNIGHT",
            "packagingType"=> "FEDEX_ENVELOPE",
            "pickupType"=> "USE_SCHEDULED_PICKUP",
            "blockInsightVisibility"=> false,
            "shippingChargesPayment"=> array(
            "paymentType"=> "SENDER"
            ),
            "labelSpecification"=> array(
            "imageType"=> "PDF",
            "labelStockType"=> "PAPER_85X11_TOP_HALF_LABEL"
            ), 
            "requestedPackageLineItems"=> [
            array(
                "weight"=> array(
                "value"=> "1",
                "units"=> "LB"
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

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'X-locale: en_US',
    'Authorization: Bearer ' . $token));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseShip = curl_exec($ch);
    $jsonShip = json_decode($responseShip, true);
    curl_close ($ch);
    //echo "<pre>";
    //print_r($jsonShip);

}
?>
<style>
    table {
        font-family: Verdana;
        font-size: 12px;
    }
    h1 {
        font-family: Verdana;
        font-size: 16px;
    }
</style>
<table width="60%" cellpadding="3" cellspacing="0" border="0">
    <tr>
        <td width="50%">
            <form name="frmShip" id="frmShip" action="check_label.php" method="post">
            <h1>Generate Shipping Label</h1>
            <table width="100%" cellpadding="3" cellspacing="0" border="0">

                <tr>
                    <td>Shipping Date</td>
                    <td><input type="text" name="shipDatestamp" value="<?=date("Y-m-d")?>" /></td>
                </tr>
                <tr>
                    <th align="left">Shipper Details</th><th></th>
                </tr>
                <tr>
                    <td>Person Name</td>
                    <td><input type="text" name="personName" value="Peter Bodonyi" /></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="phoneNumber" value="9876543210" /></td>
                </tr>
                <tr>
                    <td>Company Name</td>
                    <td><input type="text" name="companyName" value="Lender Recording Services" /></td>
                </tr>

                <tr>
                    <th align="left">Shipper Address</th><th></th>
                </tr>
                <tr>
                    <td>Street Line</td>
                    <td><input type="text" name="streetLines" value="5455 Detroit Rd, Suite B" /></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><input type="text" name="City" value="Sheffield Village" /></td>
                </tr>
                <tr>
                    <td>State / Province Code</td>
                    <td><input type="text" name="StateOrProvinceCode" value="OH" /></td>
                </tr>
                <tr>
                    <td>Postal Code</td>
                    <td><input type="text" name="postalCode" value="44054" /></td>
                </tr>
                <tr>
                    <td>Country Code</td>
                    <td><input type="text" name="countryCode" value="US" /></td>
                </tr>


                <tr>
                    <th align="left">Recipient Details</th><th></th>
                </tr>
                <tr>
                    <td>Person Name</td>
                    <td><input type="text" name="personNameR" value="TIU Test" /></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="phoneNumberR" value="9999999999" /></td>
                </tr>
                <tr>
                    <td>Company Name</td>
                    <td><input type="text" name="companyNameR" value="TIU Consulting" /></td>
                </tr>

                <tr>
                    <th align="left">Recipient Address</th><th></th>
                </tr>
                <tr>
                    <td>Street Line 1</td>
                    <td><input type="text" name="streetLines1R" value="118 W Streetsboro" /></td>
                </tr>
                <tr>
                    <td>Street Line 2</td>
                    <td><input type="text" name="streetLines2R" value="Suite 183" /></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><input type="text" name="CityR" value="Hudson" /></td>
                </tr>
                <tr>
                    <td>State / Province Code</td>
                    <td><input type="text" name="StateOrProvinceCodeR" value="OH" /></td>
                </tr>
                <tr>
                    <td>Postal Code</td>
                    <td><input type="text" name="postalCodeR" value="44236" /></td>
                </tr>
                <tr>
                    <td>Country Code</td>
                    <td><input type="text" name="countryCodeR" value="US" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="Submit" name="btnSubmit" value="Generate Shipping Label" style="background-color: #3a58a7;color: #fff; border: 1px solid #3a58a7;" /> </td>
                </tr>
            </table>
            </form>
        </td>
        <td valign="top">
            <table width="100%" cellpadding="3" cellspacing="0" border="0">

                <tr>
                    <th align="left">Result:</th> 
                </tr>
            <?php if(!empty($jsonShip)) { ?>
                <tr>
                    <td>Tracking Number: <?=$jsonShip['output']['transactionShipments'][0]['pieceResponses'][0]['trackingNumber']?></td> 
                </tr>
                <tr>
                    <td><a style="color: #3a58a7;" href="<?=$jsonShip['output']['transactionShipments'][0]['pieceResponses'][0]['packageDocuments'][0]['url']?>" target="_blank">View Shipping Label</a></td> 
                </tr>
            <?php } ?>    
            </table>
        </td>
    </tr>
</table>