<?php

namespace Simplon\Feed\Vo\Atom;

/**
 * AbstractAtomVo
 * @package Simplon\Feed\Vo\Atom
 * @author  Tino Ehrich (tino@bigpun.me)
 */
abstract class AbstractAtomVo
{
    /**
     * @var array
     */
    protected $metas;

    /**
     * @return bool
     */
    public function hasMetas()
    {
        return empty($this->metas) === false;
    }

    /**
     * @return array
     */
    public function getMetas()
    {
        return (array)$this->metas;
    }

    /**
     * @return array
     */
    public function getMetaKeys()
    {
        return array_keys($this->getMetas());
    }

    /**
     * @param string $key
     *
     * @return array|null
     */
    public function getMetaByKey($key)
    {
        $metas = $this->getMetas();

        if (isset($metas[$key]))
        {
            return (array)$metas[$key];
        }

        return null;
    }
}