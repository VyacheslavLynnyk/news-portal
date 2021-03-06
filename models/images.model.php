<?php
class Images extends Model
{
    protected static $expected_width = 960;

    protected static $expected_height = 400;


    public static function catchFile($input_name, $avaPath)
    {
        if (!empty($_FILES[$input_name]) and $_FILES[$input_name]['error'] == 0) {
            $max_size = 15000000; // 15 mb  */
            $extensions = array('jpeg', 'jpg', 'png', 'gif');
            if (list($width, $height, $type, $attr) = getimagesize($_FILES[$input_name]['tmp_name'])) {
                $ext = strtolower(pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION));

                if ($_FILES[$input_name]['size'] > $max_size) {
                    //   $response = 'File is too large';
                    $avaPath = NULL;
                } else {
                    if (in_array($ext, $extensions)) {
                        $avaPathExt = $avaPath . '_tmp.' . $ext;
                        if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $avaPathExt)) {
                            //if Image less than 400px
                            if ($width > $height) {
                                self::$expected_width = ($height * self::$expected_height/ $width);
                            } else {
                                self::$expected_height = ($height * self::$expected_width/ $width);
                        }
                            if ($width < self::$expected_width && $height < self::$expected_height) {
                                self::$expected_width = $width;
                                self::$expected_height = $height;
                            }
                            return $avaPathExt;
                        }
                    }
                }
            }
        }
        return false;
    }
    
    public function setWidth($w)
    {
        self::$expected_width = $w;
    }
    
    public function setHeight($h)
    {
        self::$expected_height = $h;
    }

    public static function crop_to_fit($sourcePath, $destPath){
        /*
         * Add file validation code here
         */
        $destSizeW = self::$expected_width;
        $destSizeH = self::$expected_height;

        list($sourceWidth, $sourceHeight, $source_type) = getimagesize($sourcePath);

        switch ($source_type) {
            case IMAGETYPE_GIF:
                $sourceGdim = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_JPEG:
                $sourceGdim = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceGdim = imagecreatefrompng($sourcePath);
                break;
        }

        $sourceAspectRatio = $sourceWidth / $sourceHeight;
        $desiredAspectRatio = $destSizeW / $destSizeH;

        if ($sourceAspectRatio > $desiredAspectRatio) {
            /*
             * Triggered when source image is wider
             */
            $tempHeight = $destSizeH;
            $tempWidth = ( int ) ($destSizeH * $sourceAspectRatio);
        } else {
            /*
             * Triggered otherwise (i.e. source image is similar or taller)
             */
            $tempWidth = $destSizeW;
            $tempHeight = ( int ) ($destSizeW / $sourceAspectRatio);
        }

        /*
         * Resize the image into a temporary GD image
         */

        $tempGdim = imagecreatetruecolor($tempWidth, $tempHeight);
        imagecopyresampled(
            $tempGdim,
            $sourceGdim,
            0, 0,
            0, 0,
            $tempWidth, $tempHeight,
            $sourceWidth, $sourceHeight
        );

        /*
         * Copy cropped region from temporary image into the desired GD image
         */

        $x0 = ($tempWidth - $destSizeW) / 2;
        $y0 = ($tempHeight - $destSizeH) / 2;
        $desiredGdim = imagecreatetruecolor($destSizeW, $destSizeH);
        imagecopy(
            $desiredGdim,
            $tempGdim,
            0, 0,
            $x0, $y0,
            $destSizeW, $destSizeH
        );

        /*
         * Render the image
         * Alternatively, you can save the image in file-system or database
         */

        //header('Content-type: image/jpeg');
        //imagejpeg($desiredGdim);
        imagejpeg($desiredGdim, $destPath, 100);
        unlink($sourcePath);
    }
}

