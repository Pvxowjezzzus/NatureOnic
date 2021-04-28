<?php


namespace app\libs;


class Images
{
    public $image_type;
    public $image;

    public function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    public function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=0600) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,$filename);
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
    }
    public function getWidth() {
        return imagesx($this->image);
    }
    public function getHeight() {
        return imagesy($this->image);
    }

    public function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

    public function size($img)
    {
        $bytes = floatval($img);
        $arr = array(
            0 => array(
                "UNIT" => "Gb",
                "VALUE" => pow(1024, 3),

            ),
            1=>array(
                "UNIT" => "Mb",
                "VALUE" => pow(1024, 2),

            ),
             2=> array(
                "UNIT" => "Kb",
                "VALUE" => 1024,

            ),
           
            3 => array(
                "UNIT" => "b",
                "VALUE" => 1,
            ), 
        );

        foreach($arr as $arritem) {
            if($bytes >= $arritem['VALUE']) {
                $res = $bytes / $arritem['VALUE'];
                $res = str_replace('.', ',', strval(round($res, 2))." ".$arritem['UNIT']);
                break;
            }
        }
        return $res;
    }
}