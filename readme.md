Console Zoo
================
Laravel package to add some styling and icons to console outputs. 
Even though it's called `Zoo`, it's not limited to animal icons only :grin:

* [Installation](#Installation)
* [Available Parameters](#Available-Parameters)
* [Basic Usage](#Basic-Usage)
* [Colors](#Changing-Colors)
* [Icons](#Using-Icons)
* [Inline Use](#Inline-Usage)

<br>

#### Display All Options

To see all the available icons/colors and to check how they'll look in your console you can run the artisan command `php artisan zoo:available-options`

:exclamation: Keep in mind that the icons/colors might not look exactly the same as the screenshots, and some might not even work for you, this depends on the console used (plus some other circumstances) and can't be controlled by the package itself.
If you want to know more about the behind the scenes reason, and about the limitations, then you can find some info on [this wikipedia page](https://en.wikipedia.org/wiki/ANSI_escape_code)... or just google it


--------------------
<br>

## Installation
 
`composer.....`

<br>

:grey_exclamation: Extra steps for older Laravel versions: If you want to take advantage of the artisan command to preview all the predefined colors and icons, then you'll need to register it manually (_I think it was for laravel under 5.5_).
* Add the service provider `Deerdama\ConsoleZoo\ConsoleZooServiceProvider` into your `config/app.php` providers 
* `php artisan vendor:publish`

-------------------
<br>


## Available Parameters

All parameters are optional.

| Name | Description | Type |
| --- | --- | --- |
| color [**](#Changing-Colors) | text color | string &#124; int &#124; array |
| background [**](#Changing-Colors) | background color | string &#124; int &#124; array |
| icons  [**](#Using-Icons) | icon/s to display | string &#124; array |
| bold | increase text intensity |
| faint | decrease text intensity |
| italic | apply italic style to text 
| underline | underline text |
| underline_double | double underline text |
| crossed | cross out the text |
| overline | add overline to text |
| blink | blink outputted text |
| swap | swap the text and background colors |
| category | this is for the random icon only | string |

--------------------
<br>


## Basic Usage

* Once installed you can use the package in any command by including the ConsoleZoo trait: 
```php
class TestZoo extends Command
{
    use ConsoleZoo;

    //etc.......
}
```

* You can pass the message and the parameters too all output methods. The second argument`$parameters` has to be an array, but it's always optional, you can skip it completely if you want to.
Check the [Available parameters](#available-parameters) section for more details.

* Main flexible output method to use `$this->zoo($messageString, $parameters)`, eg:
```php
    $this->zoo("Let's take it slow...", [
        'color' => 'blue',
        'icons' => ['turtle'],
        'bold',
        'italic',
    ]);
```

<p>
  <img src="https://images2.imgbox.com/fb/cb/Z7w7woLb_o.png" 
  width="273" alt="Result">
</p>

<br>


* Default values: you can setup the default style at the beginning of your command without having to pass the parameters with every output. 
Passing a parameter later on in a specific output **will overwrite** the default for that specific output. Example:

```php
    $this->zooSetDefaults([
        'color' => 'blue',
        'bold'
    ]);
```

To overwrite default style parameters that don't have a value, you can just add a `no_` in front of them. For example `underline` and `bold` can be cancelled with `no_underline`, `no_bold`

* There are other typical output methods that already have a predefined format that can be overwritten by passing parameters.
    * `$this->zooInfo($message, $optionalParam);`
    * `$this->zooSuccess($message, $optionalParam);`
    * `$this->zooWarning($message);`
    * `$this->zooError($message);`
    
    <p>
      <img src="https://images2.imgbox.com/fc/22/7vOT8EzZ_o.png" 
      width="250" alt="Result">
    </p>


* **Surprise** If you want to keep it random then you can use `$this->surprise($messageString, $optionalParam)`
    * The icons will be random, but they can be limited to a certain `category`.
    * Available categories: animals, nature, emoticons, food, transport, others
    * All other parameters are allowed, default parameters will be used if none are passed
    
```php
        $this->surprise("message", [
            'color' => 'magenta',
            'category' => 'animals'
        ]);
```       

* Check the [Inline usage](#inline-usage) section for details about how to apply multiple styles within one message and add icons anywhere

------------------
<br>

## Changing Colors

Text and background colors can be changed through the `color` and `background` parameters.

The colors can be passed in multiple ways:

1. **string** - name of the color: `['color' => 'red', 'background' => 'blue']`
2. **array** - Use array to pass a color as rgb: `['color' => [255, 0, 0], 'background' => [0, 0, 255]]`
3. **integer** - You can pass the [ANSI color codes](https://en.wikipedia.org/wiki/ANSI_escape_code#Colors) directly as int: `['color' => 1, 'background' => 4]`
4. **mix** - If you want to take advantage of your IDE then you can always use the defined constants in *Zoo.php* directly `['color' => Zoo::RED_COLOR, 'background' => Zoo::BLUE_COLOR]`

* Check the [Inline usage](#inline-usage) section for details about how to change colors only to some part of the text

[Use the artisan command to preview the predefined colors...](#Display-Options)

----------------
<br>


## Using Icons

* To display some icon in front of your message you can pass the `icons` parameter as string or array for multiple icons
```php
    $this->zoo("We want nuts...", [
        'color' => 'magenta',
        'icons' => ['squirrel', 'squirrel', 'squirrel'],
        'bold',
        'italic',
    ]);
```

<p>
  <img src="https://images2.imgbox.com/e2/40/baebhNrw_o.png" 
  width="260" alt="Result">
</p>

* As with the colors, you can use the `Zoo` class constants directly eg: `['icons' => Zoo::SQUIRREL]`
* If you want to use an icon that is not available, you can always pass the raw `utf-8` code of whatever icon you need, eg `['icons' => "\xF0\x9F\x90\xBF\xEF\xB8\x8F"]`  <sub><sup>(Still a squirrel)</sup></sub>
* Check the [Inline usage](#inline-usage) section for details about adding icons anywhere inside the text




[Use the artisan command to display all the available icons...](#Display-Options) (_Tip: You can filter by category if you choose the option to show "icons" only_)

------------------
<br>


### Inline usage

* **Inline Style**:  To modify just just part of the text you can pass inline attributes within the `<zoo {PARAMETERS}></zoo>` tag
    * Parameters requiring a value (color/background) must have the value within double quotes
    * Other parameters should be unquoted and separated by a space 
    
 ```php
    $this->zoo('Main style <zoo color="dark magenta" italic>inline style</zoo>, main again <zoo swap> 2nd inline </zoo>, the end', [
        'icons' => ['mouse'],
        'color' => 'blue',
        'bold'
    ]);
```
<p>
  <img src="https://images2.imgbox.com/c8/3a/reYkuz1S_o.png" 
  width="575" alt="Result">
</p>

* **Inline Icons**: To add icons inside the text you can use the `<icon>{icon}}</icon>` tag.
    * Each tag can contain ONLY ONE icon
    * The message can contain multiple icon tags
    
```php
    $this->zoo(" I'm actually a fluffy <icon>unicorn</icon>, really!!! <icon>face_with_sunglasses</icon>", [
        'color' => 'purple',
        'icons' => ['horse'],
        'bold'
    ]);
```

<p>
  <img src="https://images2.imgbox.com/39/c5/bDzNwrmA_o.png" 
  width="420" alt="Result">
</p>
    



