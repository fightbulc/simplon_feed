<?php

namespace Simplon\Feed;

/**
 * CastAway
 * @package Simplon\Feed
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class CastAway
{
    /**
     * @param $val
     *
     * @return int|null
     */
    public static function toInt($val)
    {
        return $val !== null ? (int)$val : null;
    }

    /**
     * @param $val
     *
     * @return null|string
     */
    public static function toString($val)
    {
        return $val !== null ? (string)$val : null;
    }

    /**
     * @param $val
     *
     * @return bool|null
     */
    public static function toBool($val)
    {
        return $val !== null ? $val === true : null;
    }

    /**
     * @param $val
     *
     * @return float|null
     */
    public static function toFloat($val)
    {
        return $val !== null ? (float)$val : null;
    }

    /**
     * @param $val
     *
     * @return array|null
     */
    public static function toArray($val)
    {
        return $val !== null ? (array)$val : null;
    }

    /**
     * @param $val
     *
     * @return null|object
     */
    public static function toObject($val)
    {
        return $val !== null ? (object)$val : null;
    }

    /**
     * @param string|null   $val
     * @param \DateTimeZone $dateTimeZone
     *
     * @return \DateTime|null
     */
    public static function toDateTime($val, \DateTimeZone $dateTimeZone = null)
    {
        return $val !== null ? new \DateTime($val, $dateTimeZone) : null;
    }
}