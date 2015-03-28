<?php

namespace Simplon\Feed\Vo\Rss;

/**
 * RssItemVo
 * @package Simplon\Feed\Vo\Rss
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class RssItemVo extends AbstractRssVo
{
    /**
     * @var string
     */
    protected $guid;

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
    protected $author;

    /**
     * @var null|\DateTime
     */
    protected $pubDate;

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
     * @return \DateTime
     */
    public function getPubDate()
    {
        if ($this->pubDate !== null)
        {
            return new \DateTime($this->pubDate);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getGuid()
    {
        return (string)$this->guid;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return (string)$this->author;
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