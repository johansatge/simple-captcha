![Captcha](logo.gif)

A dead simple PHP captcha.

---

* [Disclaimer](#disclaimer)
* [Installation](#installation)
* [Usage](#usage)
* [Changelog](#changelog)
* [License](#license)
* [Credits](#credits)

## Disclaimer

This captcha should be considered as a *proof of concept*, and a simple demo of image generation in PHP.

It should not be used on production environments, as it can be easily defeated by captcha solvers or [OCR](https://en.wikipedia.org/wiki/Optical_character_recognition) softwares.

## Installation

* Enable [PHP GD](http://php.net/manual/en/book.image.php)
* Get [`captcha.php`](captcha.php)

## Usage

Call the script in a `<img>` tag in a form:

```php
<img src="/path/to/captcha.php?rand=<?php echo md5(microtime(true)); ?>">
```

The image goes with an `<input>`:

```html
<input type="text" name="captcha_value">
```

On form submit, check the entered value:

```php
if (!empty($_SESSION['simple_captcha']) && !empty($_POST['captcha_value']) && $_SESSION['simple_captcha'] == $_POST['captcha_value'])
{
  // The captcha is valid
}
```

## Changelog

| Version | Date | Notes |
| --- | --- | --- |
| `1.0.0` | August 29, 2015 | Initial version |

## License

This project is released under the [MIT License](license).

## Credits

* [Open Sans](http://www.fontsquirrel.com/fonts/open-sans)
* [Amble](http://www.fontsquirrel.com/fonts/amble)
* [Cantarell](http://www.fontsquirrel.com/fonts/cantarell)
