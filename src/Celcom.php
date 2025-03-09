<?php

namespace Celcom;

class Celcom
{
    // smsleopard check balance
    public function send($mobile, $message)
    {
        $url = 'https://isms.celcomafrica.com/api/services/sendsms/';

        // Ensure mobile numbers are an array
        $mobileNumbers = is_array($mobile) ? $mobile : [$mobile];

        // Convert array to a comma-separated string
        $mobileString = implode(',', $mobileNumbers);

        $data = array(

            //Fill in the request parameters with valid values
            'partnerID' => $_SERVER['CELCOM_PARTNER_ID'],
            'apikey' => $_SERVER['CELCOM_API_KEY'],
            'mobile' => $mobileString,
            'message' => $message,
            'shortcode' => $_SERVER['CELCOM_SHORTCODE'],
            'pass_type' => 'plain', //bm5 {base64 encode} or plain
        );

        $smsService = $this->sendRequest($url, $data);

        return $smsService;
    }

    // check balance for celcom
    public function balance()
    {
        $url = 'https://isms.celcomafrica.com/api/services/getbalance/';

        $data = array(
            //Fill in the request parameters with valid values
            'partnerID' => $_SERVER['CELCOM_PARTNER_ID'],
            'apikey' => $_SERVER['CELCOM_API_KEY'],
        );

        $smsService = $this->sendRequest($url, $data);

        return $smsService;
    }


    // check status for celcom
    public function status($messageId)
    {
        $url = 'https://isms.celcomafrica.com/api/services/getdlr/';

        $data = array(
            //Fill in the request parameters with valid values
            'partnerID' => $_SERVER['CELCOM_PARTNER_ID'],
            'apikey' => $_SERVER['CELCOM_API_KEY'],
            'messageID' => $messageId,
        );

        $smsService = $this->sendRequest($url, $data);

        return $smsService;
    }


    private function sendRequest($url, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}