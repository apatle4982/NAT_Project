<style>
    h1{    font-size: 20px;
    font-weight: 700;
    font-family: sans-serif;}
</style>
<?php
//phpinfo();
error_reporting(E_ALL);
ini_set('display_errors', '1');
 
// For Generating Access Token
echo "<h1>API #1: getToken</h1><br />";
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/user/getToken';

$body = array("secretKey" => "8359fabc166048ca03fd451544a4b4484fdcd35f");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $json = json_decode($response, true);
    $result = $json["jwtToken"];
} 
curl_close($ch); 
 
print_r($result);
$token = $json["jwtToken"];
  
echo "<br>//----------------------------------------------------------------------------//</br>";


// For NEW fee Calculation Estimates
echo "<h1>API #02 NEW : feeCalculation Estimates</h1><br />";
 
$body = array("State" => "1", "County" => "1", "TransactionType" => "0", "documentTypeID" => "131", "considerationAmount" => "240000", "loanAmount" => "320000");

$post_data = json_encode($body); 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/feeCalculationEstimates';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
    
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
} 
curl_close($ch); 

echo "<pre>";print_r($result);
 
echo "<br>//----------------------------------------------------------------------------//</br>";
//----------------------------------------------------------------------------//

exit;
//----------------------------------------------------------------------------//
 

 /* 
// For refresh Token
echo "<h1>API #2: refreshToken</h1><br />";
$token = $result;

$body = array("secretKey" => "8359fabc166048ca03fd451544a4b4484fdcd35f", "jwtToken" => $token);

$post_data = json_encode($body); 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/user/refreshToken';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
    
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
} 
curl_close($ch); 

print_r($result);
//exit; 
echo "<br>//----------------------------------------------------------------------------//</br>";
//----------------------------------------------------------------------------//
  */

 
// For fee Calculation Questions
echo "<h1>API #3: feeCalculationQuestions</h1><br />";
 
$body = array("State" => "1", "County" => "1", "TransactionType" => "1");

$post_data = json_encode($body); 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/feeCalculationQuestions';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
    
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
} 
curl_close($ch); 

echo "<pre>";print_r($result);
  
echo "<br>//----------------------------------------------------------------------------//</br>";
//----------------------------------------------------------------------------//
 

 
// For fee Calculation Estimates
echo "<h1>API #4: feeCalculation Estimates</h1><br />";
 
$body = array("State" => "1", "County" => "1", "TransactionType" => "1", "considerationAmount" => "240000", "loanAmount" => "320000");

$post_data = json_encode($body); 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/feeCalculation';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
    
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
} 
curl_close($ch); 

echo "<pre>";print_r($result);
 
echo "<br>//----------------------------------------------------------------------------//</br>";
//----------------------------------------------------------------------------//
 


 
// For fee Calculation Results Actuals  **********************
echo "<h1>API #5: feeCalculationResultsV2</h1><br />";
 
$body = array("documents" => 
            array("documentId" => 1, "TransactionType" => "Deed", 
            "questions"=> [
                array("id" => "1-1-1-122", "type" => "Integer", "value" => "240000", "values" => []),
                array("id" => "1-1-1-379", "type" => "Single Select", "value" => "0", "values" => []),
                array("id" => "1-1-1-82", "type" => "Integer", "value" => "3", "values" => []),
                array("id" => "1-1-1-201", "type" => "Integer", "value" => "0", "values" => []),
                array("id" => "1-1-1-287", "type" => "Integer", "value" => "0", "values" => [])
            ]
        ), 
        "serviceQuoteId" => "CustomerReferenceId");

$post_data = json_encode($body); 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/feeCalculationResultsV2';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
}
curl_close($ch);

echo "<pre>";print_r($result);
 
echo "<br>//----------------------------------------------------------------------------//</br>";
//----------------------------------------------------------------------------//
 

 
// For State Counties
echo "<h1>API #6: Statecounties</h1><br />";
 
$body = array("StateId" => "1");

$post_data = json_encode($body); 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/Statecounties';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
    'Authorization: bearer ' . $token));
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
    
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
} 
curl_close($ch); 

echo "<pre>";print_r($result);
 
//----------------------------------------------------------------------------//
 
echo "<br>//----------------------------------------------------------------------------//</br>";

 
// For State List
echo "<h1>API #7: Stateslist</h1><br />";
 
$url = 'https://sandboxaws.enoahprojects.com/3hm_live_v1/api_services/public/api/Stateslist';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
    'Authorization: bearer ' . $token)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
    
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    $result = array("error"=>$error_msg);
} else {
    $jsonResult = json_decode($response, true); 
    if(!empty($jsonResult)) {
        $result = $jsonResult;
    } else {
        $result = array("error"=>"Something went wrong, please check and try again.");
    }					
} 
curl_close($ch); 

echo "<pre>";print_r($result);
 
//----------------------------------------------------------------------------//
 

?>