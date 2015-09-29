<?php
/**
 * Created by PhpStorm.
 * User: firomero
 * Date: 9/29/2015
 * Time: 3:21 PM
 */

class ArrayCustomSearch {
    /**
     * Binary Search Uncentered
     * This is the method of binary search calculating the exact pivote for the search.
     * @param array $haystack
     * @param $first
     * @param $last
     * @param $needle
     * @return bool
     */
    public static function binary_search_uncentered(array $haystack, $first, $last,$needle){

        $nterc = round(sizeof($haystack)/3);

        if ($first>=$last) {
            if ($haystack[$last]==$needle) {
                return true;
            } else {
                return false;
            }
        }

        $nterc = round(($last-$first+1)/3);
        if ($needle==$haystack[$first+$nterc]) {
            return true;
        }elseif($needle<$haystack[$first+$nterc]){
            return binary_search_uncentered($haystack,$first,$first+$nterc-1,$needle);

        } elseif ($needle==$haystack[$last-$nterc]) {
            return true;
        } elseif ($needle<$haystack[$last-$nterc]) {
            return binary_search_uncentered($haystack,$first+$nterc+1,$last-$nterc-1,$needle);
        } else {
            return binary_search_uncentered($haystack,$last-$nterc+1,$last,$needle);
        }

        return false;


    }

    /**
     * Binary Search Uncentered with Callback
     * This is the method of binary search calculating the exact pivote for the search.
     * @param array $haystack
     * @param $first
     * @param $last
     * @param $needle
     * @param callable $callback
     * @return bool
     */
 public static function binary_search_uncentered_callable(array $haystack, $first, $last,$needle, callable  $callback){

        $nterc = round(sizeof($haystack)/3);

        if ($first>=$last) {
            if ($callback($haystack[$last])==$callback($needle)) {
                return $last;
            } else {
                return -1;
            }
        }

        $nterc = round(($last-$first+1)/3);
        if ($callback($needle)==$callback($haystack[$first+$nterc])) {
            return $first+$nterc;
        }elseif($callback($needle)<$callback($haystack[$first+$nterc])){
            return binary_search_uncentered($haystack,$first,$first+$nterc-1,$needle);

        } elseif ($callback($needle)==$callback($haystack[$last-$nterc])) {
            return $last-$nterc;
        } elseif ($callback($needle)<$callback($haystack[$last-$nterc])) {
            return binary_search_uncentered($haystack,$first+$nterc+1,$last-$nterc-1,$needle);
        } else {
            return binary_search_uncentered($haystack,$last-$nterc+1,$last,$needle);
        }

        return false;


    }

    /**
     *
     * @param $array
     * @param string $field
     * @param string $direction
     * @return bool
     */
    public static function sortBy(&$array,$field = 'value', $direction = 'asc')
    {


        usort($array, function ($a, $b) use ($direction, $field) {


            if ($a[$field] == $b[$field]) {
                return 0;
            }

            return $direction == 'asc' ? ($a[$field] > $b[$field] ? -1 : 1) : ($a[$field] < $b[$field] ? -1 : 1);
        });

        return true;
    }

    /**
     * Generate the average collection with option callback
     * @param array $collection
     * @param callable $callback
     * @return float
     */
   public static function average_callback(array $collection,callable $callback){
        $a =  array_reduce($collection,function($ac,$v)use($callback){
            $ac +=$callback($v);
            return $ac;
        });

        return $a/count($a);
    }


    /**
     * Unorder an array
     * @param array $array
     * @return array
     */
   public static function array_shuffle(array $array){
        $copy = $array;
        uasort($copy, function ($a, $b) {
            return mt_rand(-1, 1);
        });

        return $copy;

    }

    /**
     * Array unique callback
     * @param array $arr
     * @param callable $callback
     * @param bool $strict
     * @return array
     */
   public static function array_unique_callback(array $arr, callable $callback, $strict = false)
    {
        return array_filter(
            $arr,
            function ($item) use ($strict, $callback) {
                static $haystack = array();
                $needle = $callback($item);
                if (in_array($needle, $haystack, $strict)) {
                    return false;
                } else {
                    $haystack[] = $needle;
                    return true;
                }
            }
        );
    }



}


