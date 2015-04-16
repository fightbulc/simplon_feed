<?php

namespace Simplon\Feed\Vo\Rss;

use Simplon\Helper\CastAway;

/**
 * RssVo
 * @package Simplon\Feed\Vo\Rss
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class RssVo extends AbstractRssVo
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $link;

    /**
     * @var null|string
     */
    protected $description;

    /**
     * @var null|array
     */
    protected $image;

    /**
     * @var null|array
     */
    protected $category;

    /**
     * @var null|string
     */
    protected $languge;

    /**
     * @var null|\DateTime
     */
    protected $pubDate;

    /**
     * @var null|\DateTime
     */
    protected $lastBuildDate;

    /**
     * @var null|int
     */
    protected $ttl;

    /**
     * @var null|array
     */
    protected $items;

    /**
     * @var null|string
     */
    protected $generator;

    /**
     * @var null|array
     */
    protected $cloud;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $vars = get_class_vars(get_class($this));

        // cache raw data
        $this->data = $data;

        foreach ($vars as $name => $val)
        {
            if (isset($data[$name]))
            {
                $this->$name = $data[$name];
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function getCloud()
    {
        return CastAway::toArray($this->cloud);
    }

    /**
     * @return null|string
     */
    public function getGenerator()
    {
        return CastAway::toString($this->generator);
    }

    /**
     * @return null|int
     */
    public function getTtl()
    {
        return CastAway::toInt($this->ttl);
    }

    /**
     * @return null|array
     */
    public function getCategory()
    {
        return CastAway::toArray($this->category);
    }

    /**
     * @return null|array
     */
    public function getImage()
    {
        return CastAway::toArray($this->image);
    }

    /**
     * @return \DateTime|null
     */
    public function getLastBuildDate()
    {
        return CastAway::toDateTime($this->lastBuildDate);
    }

    /**
     * @return \DateTime|null
     */
    public function getPubDate()
    {
        return CastAway::toDateTime($this->pubDate);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return CastAway::toString($this->description);
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
        return CastAway::toString($this->languge);
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return CastAway::toString($this->link);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return CastAway::toString($this->title);
    }
}