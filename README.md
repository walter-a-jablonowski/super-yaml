# Super YAML

**Supercharges YAML**, based on Symfony Yaml, currently adds include feature.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**This is a new project, might still need debugging**

> If you like visit my personal homepage: [walter-a-jablonowski.github.io](https://walter-a-jablonowski.github.io)


## Usage

```
composer require walter-a-jablonowski/super-yaml
```


### Basic usage

Simliar symfony yaml

```php
SuperYaml::parse( $yml );
SuperYaml::parseFile( $fil );
SuperYaml::dump( $yml );

SuperYaml::parse( $yml, [  // use symfony flags while parsing
  'flags' => ...           // difference: additional args as array
]); 

SuperYaml::dump( $yml, [   // use symfony inline, indent, flags on dumping
  'inline' => ... ,
  'indent' => ... ,
  'flags' => ...
]); 
```


### Include

See `demo/demo.php`: one yml file includes 2 yml-files

```yaml
ANY_KEY:                     "@file(sub/sub/fil.yml)"
"@include [UNIQUE_STRING]":  "@file( sub/sub/fil.yml )"  # also includes key(s)
```

**[UNIQUE_STRING]** = a user defined unique string in case you are using the same key again (yml needs unique keys)

Result:

![scr.jpg](misc/scr.jpg?raw=true "Scr")


### Replace constant string

See `demo/demo.php` **sample under construction**

```yaml
ANY_KEY:                     "@file([REPLACE_STRING]sub/sub/fil.yml)"
"@include [UNIQUE_STRING]":  "@file( [REPLACE_STRING]sub/sub/fil.yml )"  # also includes key(s)
```

**[UNIQUE_STRING]**  = see above \
**[REPLACE_STRING]** = a string that will be replaced as defined in $rpl argument

```php
SuperYaml::parse( $yml, [  // additional args as array
  'rpl' => [
  
  ]
]);
```


### Include conditionally

You may define a list of bool vars that are used to decide wheather a file should be included. Calculate all your values before calling SuperYaml.

See `demo/demo.php` **sample under construction**

```yaml
"@includeIf(boolVar) [UNIQUE_STRING]:"    ANY_VALUE
"@includeIf( boolVar ) [UNIQUE_STRING]":  "@file( sub/sub/fil.yml )"
```

**[UNIQUE_STRING]** = see above

```php
SuperYaml::parse( $yml, [
  'boolVar' => [

  ]
]);
```


### Include text

Include just plain text

```
ANY_KEY: |

   some text

   @text(sub/sub/fil.yml)
   
   some text
   
   @text( sub/sub/fil2.yml )
```


## LICENSE

Copyright (C) Walter A. Jablonowski 2018-2020, MIT [License](LICENSE)

Licenses of third party software see [credits](credits.md)


[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)


## Changelog

* [x] **2020** - Fix, readme
* [x] **2020** - Added readme, publication
* [x] **2019** - Added class, improved code
* [x] **2018** - Initial development
