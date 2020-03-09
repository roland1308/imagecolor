<?php

        // Test File
        // ---------------------------------------------

            // Note: This file was just a picture of a 5x5 red square
            //    inside of a gigantic 521x512 black square, and
            //    then I did a bunch of random, yellow zigzags.

    $file_to_grab_with_location = "C:\Users\Renato\Desktop\ELJ\imagecolor\public\images/1583662675.png";

    $imagick_type = new Imagick();
           
        // Open File
        // ---------------------------------------------
                   
    $file_handle_for_viewing_image_file = fopen($file_to_grab_with_location, 'a+');
    $imagick_type->readImageFile($file_handle_for_viewing_image_file);
   
        // Preset Information
        // ---------------------------------------------

    $frequency_list_of_values = array();
   
        // Parse Pixels
        // ---------------------------------------------
       
    $image_resolution_width = $imagick_type->getImageWidth();
    $image_resolution_height = $imagick_type->getImageHeight();
       
    print("Image Resolution:  Width - $image_resolution_width / Height - $image_resolution_height<br><br>");
   
        // Parse Image Top-to-Bottom (Y-Variable)
        // ---------------------------------------------
   
    for($y = 0; $y < $image_resolution_height; $y++)
    {
            // Parse Image Left-to-Right (X-Variable)
            // ---------------------------------------------
       
        for($x = 0; $x < $image_resolution_width; $x++)
        {
       
                // Image Pixel Color
                // ---------------------------------------------
       
            $pixel_to_examine = $imagick_type->getImagePixelColor($x,$y);
           
            $pixel_to_examine_color_value_red = $pixel_to_examine->getColorValue(imagick::COLOR_RED);
            $pixel_to_examine_color_value_green = $pixel_to_examine->getColorValue(imagick::COLOR_GREEN);
            $pixel_to_examine_color_value_blue = $pixel_to_examine->getColorValue(imagick::COLOR_BLUE);

                // Set Key Value
                // ---------------------------------------------
       
            $key_value =    $pixel_to_examine_color_value_red    .    " / "    .
                    $pixel_to_examine_color_value_green    .    " / "    .
                    $pixel_to_examine_color_value_blue            ;
   
                // Increment Array Entry for Color
                // ---------------------------------------------
                   
            if(isset($frequency_list_of_values[$key_value]) == TRUE)
            {
                $temp = $frequency_list_of_values[$key_value];
                $temp++;
                $frequency_list_of_values[$key_value] = $temp;
            }
            else
            {
                $frequency_list_of_values[$key_value] = 1;
            }
        }
    }
               
        // Print Out Array of Values
        // ---------------------------------------------
   
    print("<pre>");
    print_r($frequency_list_of_values);
    print("</pre>");

/*

    Results:
    ------------------

Image Resolution: Width - 521 / Height - 512

Array
(
    [1 / 0 / 0] => 25
    [0 / 0 / 1] => 264107
    [1 / 1 / 0] => 2620
)

*/
