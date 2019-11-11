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
    const NO_BOLD = 22;
    const FAINT = 2;
    const NO_FAINT = 22;
    const ITALIC = 3;
    const NO_ITALIC = 23;
    const BLINK = 5;
    const NO_BLINK = 25;
    const SWAP = 7; //swap font and background colors
    const NO_SWAP = 27;
    const UNDERLINE = 4;
    const NO_UNDERLINE = 24;
    const DOUBLE_UNDERLINE = 21;
    const NO_DOUBLE_UNDERLINE = 24;
    const OVERLINE = 53;
    const NO_OVERLINE = 55;
    const CROSSED = 9;
    const NO_CROSSED = 29;
}