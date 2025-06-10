<?php

/**
 * Class Image Snaphot library resize
 * Last update 29 Dec 2023
 *
 * @package Phaata
 * @copyright Phaata
 * @author contact@panpic.vn
 * @author pos: Panpic's PHP team
 * @since 29 Dec 2023
 */

class Imagesnapshot_lib
{

    public $ImageField;		// should be: $_FILES['imagefield'] array, OR set the next public.
    public $ImageFile;			// location of an image file saved on the server.
    public $ImageContents;		// Contents of an image in a variable.
    public $Compression;		// JPG compression. Default is 75%

    public $Resize;			//either true or false. wether to resize image, if true the uses the next 3 vars
    public $ResizeScale;		//scale to resize the image to. 100 is as small as possible, 0 is effectively no resizing at all.

    public $Position;			//position of the snapshot: random, center (default), topleft, topright, bottomleft, bottomright

    public $Width;      		// width (or max width) of image to output
    public $Height;      		// height (or max height) of image to output

    public $Err;				// error if (and when) they occur

    public $InternalImage;		// Internal variable for working with the image

    public $ReturnedWidth; 	//New in 1.2: this is the actual width of the image returned, will only differ to Width if the original image was smaller.
    public $ReturnedHeight; 	//New in 1.2: this is the actual height of the image returned, will only differ to Height if the original image was smaller.

    public $CustomPositionX; 	//New in 1.3: 0 to 100, this is the percentage of the custom position along the X scale. $Position must be 'custom' for this to apply.
    public $CustomPositionY; 	//New in 1.3: 0 to 100, this is the percentage of the custom position along the Y scale. $Position must be 'custom' for this to apply.


    function ImageUploaded() {
        //set up some defaults
        $this->Width = '800';
        $this->Height = '600';
        $this->Resize = true;
        $this->ResizeScale = 100;
        $this->Position = 'center';
        $this->Err = '';
        $this->Compression = 75;
        $this->InternalImage = '';
        $this->ImageContents = '';
        $this->ReturnedWidth = 0; // New in 1.2
        $this->ReturnedHeight = 0; // New in 1.2
        $this->CustomPositionX = 50; // New in 1.3
        $this->CustomPositionY = 50; // New in 1.3
    }



    function SaveImageAs($destination) {
        //Saves the image to the desination. Returns true if successful, or false with Err specifying the error.
        //example: $myimage->SaveImageAs("/docroot/images/newimage.jpg

        if ( $this->ProcessImage() ) {

            if (!$handle = fopen($destination, 'w')) {
                $this->Err = 'Cannot open file (' . $destination . ')';
                return false;
            } else {
                if (fwrite($handle, $this->InternalImage) === FALSE) {
                    $this->Err = 'Cannot write to file (' . $destination . ')';
                    return false;
                } else {
                    return true;
                }
                fclose($handle);
            }
        } else {
            return false;
        }
    }

    function GetImageContents() {
        // calls process image, and returns the contents for other manipulations of database entry.
        //if ($this->ProcessImage()) {
        return $this->InternalImage;
        //} else {
        //return false;
        //}
    }

    function ProcessImage() {
        //Processes the image. Resize if needed. fills the internal image with the contents of the changed image.
        //Internal function

        if (strlen($this->ImageContents) > 0) {
            //LOAD FROM STRING!
            $tmp_image = @imagecreatefromstring($this->ImageContents);
            //END LOAD FROM STRING

        } elseif (strlen($this->ImageFile) > 0) {
            //LOAD FROM FILE
            //check that file exists
            if (file_exists($this->ImageFile)) {
                //load it!
                $data = getimagesize($this->ImageFile); //[0] = w, [1] = h, [2] = type, [3] = attr
                switch ($data[2]) {
                    case 1:
                        $tmp_image = @imagecreatefromgif($this->ImageFile);
                        break;
                    case 2:
                        $tmp_image = @imagecreatefromjpeg($this->ImageFile);
                        break;
                    case 3:
                        $tmp_image = @imagecreatefrompng($this->ImageFile);
                        break;
                    default:
                        $this->Err = 'File is not a valid image type';
                        return false;
                        exit;
                        break;
                }
            } else {
                $this->Err = 'File "' . $this->ImageFile . '" does not exist!';
                return false;
            }
            //END LOAD FROM FILE

        } elseif (count($this->ImageField) > 0) {
            //LOAD FROM FIELD FILE
            //check that file exists
            if (file_exists($this->ImageField['tmp_name'])) {
                //load it!
                $data = getimagesize($this->ImageField['tmp_name']); //[0] = w, [1] = h, [2] = type, [3] = attr
                switch ($data[2]) {
                    case 1:
                        $tmp_image = @imagecreatefromgif($this->ImageField['tmp_name']);
                        break;
                    case 2:
                        $tmp_image = @imagecreatefromjpeg($this->ImageField['tmp_name']);
                        break;
                    case 3:
                        $tmp_image = @imagecreatefrompng($this->ImageField['tmp_name']);
                        break;
                    default:
                        $this->Err = 'File is not a valid image type';
                        return false;
                        exit;
                        break;
                }
            } else {
                $this->Err = 'File "' . $this->ImageField['tmp_name'] . '" does not exist!';
                return false;
            }
            //END LOAD FROM FILE

        } else {
            $this->Err = 'No image was loaded, use ImageFile, ImageContents or ImageField before output';
            return false;
            exit;
        }

        $image_width = imagesx($tmp_image);
        $image_height = imagesy($tmp_image);

        //check a div by zero error.
        if ($this->Resize == true && $this->ResizeScale == 0) {
            //there is no point resizing, when the scale doesn't change the size anyway.
            $this->Resize = false;
        }


        //check if image is meant to be resized...
        if ($this->Resize == 'true' || $this->Resize == 1) {
            //Yes resize
            if ($image_width > $this->Width && $image_height > $this->Height) {
                //have to resize..
                //get the proportional dimensions, while allowing room for a snapshot, and according to the resizescale
                $w_ratio = $this->Width / ($image_width * ($this->ResizeScale / 100));		//width ratio.. ie: 0.1 = 80 / 800
                $h_ratio = $this->Height / ($image_height * ($this->ResizeScale / 100));	//height ratio. ie: 0.075 = 60 / 800
                $maxwidth = $this->Width;	//maxwidth is the max width of the final snapshot
                $maxheight = $this->Height;	//maxheight is the max height of the final snapshot
                if ($w_ratio < $h_ratio) {
                    $maxheight = ceil($image_height * $h_ratio);
                    $maxwidth = ceil($image_width * $h_ratio);
                } else {
                    $maxwidth = ceil($image_width * $w_ratio);
                    $maxheight = ceil($image_height * $w_ratio);
                }

                //now we either have a correctly sized image (compared to the thumb) or an oversized image, that has been shrink and waiting to be snaopshot'd

                $final_width = $maxwidth;
                $final_height = $maxheight;
                //end maintain aspect

                //$new_photo = imagecreatetruecolor($final_width,$final_height);
                imagecopyresampled($tmp_image, $tmp_image,0,0,0,0, $final_width, $final_height, $image_width, $image_height);

                $image_width = $final_width;
                $image_height = $final_height;

                //$tmp_image = $new_photo;
                //imagedestroy($new_photo);


            }

            // end resize
        }

        //SNAPSHOT! CHA_CHING!
        //at this stage, $tmp_image should contain the image ready for snapshot. No drama.

        if ($image_width < $this->Width) {
            $this->Width = $image_width;
        }
        if ($image_height < $this->Height) {
            $this->Height = $image_height;
        }
        $new_photo = imagecreatetruecolor($this->Width,$this->Height);

        $this->ReturnedWidth = $this->Width;
        $this->ReturnedHeight = $this->Height;

        //currently, the dimensions of our temp image are:<br />
        //	$image_width
        //	$image_height
        $source_y = 0;
        $source_x = 0;
        //we shall compare the snapshot dimensions to the image dimensions
        switch ($this->Position) {
            case 'random':
                //my favourite, random place on the image.
                if ($image_height > $this->Height) {
                    // height is larger.
                    //get the min and max room to play with
                    $min = 0;
                    $max = $image_height - $this->Height;
                    $source_y = rand($min,$max);
                }
                if ($image_width > $this->Width) {
                    // width is larger.
                    $min = 0;
                    $max = $image_width - $this->Width;
                    $source_x = rand($min,$max);
                }
                break;

            case 'topright':
                //topright of the image
                $source_y = 0;
                if ($image_width > $this->Width) {
                    // width is larger.
                    $source_x = $image_width - $this->Width;
                }
                break;

            case 'topleft':
                //topleft of the image
                $source_y = 0;
                $source_x = 0;
                break;

            case 'topcenter':
                //topleft of the image
                $source_y = 0;
                if ($image_width > $this->Width) {
                    // width is larger.
                    $source_x = (($image_width - $this->Width) / 2);
                }
                break;

            case 'bottomright':
                //bottomright of the image
                if ($image_height > $this->Height) {
                    // height is larger.
                    $source_y = $image_height - $this->Height;
                }
                if ($image_width > $this->Width) {
                    // width is larger.
                    $source_x = $image_width - $this->Width;
                }
                break;

            case 'bottomleft':
                //bottom left of the image
                if ($image_height > $this->Height) {
                    // height is larger.
                    $source_y = $image_height - $this->Height;
                }
                $source_x = 0;
                break;

            case 'bottomcenter':
                //bottom left of the image
                if ($image_height > $this->Height) {
                    // height is larger.
                    $source_y = $image_height - $this->Height;
                }
                if ($image_width > $this->Width) {
                    // width is larger.
                    $source_x = (($image_width - $this->Width) / 2);
                }
                break;

            case 'custom':
                //new in 1.3
                //use custom positions as percentages to get the position.
                if (round($this->CustomPositionX) < 0 || round($this->CustomPositionX) > 100) {
                    //x not a valid number. Reset:
                    $this->CustomPositionX = 50;
                }
                if (round($this->CustomPositionY) < 0 || round($this->CustomPositionY) > 100) {
                    //y not a valid number. Reset:
                    $this->CustomPositionY = 50;
                }

                //get the digits!
                if (round($this->CustomPositionY) == 0 || $image_height <= $this->Height) {
                    //does not meet credentials
                    $source_y = 0;
                } else {
                    //ok
                    $source_y = (($image_height - $this->Height) * (round($this->CustomPositionY) / 100)) ;
                }
                if (round($this->CustomPositionX) == 0 || $image_width <= $this->Width) {
                    //does not meet credentials
                    $source_x = 0;
                } else {
                    //ok
                    $source_x = (($image_width - $this->Width) * (round($this->CustomPositionX) / 100)) ;
                }
                break;

            default:
                //center of the image
                if ($image_height > $this->Height) {
                    // height is larger.
                    $source_y = (($image_height - $this->Height) / 2);
                }
                if ($image_width > $this->Width) {
                    // width is larger.
                    $source_x = (($image_width - $this->Width) / 2);
                }
                break;
        }

        //bool imagecopyresampled ( destination_image, source_image, destination X, destination Y, source X, source Y, destination W, destination H, source W, source H)
        imagecopyresampled($new_photo, $tmp_image,0,0,$source_x,$source_y, $this->Width, $this->Height, $this->Width, $this->Height);
        ob_start();
        imagejpeg($new_photo,null,$this->Compression);
        $this->InternalImage = ob_get_contents();
        ob_end_clean();
        return true;
        //END SNAPSHOT

    }


}