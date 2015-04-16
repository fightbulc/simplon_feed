<?php

namespace Simplon\Feed\Vo\Atom;

use Simplon\Helper\CastAway;

/**
 * AtomVo
 * @package Simplon\Feed\Vo\Atom
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class AtomVo extends AbstractAtomVo
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
    protected $subtitle;

    /**
     * @var null|string
     */
    protected $author;

    /**
     * @var null|array
     */
    protected $link;

    /**
     * @var null|\DateTime
     */
    protected $updated;

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
    protected $generator;

    /**
     * @var null|string
     */
    protected $icon;

    /**
     * @var null|string
     */
    protected $logo;

    /**
     * @var null|string
     */
    protected $rights;

    /**
     * @var null|array
     */
    protected $entries;


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
     * @return null|string
     */
    public function getAuthor()
    {
        return CastAway::toString($this->author);
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
     * @return array|null
     */
    public function getGenerator()
    {
        return CastAway::toArray($this->generator);
    }

    /**
     * @return null|string
     */
    public function getIcon()
    {
        return CastAway::toString($this->icon);
    }

    /**
     * @return null|string
     */
    public function getLogo()
    {
        return CastAway::toString($this->logo);
    }

    /**
     * @return null|string
     */
    public function getRights()
    {
        return CastAway::toString($this->rights);
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
    public function getSubtitle()
    {
        return CastAway::toString($this->subtitle);
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return CastAway::toDateTime($this->updated);
    }

    /**
     * @return bool
     */
    public function hasEntries()
    {
        return empty($this->entries) === false;
    }

    /**
     * @return AtomEntryVo[]|null
     */
    public function getEntries()
    {
        if ($this->hasEntries() === true)
        {
            $feedVoMany = [];

            foreach ($this->entries as $entry)
            {
                $feedVoMany[] = new AtomEntryVo($entry);
            }

            return $feedVoMany;
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function getLink()
    {
        return CastAway::toArray($this->link);
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return CastAway::toString($this->title);
    }
}