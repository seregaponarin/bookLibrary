<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 09.02.2017
 * Time: 17:12
 */

namespace BookLibraryBundle\Twig;


class BookLibraryExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('img_size', array($this, "getImageSizeAttribute"))
        );
    }

    public function getImageSizeAttribute($width = 100, $height = 100)
    {
        return ($width > $height)?' width='.$width.'':'height='.$height.' ';
    }
}