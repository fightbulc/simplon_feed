<?php

namespace Simplon\Feed\Vo\Atom;

use Simplon\Helper\CastAway;

/**
 * AtomEntryVo
 * @package Simplon\Feed\Vo\Atom
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class AtomEntryVo extends AbstractAtomVo
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var null|string
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $summary;

    /**
     * @var null|string
     */
    protected $content;

    /**
     * @var null|string
     */
    protected $link;

    /**
     * @var null|string
     */
    protected $author;

    /**
     * @var null|\DateTime
     */
    protected $updated;

    /**
     * @var null|\DateTime
     */
    protected $published;

    /**
     * @var null|array
     */
    protected $category;

    /**
     * @var null|array
     */
    protected $contributor;

    /**
     * @var null|array
     */
    protected $source;

    /**
     * @var null|array
     */
    protected $rights;

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
     * @return array|null
     */
    public function getContributor()
    {
        return CastAway::toArray($this->contributor);
    }

    /**
     * @return \DateTime|null
     */
    public function getPublished()
    {
        return CastAway::toDateTime($this->published);
    }

    /**
     * @return array|null
     */
    public function getRights()
    {
        return CastAway::toArray($this->rights);
    }

    /**
     * @return array|null
     */
    public function getSource()
    {
        return CastAway::toArray($this->source);
    }

    /**
     * @return null|string
     */
    public function getContent()
    {
        return CastAway::toString($this->content);
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return CastAway::toDateTime($this->updated);
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return CastAway::toString($this->id);
    }

    /**
     * @return null|string
     */
    public function getSummary()
    {
        return CastAway::toString($this->summary);
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