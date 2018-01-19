<?php

function strtourl( $str, $replace = '-' ) {

  $str = strtr ( strtolower( $str ), '������', 'aeioun' );
  $str = preg_replace( '/[^\w\d]+/', $replace, $str );
  $str = trim( $str, '-' );

  return $str;

}

?>