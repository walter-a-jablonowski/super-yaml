<?php

namespace WAJ\Lib\Persis

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;


/*@

*/
class SuperYAML /*@*/
{

  /*@
  
  Loads super yml string
  
  ARGS:

    yml:          yml
    rpl = []:     NAME => RPL will rpl "[NAME]" => RPL in value
    booVar = []:  for @includeIf()
    flags = 0:    Normal symfony yaml flags
 
  */
  public static function parse( $yml, $args = [])  /*@*/
  {
    $flags = isset($args['flags'])  ?  $args['flags']  :  0;
    $a = Yaml::parse( $yml, $flags );

    return self::parseInt( $a, $args );
  }


  /*@

  Loads super yml file

  args like parse()

  */
  public static function parseFile( $fil, $args = [])  /*@*/
  {
    $flags = isset($args['flags'])  ?  $args['flags']  :  0;
    $a = Yaml::parseFile( $fil, $flags);

    return self::parseInt( $a, $args);
  }


  /*@

  Just like symfony

  ARGS:

    input:
    inline = 2:
    indent = 4:
    flags = 0:    Normal symfony yaml flags
  
  Returns: string

  */
  public static function dump( $input, $args = []) : string
  {
    $inline = isset($args['inline'])  ?  $args['inline']  :  2;
    $indent = isset($args['indent'])  ?  $args['indent']  :  2;  // Symphony uses 4
    $flags  = isset($args['flags'])   ?  $args['flags']   :  0;

    return Yaml::dump( $input, $inline, $indent, $flags);
  }


  /*@

  Internal, used by parse() and parseFile(), recurse yml, perform includes

  args like calling func

  */
  private static function parseInt( $yml_arr, $args = []) /*@*/
  {
    $boolVar = isset($args['boolVar'])  ?  $args['boolVar']  :  [];

    $r = [];
    foreach( $yml_arr as $name => $v)
    {

      // Recurse sub arr

      if( is_array($v))

        $r[ $name ] = self::parseInt( $v, $args);

      else

        // Process different includes types (depends on order)

        // @includeIf(boolVar) UNIQUE_STRING:    ANY_VALUE
        // @includeIf( boolVar ) UNIQUE_STRING:  @file( [REPLACE_STRING]sub/sub/fil.yml )

        if( stripos( trim($name), '@includeIf') === 0 )
        {
          $a = [];
          preg_match( '/\@includeIf\s*\(\s*(.*)\s*\)/i', $name, $a);

          eval("\$b = \$boolVar" . "['" . $a[1] . "'];");  // Task a[1], boolVar unknown

          if( ! $b )  continue;

          if( stripos( trim($v), '@file') === 0 )
            $v = self::loadAddFile( $v, $args);

          $r = array_merge( $r, $v );
        }


        // @include UNIQUE_STRING: @file( [REPLACE_STRING]sub/sub/fil.yml )

        elseif( stripos( trim($name), '@include') === 0 )  // ||  stripos( trim($name), '@use') === 0)
        {
          if( stripos( trim($v), '@file') === 0 )
            $v = self::loadAddFile( $v, $args);

          $r = array_merge($r, $v);
        }


        // ANY_KEY: @file([REPLACE_STRING]sub/sub/fil.yml)

        elseif( stripos( trim($v), '@file') === 0 )  // ||      stripos( trim($v), '@use(') === 0)
        {
          $r[$name] = self::loadAddFile( $v, $args);
        }


        // Normal value

        else
          $r[ $name ] = $v;
    }
    
    return $r;
  }


  /*@

  Used by parseInt(), loads @file()

  args like parseInt()

  */
  private static function loadAddFile( $v, $args = []) /*@*/
  {
    $rpl = isset($args['rpl'])  ?  $args['rpl']  :  [];

    foreach( $rpl as $n => $g)
      $v = str_ireplace( $n, $g, $v);

    $a = [];
    preg_match( '/\@file\s*\(\s*(.*)\s*\)/i', $v, $a);
    $v    = self::parseFile( $a[1], $args);  // Task

    return $v;
  }

}

?>