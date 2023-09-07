![](https://img.shields.io/github/release/php-enspired/zorro.svg)  ![](https://img.shields.io/badge/PHP-8.1-blue.svg?colorB=8892BF)  ![](https://img.shields.io/badge/license-GPL_3.0_only-blue.svg)

[bit]masked enums!
=============

_zorro_ provides utilities and components for building and managing object-oriented bitmasks.

dependencies
------------

Requires php 8.1 or later.

installation
------------

Recommended installation method is via [Composer](https://getcomposer.org/): simply `composer install php-enspired/zorro`

a quick taste
-------------
```php
<?php

use at\zorro\IsBitmask;

enum Option : int {
  use IsBitmask;

  case FOO = 1;
  case BAR = 1<<1;
  case BAZ = 1<<2;
}

$opts = Option::buildFrom(Option::FOO, Option::BAZ);
echo "option 'FOO' is ", Option::FOO->in($opts) ? "enabled" : "disabled", " in \$opts\n";
echo "option 'BAR' is ", Option::BAR->in($opts) ? "enabled" : "disabled", " in \$opts\n";
echo "option 'BAZ' is ", Option::BAZ->in($opts) ? "enabled" : "disabled", " in \$opts\n";

$opts = Option::BAR->on($opts);
$opts = Option::BAZ->off($opts);
echo "option 'FOO' is ", Option::FOO->in($opts) ? "enabled" : "disabled", " in \$opts\n";
echo "option 'BAR' is ", Option::BAR->in($opts) ? "enabled" : "disabled", " in \$opts\n";
echo "option 'BAZ' is ", Option::BAZ->in($opts) ? "enabled" : "disabled", " in \$opts\n";
```

docs
----

…coming soon

tests
-----

- run unit tests with `composer test:unit`
- run static analysis with `composer test:analyze`

contributing or getting help
----------------------------

I'm [on IRC at `libera#php-enspired`](https://web.libera.chat/#php-enspired), or open an issue [on github](https://github.com/php-enspired/zorry/issues).  Feedback is welcomed as well.
