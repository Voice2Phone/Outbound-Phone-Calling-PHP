<?php
use Voice2Phone;
include 'voice2phone.php';


$apiSercretKey = "type your secrete api key here";
$phone = "type your phone number here";
$countryCode = "type your two letter country code here";
$message = "type your message here";


$res = Voice2Phone\RestClient::MakeCall($apiSercretKey, $phone, $countryCode, $message,  array("1"=>"You pressed one", "2"=>"You pressed two") );

print "Http Status: " . $res->HttpStatus;
print "Error: " . $res->ErrorMessage;


if ($res->HttpStatus == 200)
{
    print "Call Id: " . $status->CallId;
    $status = Voice2Phone\RestClient::GetCallStatus($apiSercretKey, $res->CallId);
    print "Status: " . $status->Status;
    print "CreatedDateUtc: " . $status->CreatedDateUtc;
    print "UpdatedDateUtc: " . $status->UpdatedDateUtc;
    print "Dtmf: " . $status->Dtmf;
}

?>
