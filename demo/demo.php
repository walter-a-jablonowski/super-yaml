<?php

use WAJ\Lib\Persis\SuperYAML;
use Kint\Kint;

require( 'vendor/autoload.php' );
require( '../src/SuperYAML.php' );
// require( 'kint.phar' );


!d(

  SuperYAML::parse( file_get_contents('demo.yml') )

);

?>