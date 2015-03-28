<?php

namespace Simplon\Feed\Vo\Rss;

/**
 * AbstractRssVo
 * @package Simplon\Feed\Vo\Rss
 * @author  Tino Ehrich (tino@bigpun.me)
 */
abstract class AbstractRssVo
{
    /**
     * @var array
     */
    protected $metas;

    /**
     * @var array
     */
    protected $namespaces;

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

    /**
     * @return bool
     */
    public function hasNamespaces()
    {
        return empty($this->namespaces) === false;
    }

    /**
     * @return array
     */
    public function getNamespaces()
    {
        return (array)$this->namespaces;
    }

    /**
     * @return array
     */
    public function getNamespaceKeys()
    {
        return array_keys($this->getNamespaces());
    }

    /**
     * @param string $key
     *
     * @return array|null
     */
    public function getNamespaceByKey($key)
    {
        $ns = $this->getNamespaces();

        if (isset($ns[$key]))
        {
            return (array)$ns[$key];
        }

        return null;
    }
}