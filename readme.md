console-zoo
================
Laravel package to add some styling and icons to console messages

1. #####[Installation](#install)
2. #####[Usage](#use)
3. #####[Parameters Available](#param)
4. #####[Using Icons](#icons)
5. #####[Changing Colors](#colors)

<br>

#####[](#command) To see all the available icons and colors you can run the artisan command `php artisan zoo:available-options`


[](#install)Installation
----------------------------------

`composer.....`

<br>

[](#use)Basic Usage
------------------------
* Once installed you can use the package in any command by including the trait: 
```php
class TestZoo extends Command
{
    use ConsoleZoo;

    //etc.......
}
```

* Main method for a general flexible message `$this->zoo($message, $param)`, eg:
```php        
    $this->zoo("I want nuts...", [
        'color' => 'blue',
        'icons' => ['squirrel'],
        'bold',
        'italic',
    ]);
```
![img](https://cnt-05.content-na.drive.amazonaws.com/cdproxy/templink/KoeCb3phq5tKc53VICovTOhwC9zSYbmwHQ2lG9zS-jgpX92IB?viewBox=239%2C51)

<br>

* Default values: you can setup the default style without having to pass the parameters with every output. 
Passing a parameter later on in a specific output **will overwrite** the default for that specific output.

```php
    $this->zooSetDefaults([
        'color' => 'blue',
        'bold'
    ]);
```

To overwrite default style parameters without value like `underline` or `bold`, you can pass `no_underline`, `no_bold`
 
 <br>

[](#param)Parameters Available
----------------------------------
| Name | Description | Type |
| --- | --- | --- |
| color [**](#colors) | text color | string &#124; int &#124; array |
| background [**](#colors) | background color | string &#124; int &#124; array |
| icons  [**](#icons) | icon/s to display | string &#124; array |
| bold | increase text intensity |
| faint | decrease text intensity |
| italic | apply italic style to text 
| underline | underline text |
| underline_double | double underline text |
| crossed | cross out the text |
| overline | add overline to text |
| blink | blink outputted text |
| swap | swap the text and background colors |

<br>

[](#colors)Text/Background color
----

Colors can be changed through the `color` and `background` parameters <sub><sup>(run `php artisan zoo:available-options` to see the pre-defined colors)</sup></sub>

The colors can be passed in multiple ways:

1. **string** - name of the color: `['color' => 'red', 'background' => 'blue']`
2. **array** - Use array to pass a color as rgb: `['color' => [255, 0, 0], 'background' => [0, 0, 255]]`
3. **integer** - You can pass the [ANSI color codes](https://en.wikipedia.org/wiki/ANSI_escape_code#Colors) directly as int: `['color' => 1, 'background' => 4]`
4. **mix** - An alternative is to use the predefined constants in *Zoo.php* `['color' => Zoo::RED_COLOR, 'background' => Zoo::BLUE_COLOR]`

<br>

[](#icons)Using Icons
------------------------------------------
* To display some icon in front of your message you can pass it in the parameters as string or array for multiple icons
```php
    $this->zooOutput("meh...", [
        'icons' => ['turtle', 'dog']
    ]);
```

[](#inline)Inline Styling
------------------------------------------
