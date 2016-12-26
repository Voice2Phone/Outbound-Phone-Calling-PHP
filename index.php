<?php
use Voice2Phone;
include 'voice2phone.php';


$apiSercretKey = "0bd514ffc2135c4de8cb9c9c7e8f15f20912";
$phone = "7789602591";
$countryCode = "CA";
$message = "Hello";


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