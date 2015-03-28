<?php

namespace Simplon\Feed\Vo\Atom;

/**
 * AtomVo
 * @package Simplon\Feed\Vo\Atom
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class AtomVo extends AbstractAtomVo
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $subtitle;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $updated;

    /**
     * @var array
     */
    protected $entries;

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
    public function getId()
    {
        return (string)$this->id;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return (string)$this->subtitle;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return (string)$this->updated;
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
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string)$this->title;
    }
}