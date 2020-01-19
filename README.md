# Super YAML

**Supercharges YAML**

Currently adds include feature, uses Symfony Yaml.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**This is a new project, might still need debugging**

> If you like visit my personal homepage: [walter-a-jablonowski.github.io](https://walter-a-jablonowski.github.io)


## Usage

```
composer require walter-a-jablonowski/super-yaml
```

### Include

```yaml
ANY_KEY:                   "@file([REPLACE_STRING]sub/sub/fil.yml)"
"@include UNIQUE_STRING":  "@file( [REPLACE_STRING]sub/sub/fil.yml )"  # also includes key(s)
```

- **UNIQUE_STRING**    = a user defined unique string in case you are using the same key again (yml needs unique keys)
- **[REPLACE_STRING]** = a string that will be replaced as defined in $rpl argument

See `demo/demo.php`: one yml file includes 2 yml-files, result:

![scr.jpg](misc/scr.jpg?raw=true "Scr")


### Include conditionally

```yaml
"@includeIf(boolVar) UNIQUE_STRING:"    ANY_VALUE
"@includeIf( boolVar ) UNIQUE_STRING":  "@file( [REPLACE_STRING]sub/sub/fil.yml )"
```

```php
SuperYaml::parse( $yml, $args = [
  'rpl'     => [ ],
  'boolVar' => [

  ],
  'flags' =>
]);

SuperYaml::parseFile( $yml, $args = [
  'rpl'     => [ ],
  'boolVar' => [

  ],
  'flags' =>
]);

SuperYaml::dump( $yml, $args = [
  'inline' =>
  'indent' =>
  'flags'  =>
]);
```


## LICENSE

Copyright (C) Walter A. Jablonowski 2018-2020, MIT [License](LICENSE)

Licenses of third party software see [credits](credits.md)


[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)


## Changelog

* [x] **2020** - Added readme, publication
* [x] **2019** - Added class, improved code
* [x] **2018** - Initial development
