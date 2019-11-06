<?php

namespace app\Helpers;

class Aditya 
{

    public static function changeEnv($data = array()){
        if(count($data) > 0){

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            
            return $env;
        } else {
            return false;
        }
    }
    
    /**
     * Send Response to JSON
     */
    public static function sendResponse($message , $data = [] , $status = true) {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data,
            'developer' => 'Muhammad Aditya Nurdin'
        ]);
    }

    /**
     * Calls the method 
     */
    public static function changeRouter($host , $user , $pass){
        $env_update = Self::changeEnv([
            'ROUTER_HOST'   => $host,
            'ROUTER_USER'   => $user,
            'ROUTER_PASS'   => $pass,
        ]);
        if($env_update){
            return Self::sendResponse('Successfully' , $env_update);
        } else {
            return Self::sendResponse('Failed' , NULL , false);
        }
    }
    
}