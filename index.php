<?php
use Voice2Phone;
include 'Voice2Phone\RestClient.php';


$apiSercretKey = "<type your api secret key here>";
$phone = "<type your phone number here>";
$countryCode = "<type two letter country code here. For example: US, CA, etc...>";
$message = "Hello, please press one or two";


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
