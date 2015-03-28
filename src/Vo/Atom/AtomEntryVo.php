<?php

namespace Simplon\Feed\Vo\Atom;

/**
 * AtomEntryVo
 * @package Simplon\Feed\Vo\Atom
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class AtomEntryVo extends AbstractAtomVo
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
    protected $summary;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var \DateTime
     */
    protected $updated;

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
    public function getContent()
    {
        return (string)$this->content;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        if ($this->updated !== null)
        {
            return new \DateTime($this->updated);
        }

        return null;
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
    public function getSummary()
    {
        return (string)$this->summary;
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