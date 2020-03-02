<?php

namespace App;

class Color
{
    public function store($color_hexadecimal)
    {
        if ( $color_hexadecimal[0] == '#' ) {
            $color_hexadecimal = substr( $color_hexadecimal, 1 );
        }
        if ( strlen( $color_hexadecimal ) == 6 ) {
            list( $r, $g, $b ) = array( $color_hexadecimal[0] . $color_hexadecimal[1], $color_hexadecimal[2] . $color_hexadecimal[3], $color_hexadecimal[4] . $color_hexadecimal[5] );
        } elseif ( strlen( $color_hexadecimal ) == 3 ) {
            list( $r, $g, $b ) = array( $color_hexadecimal[0] . $color_hexadecimal[0], $color_hexadecimal[1] . $color_hexadecimal[1], $color_hexadecimal[2] . $color_hexadecimal[2] );
        } else {
            return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }

}


