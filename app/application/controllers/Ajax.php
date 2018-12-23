<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    private $data;

    public function mail() {
        $to = "team@neenufar.com"; // this is your Email address
        $from = $_POST['email']; // this is the sender's Email address
        $sender_name = $_POST['name'];
        $phone = $_POST['phone'];
        $notes = $_POST['message'];

        $message = $sender_name . " has send the contact message. " . $phone . " is his / her Phone number. He / she worte the following... " . "\n\n" . $notes;


        $subject = "Form submission";

        $headers = 'From: ' . $from;
        mail($to, $subject, $message, $headers);
    }

    /**
     * Convert a value or get the convertion between 2 currencies
     * If non-exists in DB, call to API Coinmarketcap to get the values
     * 
     * @param type $curr_a currency base
     * @param type $curr_b currency value asked
     * @param type $value value to convert
     */
    public function getCurrency($curr_a, $curr_b, $value = false) {
        // Get currency in DB
        $convert = $this->currency->convert('ethereum', 'usd');
        // Updated each hour
        if (!$convert || strtotime($convert->currency_updated_at) < strtotime('-1hour')) {
            // Get currency API
            $apiReturn = json_decode(file_get_contents('http://api.coinmarketcap.com/v1/ticker/' . $curr_a . '?CMC_PRO_API_KEY=' . $this->config->item('API_KEY_coinmarketcap')));
            // Check if result
            if (isset($apiReturn[0]->price_usd)) {
                // Check currency B
                if ($curr_b == 'usd') {
                    // Add currency in DB
                    $this->currency->addUpdate(array(
                        'currency_a' => $curr_a,
                        'currency_b' => $curr_b
                    ),array(
                        'currency_a' => $curr_a,
                        'currency_b' => $curr_b,
                        'currency_value' => $apiReturn[0]->price_usd
                    ));
                    $value = $apiReturn[0]->price_usd;
                    $status = 'success_api';
                } else {
                    $status = 'error_currency_b';
                }
            } else {
                $status = 'error_api';
            }
        } else {
            $value = $convert->currency_value;
            $status = 'success';
        }

        echo json_encode(array('status' => $status, 'value' => $value));
    }

}
