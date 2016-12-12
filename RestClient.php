<?php
namespace Voice2Phone\Api;
include 'MakeCallResponse.php';
include 'GetCallStatusResponse.php';


class RestClient
{
    static function MakeCall( 
        $secretApiKey, 
        $phoneNumber,
        $countryCode, 
        $message,
        $dtmf)
    {
        
        $body =  array("Message"=> $message, "Phone"=>array("CountryCode"=>$countryCode,  "Number"=> $phoneNumber), "Dtmf"=> $dtmf);
        $bodyJson = json_encode($body);


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.voice2phone.com/call",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $bodyJson,
          CURLOPT_HTTPHEADER => array(
            "authorization: " . $secretApiKey,
            "content-type: application/json"
          ),
        ));

        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpResponse = curl_getinfo($curl);
        curl_close($curl);

        $ret = new MakeCallResponse();
        if ($err) {
            
            $ret->HttpStatus = 500;
            $ret->ErrorMessage = $err;
            return $ret;
        } 
                
        
        if ($httpResponse['http_code'] <> 200)
        {
            $ret->HttpStatus = $httpResponse['http_code'];
            $ret->ErrorMessage = $response;
            
            return $ret;
        }
                
        $json = json_decode($response, true);

        $ret->CallId = $json["CallId"];
        $ret->HttpStatus = 200;
        
        return $ret;
    }


    static function GetCallStatus($secretApiKey, $callId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.voice2phone.com/call/" . $callId,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => $bodyJson,
          CURLOPT_HTTPHEADER => array(
            "authorization: " . $secretApiKey,
            "content-type: application/json"
          ),
        ));

        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpResponse = curl_getinfo($curl);
        curl_close($curl);

        $ret = new GetCallStatusResponse();
        if ($err) {
            
            $ret->ErrorMessage = $err;
            $ret->HttpStatus = 500;
            return $ret;
        } 
        
        
        if ($httpResponse['http_code'] <> 200)
        {
            $ret->ErrorMessage = $response;
            $ret->HttpStatus = $httpResponse['http_code'];
            return $ret;
        }
        
        $json = json_decode($response, true);

        $ret->CallId = $callId;
        $ret->CreatedDateUtc = $json["CreatedDateUtc"];
        $ret->UpdatedDateUtc = $json["UpdatedDateUtc"];
        $ret->Status =  $json["Status"];
        $ret->Dtmf = $json["Dtmf"];
        $ret->HttpStatus = 200;

        return $ret;
    }
}


?>