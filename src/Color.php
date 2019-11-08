<?php

namespace Deerdama\ConsoleZoo;

class Color
{
    const BLACK = [0, 0, 0];
    const WHITE = [255, 255, 255];

    const RED_BASIC = [255, 0, 0];
    const GREEN_BASIC = [0, 128, 0];
    const YELLOW_BASIC = [255, 255, 0];
    const BLUE_BASIC = [0, 0, 255];
    const MAGENTA_BASIC = [255, 0, 255];
    const CYAN_BASIC = [0, 255, 255];

    const GREY = [117, 117, 117];
    const GREY_LIGHT_3 = [224, 224, 224];
    const GREY_LIGHT_2 = [189, 189, 189];
    const GREY_LIGHT_1 = [158, 158, 158];
    const GREY_DARK_1 = [97, 97, 97];
    const GREY_DARK_2 = [66, 66, 66];
    const GREY_DARK_3 = [33, 33, 33];

    const BLUE_GREY = [96, 125, 139];
    const BLUE_GREY_LIGHT_4 = [207, 216, 220];
    const BLUE_GREY_LIGHT_3 = [176, 190, 197];
    const BLUE_GREY_LIGHT_2 = [144, 164, 174];
    const BLUE_GREY_LIGHT_1 = [120, 144, 156];
    const BLUE_GREY_DARK_1 = [84, 110, 122];
    const BLUE_GREY_DARK_2 = [69, 90, 100];
    const BLUE_GREY_DARK_3 = [55, 71, 79];
    const BLUE_GREY_DARK_4 = [38, 50, 56];

    const BROWN = [121, 85, 72];
    const BROWN_LIGHT_4 = [215, 204, 200];
    const BROWN_LIGHT_3 = [188, 170, 164];
    const BROWN_LIGHT_2 = [161, 136, 127];
    const BROWN_LIGHT_1 = [141, 110, 99];
    const BROWN_DARK_1 = [109, 76, 65];
    const BROWN_DARK_2 = [93, 64, 55];
    const BROWN_DARK_3 = [78, 52, 46];
    const BROWN_DARK_4 = [62, 39, 35];

    const DEEP_ORANGE = [255, 87, 34];
    const DEEP_ORANGE_LIGHT_4 = [255, 204, 188];
    const DEEP_ORANGE_LIGHT_3 = [255, 171, 145];
    const DEEP_ORANGE_LIGHT_2 = [255, 138, 101];
    const DEEP_ORANGE_LIGHT_1 = [255, 112, 67];
    const DEEP_ORANGE_DARK_1 = [244, 81, 30];
    const DEEP_ORANGE_DARK_2 = [230, 74, 25];
    const DEEP_ORANGE_DARK_3 = [216, 67, 21];
    const DEEP_ORANGE_DARK_4 = [191, 54, 12];
    const DEEP_ORANGE_BRIGHT_1 = [255, 110, 64];
    const DEEP_ORANGE_BRIGHT_2 = [255, 61, 0];
    const DEEP_ORANGE_BRIGHT_3 = [221, 44, 0];

    const ORANGE = [255, 152, 0];
    const ORANGE_LIGHT_4 = [255, 224, 178];
    const ORANGE_LIGHT_3 = [255, 204, 128];
    const ORANGE_LIGHT_2 = [255, 183, 77];
    const ORANGE_LIGHT_1 = [255, 167, 38];
    const RANGE_DARK_1 = [251, 140, 0];
    const ORANGE_DARK_2 = [245, 124, 0];
    const ORANGE_DARK_3 = [239, 108, 0];
    const ORANGE_DARK_4 = [230, 81, 0];
    const ORANGE_BRIGHT_1 = [255, 171, 64];
    const ORANGE_BRIGHT_2 = [255, 145, 0];
    const ORANGE_BRIGHT_3 = [255, 109, 0];

    const YELLOW = [255, 235, 59];
    const YELLOW_LIGHT_4 = [255, 249, 196];
    const YELLOW_LIGHT_3 = [255, 245, 157];
    const YELLOW_LIGHT_2 = [255, 241, 118];
    const YELLOW_LIGHT_1 = [255, 238, 88];
    const YELLOW_DARK_1 = [253, 216, 53];
    const YELLOW_DARK_2 = [251, 192, 45];
    const YELLOW_DARK_3 = [249, 168, 37];
    const YELLOW_DARK_4 = [245, 127, 23];
    const YELLOW_BRIGHT_1 = [255, 255, 0];
    const YELLOW_BRIGHT_2 = [255, 234, 0];
    const YELLOW_BRIGHT_3 = [255, 214, 0];

    const LIME = [205, 220, 57];
    const LIME_LIGHT_4 = [240, 244, 195];
    const LIME_LIGHT_3 = [230, 238, 156];
    const LIME_LIGHT_2 = [220, 231, 117];
    const LIME_LIGHT_1 = [212, 225, 87];
    const LIME_DARK_1 = [192, 202, 51];
    const LIME_DARK_2 = [175, 180, 43];
    const LIME_DARK_3 = [158, 157, 36];
    const LIME_DARK_4 = [130, 119, 23];
    const LIME_BRIGHT_1 = [238, 255, 65];
    const LIME_BRIGHT_2 = [198, 255, 0];
    const LIME_BRIGHT_3 = [174, 234, 0];

    const LIGHT_GREEN = [139, 195, 74];
    const LIGHT_GREEN_LIGHT_4 = [220, 237, 200];
    const LIGHT_GREEN_LIGHT_3 = [197, 225, 165];
    const LIGHT_GREEN_LIGHT_2 = [174, 213, 129];
    const LIGHT_GREEN_LIGHT_1 = [156, 204, 101];
    const LIGHT_GREEN_DARK_1 = [124, 179, 66];
    const LIGHT_GREEN_DARK_2 = [104, 159, 56];
    const LIGHT_GREEN_DARK_3 = [85, 139, 47];
    const LIGHT_GREEN_DARK_4 = [51, 105, 30];
    const LIGHT_GREEN_BRIGHT_1 = [178, 255, 89];
    const LIGHT_GREEN_BRIGHT_2 = [118, 255, 3];
    const LIGHT_GREEN_BRIGHT_3 = [100, 221, 23];

    const GREEN = [0, 155, 0];
//    const GREEN = [48, 160, 67];
//    const GREEN111 = [54, 178, 75];
//    const GREEN_LIGHT_44 = [200, 230, 201];

    const GREEN_LIGHT_4 = [165, 214, 167];
    const GREEN_LIGHT_3 = [129, 199, 132];
    const GREEN_LIGHT_2 = [102, 187, 106];
    const GREEN_LIGHT_1 = [76, 175, 80];
    const GREEN_DARK_1 = [67, 160, 71];
    const GREEN_DARK_2 = [56, 142, 60];
    const GREEN_DARK_3 = [46, 125, 50];
    const GREEN_DARK_4 = [27, 94, 32];
    const GREEN_BRIGHT_1 = [0, 230, 118];
    const GREEN_BRIGHT_2 = [0, 200, 83];
    const GREEN_BRIGHT_3 = [0, 255, 0];

    const TEAL = [0, 150, 136];
    const TEAL_LIGHT_4 = [178, 223, 219];
    const TEAL_LIGHT_3 = [128, 203, 196];
    const TEAL_LIGHT_2 = [77, 182, 172];
    const TEAL_LIGHT_1 = [38, 166, 154];
    const TEAL_DARK_1 = [0, 137, 123];
    const TEAL_DARK_2 = [0, 121, 107];
    const TEAL_DARK_3 = [0, 105, 92];
    const TEAL_DARK_4 = [0, 77, 64];
    const TEAL_BRIGHT_1 = [100, 255, 218];
    const TEAL_BRIGHT_2 = [29, 233, 182];
    const TEAL_BRIGHT_3 = [0, 191, 165];

    const CYAN = [0, 188, 212];
    const CYAN_LIGHT_4 = [178, 235, 242];
    const CYAN_LIGHT_3 = [128, 222, 234];
    const CYAN_LIGHT_2 = [77, 208, 225];
    const CYAN_LIGHT_1 = [38, 198, 218];
    const CYAN_DARK_1 = [0, 172, 193];
    const CYAN_DARK_2 = [0, 151, 167];
    const CYAN_DARK_3 = [0, 131, 143];
    const CYAN_DARK_4 = [0, 96, 100];
    const CYAN_BRIGHT_1 = [24, 255, 255];
    const CYAN_BRIGHT_2 = [0, 229, 255];
    const CYAN_BRIGHT_3 = [0, 184, 212];

    const LIGHT_BLUE = [3, 169, 244];
    const LIGHT_BLUE_LIGHT_4 = [179, 229, 252];
    const LIGHT_BLUE_LIGHT_3 = [129, 212, 250];
    const LIGHT_BLUE_LIGHT_2 = [79, 195, 247];
    const LIGHT_BLUE_LIGHT_1 = [41, 182, 246];
    const LIGHT_BLUE_DARK_1 = [3, 155, 229];
    const LIGHT_BLUE_DARK_2 = [2, 136, 209];
    const LIGHT_BLUE_DARK_3 = [2, 119, 189];
    const LIGHT_BLUE_DARK_4 = [1, 87, 155];
    const LIGHT_BLUE_BRIGHT_1 = [64, 196, 255];
    const LIGHT_BLUE_BRIGHT_2 = [0, 176, 255];
    const LIGHT_BLUE_BRIGHT_3 = [0, 145, 234];

    const BLUE = [33, 150, 243];
    const BLUE_LIGHT_4 = [144, 202, 249];
    const BLUE_LIGHT_3 = [100, 181, 246];
    const BLUE_LIGHT_2 = [33, 150, 243];
    const BLUE_LIGHT_1 = [30, 136, 229];
    const BLUE_DARK_1 = [25, 118, 210];
    const BLUE_DARK_2 = [0, 103, 206];
    const BLUE_DARK_3 = [0, 82, 164];
    const BLUE_DARK_4 = [13, 71, 161];
    const BLUE_BRIGHT_1 = [41, 121, 255];
    const BLUE_BRIGHT_2 = [41, 98, 255];
    const BLUE_BRIGHT_3 = [16, 79, 255];

    const INDIGO = [63, 81, 181];
    const INDIGO_LIGHT_4 = [197, 202, 233];
    const INDIGO_LIGHT_3 = [159, 168, 218];
    const INDIGO_LIGHT_2 = [121, 134, 203];
    const INDIGO_LIGHT_1 = [92, 107, 192];
    const INDIGO_DARK_1 = [57, 73, 171];
    const INDIGO_DARK_2 = [48, 63, 159];
    const INDIGO_DARK_3 = [40, 53, 147];
    const INDIGO_DARK_4 = [26, 35, 126];
    const INDIGO_BRIGHT_1 = [83, 109, 254];
    const INDIGO_BRIGHT_2 = [61, 90, 254];
    const INDIGO_BRIGHT_3 = [48, 79, 254];

    const DEEP_PURPLE = [103, 58, 183];
    const DEEP_PURPLE_LIGHT_4 = [209, 196, 233];
    const DEEP_PURPLE_LIGHT_3 = [179, 157, 219];
    const DEEP_PURPLE_LIGHT_2 = [149, 117, 205];
    const DEEP_PURPLE_LIGHT_1 = [126, 87, 194];
    const DEEP_PURPLE_DARK_1 = [94, 53, 177];
    const DEEP_PURPLE_DARK_2 = [81, 45, 168];
    const DEEP_PURPLE_DARK_3 = [69, 39, 160];
    const DEEP_PURPLE_DARK_4 = [49, 27, 146];
    const DEEP_PURPLE_BRIGHT_1 = [124, 77, 255];
    const DEEP_PURPLE_BRIGHT_2 = [101, 31, 255];
    const DEEP_PURPLE_BRIGHT_3 = [98, 0, 234];

    const PURPLE = [156, 39, 176];
    const PURPLE_LIGHT_4 = [225, 190, 231];
    const PURPLE_LIGHT_3 = [206, 147, 216];
    const PURPLE_LIGHT_2 = [186, 104, 200];
    const PURPLE_LIGHT_1 = [171, 71, 188];
    const PURPLE_DARK_1 = [142, 36, 170];
    const PURPLE_DARK_2 = [123, 31, 162];
    const PURPLE_DARK_3 = [106, 27, 154];
    const PURPLE_DARK_4 = [74, 20, 140];
    const PURPLE_BRIGHT_1 = [224, 64, 251];
    const PURPLE_BRIGHT_2 = [213, 0, 249];
    const PURPLE_BRIGHT_3 = [170, 0, 255];

    const MAGENTA = [255, 0, 255];

    const PINK = [233, 30, 99];
    const PINK_LIGHT_4 = [248, 187, 208];
    const PINK_LIGHT_3 = [244, 143, 177];
    const PINK_LIGHT_2 = [240, 98, 146];
    const PINK_LIGHT_1 = [236, 64, 122];
    const PINK_DARK_1 = [216, 27, 96];
    const PINK_DARK_2 = [194, 24, 91];
    const PINK_DARK_3 = [173, 20, 87];
    const PINK_DARK_4 = [136, 14, 79];
    const PINK_BRIGHT_1 = [255, 64, 129];
    const PINK_BRIGHT_2 = [245, 0, 87];
    const PINK_BRIGHT_3 = [197, 17, 98];

    const RED = [227, 34, 20];
//    const RED11 = [229,57,53];
    const RED_LIGHT_4 = [239, 154, 154];
    const RED_LIGHT_3 = [229, 115, 115];
    const RED_LIGHT_2 = [239, 83, 80];
    const RED_LIGHT_1 = [244, 67, 54];
    const RED_DARK_1 = [229, 57, 53];
    const RED_DARK_2 = [211, 47, 47];
    const RED_DARK_3 = [198, 40, 40];
    const RED_DARK_4 = [183, 28, 28];
    const RED_BRIGHT_1 = [255, 82, 82];
    const RED_BRIGHT_2 = [255, 23, 68];
    const RED_BRIGHT_3 = [213, 0, 0];
}