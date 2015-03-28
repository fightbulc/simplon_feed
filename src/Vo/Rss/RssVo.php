<?php

namespace Simplon\Feed\Vo\Rss;

/**
 * RssVo
 * @package Simplon\Feed\Vo\Rss
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class RssVo extends AbstractRssVo
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $languge;

    /**
     * @var array
     */
    protected $items;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $vars = get_class_vars(get_class($this));

        foreach ($vars as $name => $val)
        {
            if (isset($data[$name]))
            {
                $this->$name = $data[$name];
            }
        }
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }

    /**
     * @return bool
     */
    public function hasItems()
    {
        return empty($this->items) === false;
    }

    /**
     * @return RssItemVo[]|null
     */
    public function getItems()
    {
        if ($this->hasItems() === true)
        {
            $feedVoMany = [];

            foreach ($this->items as $item)
            {
                $feedVoMany[] = new RssItemVo($item);
            }

            return $feedVoMany;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getLanguge()
    {
        return (string)$this->languge;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return (string)$this->link;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string)$this->title;
    }
}