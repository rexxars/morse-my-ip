# morse-my-ip

Ever wondered what your current IP-address sounds like in morse code?

## Dependencies

* PHP >= 5.4
* Node.js (for building client-side bundle)
* Apache with mod_rewrite

## Setup

* Clone the project
* Either run `./build.sh`, or manually:
  * Run `composer install` (see [composer docs](https://getcomposer.org/doc/00-intro.md))
  * Run `npm install`
  * Run `npm run build`
* Symlink the `public` folder to somewhere within your document root
* Ensure that `mod_rewrite` is enabled for the document root and that `.htaccess` files can be read (eg, `AllowOverride all`)
* Done? Done.

## License

MIT-licensed. See LICENSE.

## Why?

I don't know. I thought it would be fun.
