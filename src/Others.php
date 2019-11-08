<?php

namespace Deerdama\ConsoleZoo;

class Others
{
    /** styles and effects **/
    const SET_COLOR = "38;5;";
    const SET_COLOR_RGB = "38;2;";
    const SET_BG = "48;5;";
    const SET_BG_RGB = "48;2;";

    const RESET = "\e[0m";
    const BOLD = 1;
    const FAINT = 2;
    const ITALIC = 3;
    const BLINK = 5;
    const SWAP = 7; //swap font and background colors
    const UNDERLINE = 4;
    const DOUBLE_UNDERLINE = 21;
    const OVERLINE = 53;
    const CROSSED = 9;
}