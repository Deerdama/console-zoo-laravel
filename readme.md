Console Zoo
================
Laravel package to easily add some styling and icons to console outputs. 
Even though it's called `Zoo`, it's not limited to animal icons only :grin:

* [Installation](#Installation)
* [Available Parameters](#Available-Parameters)
* [Basic Usage](#Basic-Usage)
* [Defaults and Config](#Defaults-And-Config)
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

:exclamation: If you'll want to change some default parameters then you'll need to publish the config file:

`php artisan vendor:publish --provider=Deerdama\\ConsoleZoo\\ConsoleZooServiceProvider`

<br>

* Extra steps for older Laravel versions: To use the [artisan command](#Display-All-Options) to preview all the predefined colors and icons, then you'll need to register it manually (_I think it was for laravel under 5.5_).

    Add the service provider `Deerdama\ConsoleZoo\ConsoleZooServiceProvider` into your `config/app.php` providers 

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
    use \Deerdama\ConsoleZoo\ConsoleZoo;

    //etc.......
}
```

* You can pass the message and the parameters to all output methods. The second argument`$parameters` has to be an array, but it's always optional, you can skip it completely if you want to.
Check the [Available parameters](#available-parameters) section for more details.

* **The main** flexible output method that you can use for any message is `$this->zoo($messageString, $parameters)`, eg:
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

* **Other general methods** can be found in the [Defaults](#Defaults-And-Config) section. Plus the [Inline usage](#inline-usage) section contains details about how to apply multiple styles within one message and add icons anywhere

* **Surprise** If you want to keep it random then you can use `$this->surprise($messageString, $optionalParam)`
    * The icons will be always random, but they can be limited to a certain `category`.
    * Available categories: _animals, nature, emoticons, food, transport, others_
    * All other parameters are allowed, default parameters will be used if none are passed
    * Text color will be random if none is set as default nor explicitly passed
    
```php
    $this->surprise("message", [
        'category' => 'animals'
    ]);
```     

------------------
<br>

## Defaults And Config

* There are some **default message types** with pre-defined formats, that can be changed or overwritten by passing parameters.
    * `$this->zooInfo($message, $optionalParam);`
    * `$this->zooSuccess($message, $optionalParam);`
    * `$this->zooWarning($message);`
    * `$this->zooError($message);`
    
    <p>
      <img src="https://images2.imgbox.com/fc/22/7vOT8EzZ_o.png" 
      width="250" alt="Result">
    </p>
    
* **Configuring** the default messages: you can change the above default formats through the config file:
    * The config file needs to be [published](#Installation)!
    * You'll find the file in your main `config\zoo.php` 
    * Then just change/add the parameters however you want


* **One time** defaults: if you want to setup a default style for the current command, then you can setup the defaults through `$this->zooSetDefaults($parameters)` at the beginning of your command without having to pass the same parameters with every output.
    * These defaults won't affect the pre-defined methods like `info`, `error` etc.., it will affect the main `$this->zoo()` and the `$this->surprise()` methods only!! (Won't affect the icon of the latter).
    * Passing a parameter later on in a specific output **will overwrite** the default for that specific output. Example:

```php
    $this->zooSetDefaults([
        'color' => 'blue',
        'bold'
    ]);

    // And then..
    $this->zoo("Meh, I'm just default..");

```
<p>
  <img src="https://images2.imgbox.com/f7/53/qlwHB8WW_o.png" 
  width="275" alt="Result">
</p>
   

* Whatever parameter you explicitly pass later on will overwrite the default. To overwrite default parameters that don't have a value, you can just add a `no_` in front of them. For example `underline` and `bold` can be cancelled with `no_underline`, `no_bold`.

```php
    $this->zoo("I'm the chosen one!!", [
        'icons' => 'pig_face',
        'swap',
        'no_bold'
    ]);
```
<p>
  <img src="https://images2.imgbox.com/5f/0f/IlhxEUrm_o.png" 
  width="255" alt="Result">
</p>


------------------
<br>
 
## Changing Colors


Text and background colors can be changed through the `color` and `background` parameters.

The colors can be passed in multiple ways:

1. **string** - name of the color: `['color' => 'red', 'background' => ' dark blue']`
2. **array** - Use array to pass any color as rgb: `['color' => [255, 0, 0], 'background' => [0, 0, 255]]`
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
* If you want to use an icon that is not available, you can always pass the raw `utf-8` code of whatever icon you need, eg `['icons' => "\xF0\x9F\x90\xBF\xEF\xB8\x8F"]`  <sub><sup>(Still a squirrel)</sup></sub>. The raw utf-8 icon **must be** inside **double quotes**
* Check the [Inline usage](#inline-usage) section for details about adding icons anywhere inside the text


[Use the artisan command to display all the available icons...](#Display-Options) (_Tip: You can filter by category if you choose the option to show "icons" only_)

------------------
<br>


### Inline usage

* **Inline Style**:  To modify just just part of the text you can pass inline attributes within the `<zoo {PARAMETERS}></zoo>` tag
    * Parameters requiring a value (color/background) **must have the value within quotes** (doesn't matter is single or double)
    * Other parameters should be unquoted and separated by a space 
    
 ```php
    $this->zoo("Main style <zoo color='dark magenta' italic>inline style</zoo>, main again <zoo swap> 2nd inline </zoo>, the end", [
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
  width="425" alt="Result">
</p>
    



