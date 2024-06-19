<?php
/**
 * @author: Mojtaba Pakzad
 * @package Vediana
 */

namespace App;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * Class ImageManipulation
 * This class needs to Intervention/Iamge class to work.
 * @see http://image.intervention.io/
 * @package Vediana
 */
class ImageManager
{
    /**
     * Retrieves a path of image along with it's final size.
     *
     * @param string $imagePath The full path of an image. e.g: "storage/images/categories/2018/11/image.jpg
     * @param string|array $size string means a name passes to the parameter and array means there is at least one of width or height index
     * @return bool if an error happens then return false
     */
    public static function resize($imagePath, $size)
    {
        if (!File::exists($imagePath)) {
            return $imagePath;
        }

        $resizedImage = self::getResizeName($imagePath, $size);

        if(!File::exists($resizedImage)) {
            if (is_array($size)) {
                Image::make($imagePath)->resize($size['width'], $size['height'])->save($resizedImage);
            } else {
                Image::make($imagePath)->resize($size)->save($resizedImage);
            }
        }
        return $resizedImage;
    }
    
    /**
     * Retrieves a path of image along with it's final size.
     *
     * @param string $imagePath The full path of an image. e.g: "storage/images/categories/2018/11/image.jpg
     * @param string|array $size string means a name passes to the parameter and array means there is at least one of width or height index
     * @return bool if an error happens then return false
     */
    public static function crop($imagePath, $size)
    {
        if (!File::exists($imagePath)) {
            return $imagePath;
        }

        $resizedImage = self::getCropName($imagePath, $size);

        if(!File::exists($resizedImage)) {
            if (is_array($size)) {
                $img = Image::make($imagePath);
                if (isset($size['x'], $size['y'])) {
                    $img->crop($size['width'], $size['height'], $size['x'], $size['y'])->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
                } elseif (isset($size['x'])) {
                    $img->crop($size['width'], $size['height'], $size['x'])->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
                } elseif (isset($size['y'])) {
                    $img->crop($size['width'], $size['height'], null, $size['y'])->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
                } else {
                    $img->crop($size['width'], $size['height'])->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
                }
            } else {
                Image::make($imagePath)->crop($size, $size)->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
            }
        }
        return $resizedImage;
    }

    /**
     * Retrieves a path of image along with it's final size.
     *
     * @param string $imagePath The full path of an image. e.g: "storage/images/categories/2018/11/image.jpg
     * @param string|array $size string means a name passes to the parameter and array means there is at least one of width or height index
     * @return bool if an error happens then return false
     */
    public static function fit($imagePath, $size)
    {
        if (!File::exists($imagePath)) {
            return $imagePath;
        }

        $resizedImage = self::getFitName($imagePath, $size);

        if(!File::exists($resizedImage)) {
            if (is_array($size)) {
                $img = Image::make($imagePath);
                $img->fit($size['width'], $size['height'])->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
            } else {
                Image::make($imagePath)->fit($size, $size)->insert('storage/images/watermark.png', 'bottom-right', 10, 10)->save($resizedImage);
            }
        }
        return $resizedImage;
    }
    
    public static function exif($image)
    {
        Image::make($image)->orientate()->save($image, 60);
    }

    /**
     * Retrieves the image path and its final size and return the new file name.
     *
     * @param string $imagePath
     * @param $size
     * @return bool|string
     */
    public static function getResizeName($imagePath, $size)
    {
        if (is_null($size)) {
            return false;
        }

        if (is_array($size)) {
            if (!array_key_exists('width', $size) && !array_key_exists('height', $size)) {
                return false;
            }

            if (array_key_exists('width', $size)) {
                if (!is_int($size['width'])) {
                    $size['width'] = null;
                }
            }

            if (array_key_exists('height', $size)) {
                if (!is_int($size['height'])) {
                    $size['height'] = null;
                }
            }

            $sizeExtension = '-' . $size['width'] . 'x' . $size['height'];
        } else {
            if (!in_array($size, ['small', 'medium', 'large'])) {
                return false;
            }
            $sizeExtension  = '-' . $size;
        }


        $name       = File::name($imagePath);
        $directory  = File::dirname($imagePath);
        $extension  = File::extension($imagePath);

        if(!File::exists($imagePath)) {
            return false;
        }

        return $directory . '/' . $name . $sizeExtension . '.' . $extension;
    }
    
    /**
     * Retrieves the image path and its final size and return the new file name.
     *
     * @param string $imagePath
     * @param $size
     * @return bool|string
     */
    public static function getCropName($imagePath, $size)
    {
        if (is_null($size)) {
            return false;
        }

        if (is_array($size)) {
            if (!array_key_exists('width', $size) && !array_key_exists('height', $size)) {
                return false;
            }

            if (array_key_exists('width', $size)) {
                if (!is_int($size['width'])) {
                    $size['width'] = null;
                }
            }

            if (array_key_exists('height', $size)) {
                if (!is_int($size['height'])) {
                    $size['height'] = null;
                }
            }

            $sizeExtension = '-c' . $size['width'] . 'x' . $size['height'];
        } else {
            if (!in_array($size, ['small', 'medium', 'large'])) {
                return false;
            }
            $sizeExtension  = '-c' . $size;
        }


        $name       = File::name($imagePath);
        $directory  = File::dirname($imagePath);
        $extension  = File::extension($imagePath);

        if(!File::exists($imagePath)) {
            return false;
        }

        return $directory . '/' . $name . $sizeExtension . '.' . $extension;
    }
    
    /**
     * Retrieves the image path and its final size and return the new file name.
     *
     * @param string $imagePath
     * @param $size
     * @return bool|string
     */
    public static function getFitName($imagePath, $size)
    {
        if (is_null($size)) {
            return false;
        }

        if (is_array($size)) {
            if (!array_key_exists('width', $size) && !array_key_exists('height', $size)) {
                return false;
            }

            if (array_key_exists('width', $size)) {
                if (!is_int($size['width'])) {
                    $size['width'] = null;
                }
            }

            if (array_key_exists('height', $size)) {
                if (!is_int($size['height'])) {
                    $size['height'] = null;
                }
            }

            $sizeExtension = '-f' . $size['width'] . 'x' . $size['height'];
        } else {
            if (!in_array($size, ['small', 'medium', 'large'])) {
                return false;
            }
            $sizeExtension  = '-f' . $size;
        }


        $name       = File::name($imagePath);
        $directory  = File::dirname($imagePath);
        $extension  = File::extension($imagePath);

        if(!File::exists($imagePath)) {
            return false;
        }

        return $directory . '/' . $name . $sizeExtension . '.' . $extension;
    }
}
