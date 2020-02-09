Console Zoo For Laravel
================

The purpose of this laravel package is to easily make console outputs less boring, and to be able to quickly style the content at any time. 
Plus a couple more helpers like [time and duration](#Timestamps-and-Duration) outputs. 

Methods with typical [predefined formats](#Defaults-And-Config) are included: `success`, `info`, `warning`, `error`. 



Even though it's called **`Zoo`**, it's not limited to animal icons only :grin:

<br>

[<img src="https://images2.imgbox.com/c0/4d/7Z3gDCKz_o.png" alt="Colors">](#Changing-Colors)

<br>

* [Installation](#Installation)
* [Display All Options](#Display-All-Options)
* [Available Parameters](#Available-Parameters)
* [Basic Usage](#Basic-Usage)
* [Defaults and Config](#Defaults-And-Config)
* [Timestamps and Duration](#Timestamps-and-Duration)
* [Colors](#Changing-Colors)
* [Icons](#Using-Icons)
* [Inline Use](#Inline-Usage)

<br>


[<img src="https://images2.imgbox.com/83/ea/CLAfqwTw_o.png" alt="Icons">](#Using-Icons)

[<img src="https://images2.imgbox.com/29/1c/v2TS3mo7_o.png" alt="Defaults">](#Defaults-And-Config)

[<img src="https://images2.imgbox.com/c2/1b/zgEwL1Ye_o.png" alt="Duration">](#Timestamps-and-Duration)

[<img src="https://images2.imgbox.com/7b/cf/OVDRFxQM_o.png" alt="Inline">](#Inline-Usage)

--------------------
<br>

## Installation
 
**`composer require deerdama/console-zoo-laravel`**

<br>

:grey_exclamation: **Laravel versions**: There shouldn't be any issues on >= 5.0 (tested on a bunch of versions from 5.0 up to 6.X and everything worked normally on all of those)

* Just keep in mind that on versions **older than 5.5**: the service providers need to be registered manually, so you'll need to add the `Deerdama\ConsoleZoo\ConsoleZooServiceProvider` into your `config/app.php` providers

* And in case someone wants to try this on **4.2**... the basic output methods `zoo()` and `surprise()` actually work, but forget about registering the service provider, using the preview command or using the default methods like `zooSuccess()` 
  
  
:exclamation: If you'll want to change some default parameters then you'll need to publish the config file:

`php artisan vendor:publish --provider=Deerdama\\ConsoleZoo\\ConsoleZooServiceProvider`

-------------------
<br>


## Display All Options

To see all the **available colors and icons** and to check how they'll look in your console you can run the artisan command **`php artisan zoo:options`**

:grey_exclamation: Keep in mind that the icons/colors might not look exactly the same as the screenshots, and some might not even work for you, this depends on the console used (plus some other circumstances) and can't be controlled by the package itself.
If you want to know more about the behind the scenes reason, and about the limitations, then you can find some info for example [here](https://en.wikipedia.org/wiki/ANSI_escape_code)... or just google it

----------------------------
<br>


## Available Parameters

All parameters are optional.

| Name | Description | Type |
| --- | --- | --- |
| color [**](#Changing-Colors) | text color | string &#124; int &#124; array |
| background [**](#Changing-Colors) | background color | string &#124; int &#124; array |
| icons  [**](#Using-Icons) | icon/s to display | string &#124; array &#124; bool |
| timestamp [**](#Timestamps) | adds timestamp in front of the output | bool |
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
| tz | available for the timestamp(); [**](#Timestamps and Duration) | string |
| format | available for the timestamp() and duration() [**](#Timestamps and Duration) | string |

--------------------
<br>


## Basic Usage

* Once installed you can use the package in any artisan command by including the ConsoleZoo trait, eg:: 
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
        'color' => 'light_blue_bright_2',
        'icons' => ['turtle'],
        'bold',
        'italic',
    ]);
```

<p>
  <img src="https://images2.imgbox.com/18/08/ZTpz3r98_o.png" alt="Result">
</p>


<br>

* **Other general methods** can be found in the [Defaults](#Defaults-And-Config) section. Plus the [Inline usage](#inline-usage) section contains details about how to apply multiple styles within one message and add icons anywhere

* **Empty Line**: to add some line breaks you can use `$this->br();`, this will simply output one empty line, if you want a bigger gap, you can just pass the number of lines you want, eg. `$this->br(4);`

* **Surprise** If you want to keep it random then you can use `$this->surprise($messageString, $optionalParam)`
    * The icons will be always random, but they can be limited to a certain `category`.
    * Available categories: _animals, nature, emoticons, food, transport, others_
    * All other parameters are allowed, default parameters will be used if none are passed
    * Text color will be random if none is set as default nor explicitly passed, eg:
    
```php
    $this->surprise("message", [
        'category' => 'animals'
    ]);
```     

------------------
<br>

## Defaults And Config

* There are some **default message types** with pre-defined formats, that can be changed in the config or overwritten by passing parameters.
    * `$this->zooInfo($message, $optionalParam);`
    * `$this->zooSuccess($message, $optionalParam);`
    * `$this->zooWarning($message);`
    * `$this->zooError($message);`
    
    <p>
      <img src="https://images2.imgbox.com/29/1c/v2TS3mo7_o.png" alt="examples">
    </p>       
    
* **Configuring** the default messages: you can change the above default formats through the config file:
    * The config file needs to be [published](#Installation)!
    * Then just change/add the parameters however you want in the `config\zoo.php`

<br>

* **One time** defaults: if you want to setup a default style for the current command, then you can setup the defaults through `$this->zooSetDefaults($parameters)` at the beginning of your command without having to pass the same parameters with every output.
    * These defaults won't affect the pre-defined methods like `info`, `error` etc.., it will affect the main `$this->zoo()` and the `$this->surprise()` methods only!! (Won't affect the icon of the latter).
    * Passing a parameter later on in a specific output **will overwrite** the default for that specific output. Example:

```php
    $this->zooSetDefaults([
        'color' => 'cyan',
        'icons' => 'wolf',
        'bold'
    ]);

    // And then..
    $this->zoo("Meh, I'm just default..");

```
<p>
  <img src="https://images2.imgbox.com/5a/df/Z6kifMOx_o.png" alt="Result">
</p>

* Whatever parameter you explicitly pass later on will overwrite the default. To overwrite default parameters that don't have a value, you can just add a `no_` in front of them. For example `underline` and `bold` can be cancelled with `no_underline`, `no_bold`.

```php
    $this->zoo("I'm the chosen one!!", [
        'icons' => 'pig_face',
        'swap',
        'italic'
    ]);
```
<p>
  <img src="https://images2.imgbox.com/ac/70/sph4yzun_o.png" alt="Result">
</p>


* If you don't want any icons at all in an output that has them as default then you can just pass (or set it in the config) `['icons' => false]`, eg: 

```php
    $this->zooError("You are kind of boring..", [
        'icons' => false
    ]);
```
<p>
  <img src="https://images2.imgbox.com/9f/90/dc04VhqE_o.png" alt="Result">
</p>


------------------------------
<br>

## Timestamps and Duration

* A **timestamp** can be added in front of each output by either passing the **`timestamp`** parameter,
 
 ```php
    $this->zooInfo("How about some sleep??", [
        'timestamp' => true
    ]);
```

<p>
    <img src="https://images2.imgbox.com/bd/82/Pkq0UyTm_o.png"/></img>
</p>


or it can be setup as default by changing the `'timestamp' => false` to `true` in the published config `zoo.php`.

* In the config's `time` array you can also change the default timezone and the timestamp's format plus its output style


* To just output the **current time** only, there is the **`time()`** function which accepts extra parameters to overwrite the defaults, couple of examples..

```php
    $this->time();
    $this->br();
    $this->time(['format' => 'H:i:s T', 'color' => 'blue']);
    $this->br();
    $this->time([
        'tz' => 'pst',
        'format' => 'jS \o\f F, Y H:i:s',
        'icons' => 'alarm_clock',
        'color' => 'green_bright_3'
    ]);
```

<p>
<img src="https://images2.imgbox.com/01/bd/vxyw1FyC_o.png"/>
</p>

* **Duration**: you can get the current duration with **`$this->duration();`**, but you need to start the timer first! to set the starting time call **`$this->start();`**.
The duration has a default format and style that can be changed in the config or passed as parameter in `$this->duration($param)`, eg: 

```php
    $this->duration();

    $this->duration([
        'format' => 'Total duration %s.%f seconds',
        'color' => 'pink_bright_2',
        'icons' => 'snail'
    ]);
    
    $this->duration([
        'timestamp' => true,
        'format' => '%i min and %s sec',
        'icons' => false
    ]);
```

<p>
<img src="https://images2.imgbox.com/9a/2f/tsAKhC2X_o.png"/>
</p>

* To format the duration use the [DateInterval](https://www.php.net/manual/en/dateinterval.format.php) formatting
------------------
<br>
 
## Changing Colors


Text and background colors can be changed through the `color` and `background` parameters.

There are multiple predefined colors that can be displayed through the [artisan command](#Display-All-Options). There are all the basic colors and each of them has few lighter/darker/bright options. 
For example `blue` also has `blue_light_1`, `blue_dark_2`, `blue_bright_2` etc... 
Most colors fo up to `xxx_light_4`, `xxx_dark_4` and `xxx_bright_3` 

The colors can be passed in multiple ways:

1. **string** - name of the color: `['color' => 'red', 'background' => 'blue_dark_1']`
2. **array** - Use array to pass any color as rgb: `['color' => [255, 0, 0], 'background' => [0, 0, 255]]`
3. **integer** - You can pass the [ANSI color codes](https://en.wikipedia.org/wiki/ANSI_escape_code#Colors) directly as int: `['color' => 1, 'background' => 4]`
4. **mix** - If you want to take advantage of your IDE then you can always use the defined constants in `\Deerdama\ConsoleZoo\Color` directly `['color' => Color::RED, 'background' => Color::BLUE]`

* Check the [Inline usage](#inline-usage) section for details about how to change colors only to some part of the text

[Use the artisan command to see all the predefined colors...](#Display-All-Options)

<p>
   <img src="https://images2.imgbox.com/a8/ef/AxQDc4p3_o.png" alt="colors" height="670px">
</p>
and so on....

----------------
<br>


## Using Icons

* To display some icon in front of your message you can pass the `icons` parameter as string or array for multiple icons
```php
    $this->zoo("We want nuts...", [
        'color' => 'teal_light_1',
        'icons' => ['squirrel', 'squirrel', 'squirrel'],
        'bold',
    ]);
```

<p>
  <img src="https://images2.imgbox.com/83/ea/CLAfqwTw_o.png" alt="Result">
</p>


* As with the colors, you can use the `\Deerdama\ConsoleZoo\Icon` class constants directly eg: `['icons' => Icon::SQUIRREL]`
* If you want to use an icon that is not available, you can always pass the raw `utf-8` code of whatever icon you need, eg `['icons' => "\xF0\x9F\x90\xBF\xEF\xB8\x8F"]`  <sub><sup>(Still a squirrel)</sup></sub>. The raw utf-8 icon **must be** inside **double quotes**
* Check the [Inline usage](#inline-usage) section for details about adding icons anywhere inside the text

There are over 700 predefined icons, [Use the artisan command to display all the available icons...](#Display-All-Options) (_Tip: You can filter by category if you choose the option to show "icons" only_)

<p>
<img src="https://images2.imgbox.com/08/4a/eS1kJvh4_o.png" height="670px">
</p>

and so on...



------------------
<br>


## Inline usage

* **Inline Style**:  To modify just just part of the text you can pass inline attributes within the `<zoo {PARAMETERS}></zoo>` tag
    * Parameters requiring a value (color/background) **must have the value within quotes** (doesn't matter if single or double)
    * Other parameters should be unquoted and separated by a space 
    

```php
    $this->zoo("Main style <zoo color='magenta' italic>inline style</zoo>, main again <zoo swap bold> 2nd inline </zoo>... 
                <zoo color='pink_bright_2' underline bold>it's not rocket science..</zoo> ", [
        'icons' => ['baby_chick'],
        'color' => 'blue'
    ]);
```

<p>
  <img src="https://images2.imgbox.com/7b/cf/OVDRFxQM_o.png" alt="Result">
</p>



* **Inline Icons**: To add icons inside the text you can use the `<icon>{icon}</icon>` tag.
    * Each tag can contain ONLY ONE icon
    * The message can contain multiple icon tags
    
```php
    $this->zoo("I'm actually a fluffy <icon>unicorn</icon>, really!!! <icon>face_with_sunglasses</icon>", [
        'color' => 'pink_bright_2',
        'icons' => ['horse'],
        'bold'
    ]);
```

<p>
  <img src="https://images2.imgbox.com/2d/14/g6AZ0ZND_o.png" alt="Result">
</p>
    



