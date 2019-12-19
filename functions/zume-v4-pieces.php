<?php

class Zume_V4_Pieces {
    public static function vars( int $tool_number ) : array {
        // list of image urls
        $url_array = [
            1 => '/assets/images/pieces_pages/1-ordinary-people.png',
            2 => '/assets/images/pieces_pages/1-follow-jesus-point.svg',
            3 => '/assets/images/pieces_pages/1-spiritual-breathing.png',
            4 => '/assets/images/pieces_pages/1-reading.svg',
            5 => '/assets/images/pieces_pages/1-church-at-home.svg',
            6 => '/assets/images/pieces_pages/2-produce-consume.png',
            7 => '/assets/images/pieces_pages/2-pray-day-night.svg',
            8 => '/assets/images/pieces_pages/2-long-list.svg',
            9 => '/assets/images/pieces_pages/3-kingdom.png',
            10 => '/assets/images/pieces_pages/3-gospel.png',
            11 => '/assets/images/pieces_pages/3-baptism.svg',
            12 => '/assets/images/pieces_pages/4-testimony.png',
            13 => '/assets/images/pieces_pages/4-greatest-blessing.png',
            14 => '/assets/images/pieces_pages/4-leading.png',
            15 => '/assets/images/pieces_pages/4-kingdom-isnt.png',
            16 => '/assets/images/pieces_pages/4-give-bread.svg',
            17 => '/assets/images/pieces_pages/5-walking.svg',
            18 => '/assets/images/pieces_pages/5-person-peace.png',
            19 => '/assets/images/pieces_pages/5-pray.svg',
            20 => '/assets/images/pieces_pages/6-faithful-balance.svg',
            21 => '/assets/images/pieces_pages/6-thirds.png',
            22 => '/assets/images/pieces_pages/7-training-cycle.png',
            23 => '/assets/images/pieces_pages/8-leadership-cell.png',
            24 => '/assets/images/pieces_pages/9-non-sequential.png',
            25 => '/assets/images/pieces_pages/9-pace.png',
            26 => '/assets/images/pieces_pages/9-two-churches.png',
            27 => '/assets/images/pieces_pages/10-checklist.png',
            28 => '/assets/images/pieces_pages/10-networks.png',
            29 => '/assets/images/pieces_pages/10-peer-mentoring.png',
            30 => '',
            31 => '',
            32 => '',
            33 => '/assets/images/zume_images/V5.1/1Waving1Not.svg',
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
