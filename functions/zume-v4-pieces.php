<?php

class Zume_V4_Pieces {
    public static function vars( int $tool_number ) : array {
        // list of image urls
        $url_array = [
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => '/assets/images/pieces_pages/1-ordinary-people.png',
            6 => '',
            7 => '',
            8 => '',
            9 => '',
            10 => '',
            11 => '',
            12 => '',
            13 => '',
            14 => '',
            15 => '',
            16 => '',
            17 => '',
            18 => '',
            19 => '',
            20 => '',
            21 => '',
            22 => '',
            23 => '',
            24 => '',
            25 => '',
            26 => '',
            27 => '',
            28 => '',
            29 => '',
            30 => '',
            31 => '',
            32 => '',
        ];

        // audio tools
        $audio_array = [
            1 => false,
            2 => false,
            3 => false,
            4 => true,
            5 => true,
            6 => false,
            7 => true,
            8 => true,
            9 => false,
            10 => false,
            11 => true,
            12 => true,
            13 => false,
            14 => false,
            15 => false,
            16 => true,
            17 => true,
            18 => false,
            19 => false,
            20 => true,
            21 => false,
            22 => false,
            23 => false,
            24 => false,
            25 => false,
            26 => false,
            27 => false,
            28 => true,
            29 => false,
            30 => true,
            31 => false,
            32 => false,
        ];

        // get session from tool number
        if ( in_array( $tool_number, [1,2,3,4,5] ) ) {
            $session_number = 1;
        } else if ( in_array( $tool_number, [6,7,8] ) ) {
            $session_number = 2;
        }
        else if ( in_array( $tool_number, [9,10,11] ) ) {
            $session_number = 3;
        }
        else if ( in_array( $tool_number, [12,13,14,15,16] ) ) {
            $session_number = 4;
        }
        else if ( in_array( $tool_number, [17,18,19] ) ) {
            $session_number = 5;
        }
        else if ( in_array( $tool_number, [20,21] ) ) {
            $session_number = 6;
        }
        else if ( in_array( $tool_number, [22] ) ) {
            $session_number = 7;
        }
        else if ( in_array( $tool_number, [23] ) ) {
            $session_number = 8;
        }
        else if ( in_array( $tool_number, [24,25,26,27] ) ) {
            $session_number = 9;
        } else {
            $session_number = 10;
        }


        $data = [];

        $data['tool_number'] = $tool_number;
        $data['session_number'] = $session_number;
        $data['alt_video'] = false;
        $data['audio'] = true; // determine if is an audio tool
        $data['image_url'] = get_theme_file_uri() . $url_array[$tool_number];


        return $data;
    }

    public static function image_for_tool( $tool_number ) {

    }
}
