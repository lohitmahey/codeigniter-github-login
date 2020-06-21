<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');
    
    
    function curl_request( $url, $additionalHeaders = array(), $method = 'GET', $postParams = array() ) {
        
        // get main CodeIgniter object
        // $ci = get_instance();
        
        
        $headers = [
            'Accept: application/json'
        ];
        
        if( count( $additionalHeaders ) ) {
            $headers = array_merge( $headers, $additionalHeaders );
        }
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
        
        if( $method == 'POST' ) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec( $ch );
        // $result = '{"error":"bad_verification_code","error_description":"The code passed is incorrect or expired.","error_uri":"https://developer.github.com/apps/managing-oauth-apps/troubleshooting-oauth-app-access-token-request-errors/#bad-verification-code"}';
        curl_close( $ch );
        
        $result = json_decode( $result, true );
        
        if( $result ) {
            return $result;
        } else {
            $return = [
                'error' => true,
                'msg' => "Please Try again later"
            ];
        }
        
        return $return;
    }

?>