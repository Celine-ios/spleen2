<?php

function strtourl( $str, $replace = '-' ) {

  $str = strtr ( strtolower( $str ), 'αινσϊρ', 'aeioun' );
  $str = preg_replace( '/[^\w\d]+/', $replace, $str );
  $str = trim( $str, '-' );

  return $str;

}

?>