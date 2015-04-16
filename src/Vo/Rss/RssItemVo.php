<?php

namespace Simplon\Feed\Vo\Rss;

use Simplon\Helper\CastAway;

/**
 * RssItemVo
 * @package Simplon\Feed\Vo\Rss
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class RssItemVo extends AbstractRssVo
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array|null
     */
    protected $guid;

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
     * @var null|string
     */
    protected $author;

    /**
     * @var null|string
     */
    protected $comments;

    /**
     * @var null|string
     */
    protected $source;

    /**
     * @var null|array
     */
    protected $enclosure;

    /**
     * @var null|array
     */
    protected $category;

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
    public function getCategory()
    {
        return CastAway::toArray($this->category);
    }

    /**
     * @return null|string
     */
    public function getComments()
    {
        return CastAway::toString($this->comments);
    }

    /**
     * @return null|string
     */
    public function getSource()
    {
        return CastAway::toString($this->source);
    }

    /**
     * @return array|null
     */
    public function getEnclosure()
    {
        return CastAway::toArray($this->enclosure);
    }

    /**
     * @return null|\DateTime
     */
    public function getPubDate()
    {
        return CastAway::toDateTime($this->pubDate);
    }

    /**
     * @return array|null
     */
    public function getGuid()
    {
        $guid = CastAway::toArray($this->guid);

        if ($guid !== null)
        {
            if (isset($guid['attrs']) === false)
            {
                $guid = [
                    'content' => $guid[0],
                    'attrs'   => [
                        'isPermaLink' => true
                    ]
                ];

            }
        }

        return $guid;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return CastAway::toString($this->description);
    }

    /**
     * @return null|string
     */
    public function getAuthor()
    {
        return CastAway::toString($this->author);
    }

    /**
     * @return null|string
     */
    public function getLink()
    {
        return CastAway::toString($this->link);
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return CastAway::toString($this->title);
    }
}