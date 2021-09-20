<?php

namespace Cafesource\Helper;

use Illuminate\Support\Collection;
use stdClass;

class Arr
{
    /**
     * Json validator
     *
     * Checking json
     *
     * @param $string
     *
     * @return bool
     */
    public static function isJson( $string ) : bool
    {
        @json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @param string $data   Value to check to see if was serialized.
     * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
     *
     * @return bool False if not serialized and true if it was.
     */
    public static function isSerialize( string $data, bool $strict = true ) : bool
    {
        // if it isn't a string, it isn't serialized.
        if ( !is_string($data) ) {
            return false;
        }
        $data = trim($data);
        if ( 'N;' == $data ) {
            return true;
        }
        if ( strlen($data) < 4 ) {
            return false;
        }
        if ( ':' !== $data[ 1 ] ) {
            return false;
        }
        if ( $strict ) {
            $lastc = substr($data, -1);
            if ( ';' !== $lastc && '}' !== $lastc ) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace     = strpos($data, '}');
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace ) {
                return false;
            }
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 ) {
                return false;
            }
            if ( false !== $brace && $brace < 4 ) {
                return false;
            }
        }
        $token = $data[ 0 ];
        switch ( $token ) {
            case 's':
                if ( $strict ) {
                    if ( '"' !== substr($data, -2, 1) ) {
                        return false;
                    }
                } elseif ( false === strpos($data, '"') ) {
                    return false;
                }
                break;

            // or else fall through
            case 'a':
            case 'O':
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }

        return false;
    }

    /**
     * @param      $array
     * @param      $field
     * @param bool $createSubArray
     *
     * @return array
     */
    public static function groupBy( $array, $field, bool $createSubArray = true ) : array
    {
        $arraySorted = [];
        if ( is_object(current($array)) ) {
            foreach ( $array as $item ) {
                if ( $createSubArray ) {
                    if ( !@is_array($arraySorted[ $item->$field ]) ) {
                        $arraySorted[ $item->$field ] = [];
                    }
                    $arraySorted[ $item->$field ][] = $item;
                } else {
                    $arraySorted[ $item->$field ] = $item;
                }
            }
        } else if ( is_array(current($array)) ) {
            foreach ( $array as $item ) {
                if ( $createSubArray ) {
                    if ( !@is_array($arraySorted[ $item[ $field ] ]) ) {
                        $arraySorted[ $item[ $field ] ] = [];
                    }
                    $arraySorted[ $item[ $field ] ][] = $item;
                } else {
                    $arraySorted[ $item[ $field ] ] = $item;
                }
            }
        } else {
            return $array;
        }

        return $arraySorted;
    }

    /**
     * Sort multidimensional array by sub-array key
     *
     * @param        $array
     * @param        $field
     * @param string $order
     * @param bool   $keepIndex
     *
     * @return array|Collection|stdClass
     */
    public static function sortBy( $array, $field, $order = 'asc', $keepIndex = true )
    {
        // Check if Laravel Collection given
        $isLaravelCollection = false;
        if ( class_exists('\Illuminate\Support\Collection') ) {
            if ( $array instanceof Collection ) {
                $array               = $array->toArray();
                $isLaravelCollection = true;
            }
        }

        // Check if Object given
        $isObject = false;
        if ( is_object($array) ) {
            $array    = self::fromObject($array);
            $isObject = true;
        }

        if ( empty($array) ) {
            return ($isLaravelCollection) ? self::toCollection([]) : (($isObject) ? self::toObject([]) : []);
        }

        // Get sorting order
        $int = 1;
        if ( strtolower($order) == 'desc' ) {
            $int = -1;
        }

        // Sorting
        if ( $keepIndex ) {
            uasort($array, function ( $a, $b ) use ( $field, $int ) {
                if ( $a[ $field ] == $b[ $field ] ) {
                    return 0;
                }
                return ($a[ $field ] < $b[ $field ]) ? -$int : $int;
            });
        } else {
            usort($array, function ( $a, $b ) use ( $field, $int ) {
                if ( $a[ $field ] == $b[ $field ] ) {
                    return 0;
                }
                return ($a[ $field ] < $b[ $field ]) ? -$int : $int;
            });
        }

        return ($isLaravelCollection) ? self::toCollection($array) : (($isObject) ? self::toObject($array) : $array);
    }

    /**
     * Array to Object
     *
     * @param     $array
     * @param int $level
     *
     * @return array|mixed|stdClass
     */
    public static function toObject( $array, $level = 0 )
    {
        if ( !is_array($array) ) {
            return $array;
        }

        if ( $level <= 0 ) {
            $object = new stdClass();
            if ( is_array($array) && !empty($array) ) {
                foreach ( $array as $key => $value ) {
                    $key = trim($key);
                    if ( $key != '' ) {
                        $object->$key = self::toObject($value);
                    }
                }

                return $object;
            } else {
                return [];
            }
        } else {
            // First we convert the array to a json string
            $json = json_encode($array, 0, $level);

            // The we convert the json string to a stdClass()
            $object = json_decode($json);

            return $object;
        }
    }

    /**
     * Array to Laravel Collection
     *
     * @param $array
     *
     * @return array|Collection
     */
    public static function toCollection( $array )
    {
        if ( !is_array($array) ) {
            return $array;
        }

        $newArray = [];
        foreach ( $array as $key => $value ) {
            if ( is_array($value) ) {
                $newArray[ $key ] = self::toCollection($value);
            } else {
                $newArray[ $key ] = $value;
            }
        }

        $newArray = collect($newArray);

        return $newArray;
    }

    /**
     * array_diff_assoc() recursive
     *
     * @param      $array1
     * @param      $array2
     * @param bool $checkValues
     *
     * @return array
     */
    public static function diffAssoc( $array1, $array2, $checkValues = false )
    {
        $difference = [];
        foreach ( $array1 as $key => $value ) {
            if ( is_array($value) ) {
                if ( !isset($array2[ $key ]) || !is_array($array2[ $key ]) ) {
                    $difference[ $key ] = $value;
                } else {
                    $newDiff = self::diffAssoc($value, $array2[ $key ]);
                    if ( !empty($newDiff) )
                        $difference[ $key ] = $newDiff;
                }
            } else if ( !array_key_exists($key, $array2) ) {
                $difference[ $key ] = $value;
            }

            // Check if the values is different
            if ( $checkValues ) {
                if ( array_key_exists($key, $array2) && $array2[ $key ] !== $value ) {
                    $difference[ $key ] = $value;
                }
            }
        }
        return $difference;
    }
}
