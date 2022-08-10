<?php

class Zume_V4_Pieces {
    public static function vars( int $tool_number ) : array {
        // list of image urls
        $url_array = array(
            1 => '/assets/images/pieces_pages/1-ordinary-people.png',
            2 => '/assets/images/pieces_pages/1-follow-jesus-point.svg',
            3 => '/assets/images/pieces_pages/1-spiritual-breathing.png',
            4 => '/assets/images/pieces_pages/1-reading.svg',
            5 => '/assets/images/pieces_pages/accountability.png',
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
            27 => '',
            28 => '/assets/images/pieces_pages/10-checklist.png',
            29 => '/assets/images/pieces_pages/10-networks.png',
            30 => '/assets/images/pieces_pages/10-peer-mentoring.png',
            31 => '',
            32 => '',
            33 => '/assets/images/zume_images/V5.1/1Waving1Not.svg',
        );

        // audio tools
        $audio_array = array(
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
            20 => false,
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
        );

        // audio tools
        $has_video = array(
            1 => true,
            2 => true,
            3 => true,
            4 => true,
            5 => true,
            6 => true,
            7 => true,
            8 => true,
            9 => true,
            10 => true,
            11 => true,
            12 => true,
            13 => true,
            14 => true,
            15 => true,
            16 => true,
            17 => true,
            18 => true,
            19 => false,
            20 => true,
            21 => true,
            22 => true,
            23 => true,
            24 => true,
            25 => true,
            26 => true,
            27 => true,
            28 => true,
            29 => true,
            30 => true,
            31 => false,
            32 => false,
        );

        $video_id = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12,
            13 => 13,
            14 => 14,
            15 => 15,
            16 => 16,
            17 => 17,
            18 => 18,
            19 => 19,
            20 => 19,
            21 => 21,
            22 => 22,
            23 => 23,
            24 => 24,
            25 => 25,
            26 => 26,
            27 => 27,
            28 => 28,
            29 => 29,
            30 => 30,
            31 => 31,
            32 => 32,
        );

        $post_id = array(
            1 => 20730, // God uses ordinary people
            2 => 20731, // teach them to obey
            3 => 20732, // spiritual breathing
            4 => 20733, // soaps bible reading
            5 => 20735, // accountability groups
            6 => 20737, // consumers vs producers
            7 => 20738, // prayer cycle
            8 => 20739, // list of 100
            9 => 20740, // kingdom economy
            10 => 20741, // the gospel
            11 => 20742, // baptism
            12 => 20743, // 3-minute testimony
            13 => 20744, // greatest blessing
            14 => 20745, // duckling discipleship
            15 => 20746, // seeing where God's kingdom isn't
            16 => 20747, // the lord's supper
            17 => 20748, // prayer walking
            18 => 20750, // person of peace
            19 => 20749, // bless prayer
            20 => 20751, // faithfulness
            21 => 20752, // 3/3 group pattern
            22 => 20753, // training cycle
            23 => 20755, // leadership cells
            24 => 20756, // non-sequential
            25 => 20757, // pace
            26 => 20758, // part of two churches
            27 => 19848, // 3-month plan
            28 => 20759, // coaching checklist
            29 => 20760, // leadership in networks
            30 => 20761, // peer mentoring groups
            31 => 20762, // four fields tool
            32 => 20763, // generation mapping
        );

        // get session from tool number
        if ( in_array( $tool_number, array( 1,2,3,4,5 ) ) ) {
            $session_number = 1;
        } else if ( in_array( $tool_number, array( 6,7,8 ) ) ) {
            $session_number = 2;
        }
        else if ( in_array( $tool_number, array( 9,10,11 ) ) ) {
            $session_number = 3;
        }
        else if ( in_array( $tool_number, array( 12,13,14,15,16 ) ) ) {
            $session_number = 4;
        }
        else if ( in_array( $tool_number, array( 17,18,19 ) ) ) {
            $session_number = 5;
        }
        else if ( in_array( $tool_number, array( 20,21 ) ) ) {
            $session_number = 6;
        }
        else if ( in_array( $tool_number, array( 22 ) ) ) {
            $session_number = 7;
        }
        else if ( in_array( $tool_number, array( 23 ) ) ) {
            $session_number = 8;
        }
        else if ( in_array( $tool_number, array( 24,25,26,27 ) ) ) {
            $session_number = 9;
        } else {
            $session_number = 10;
        }


        $data = array();

        $data['tool_number'] = $tool_number;
        $data['session_number'] = $session_number;
        $data['alt_video'] =  zume_alt_video();
        $data['audio'] = $audio_array[$tool_number] ?? false; // determine if is an audio tool
        $data['has_video'] = $has_video[$tool_number];
        $data['video_id'] = $video_id[$tool_number] ?? 0;
        $data['post_id'] = $post_id[$tool_number] ?? 0;
        $data['image_url'] = !empty( $url_array[$tool_number] ) ? get_theme_file_uri() . $url_array[$tool_number] : false;



        return $data;
    }

    public static function image_for_tool( $tool_number ) {

    }
}
