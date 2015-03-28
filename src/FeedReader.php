<?php

namespace Simplon\Feed;

use Simplon\Feed\Vo\Atom\AtomVo;
use Simplon\Feed\Vo\Rss\RssVo;

/**
 * FeedReader
 * @package Simplon\Feed
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class FeedReader
{
    /**
     * @var \SimpleXMLElement
     */
    private $simpleXmlElement;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $namespaces = [];

    /**
     * @param string $url
     *
     * @return RssVo
     */
    public function rss($url)
    {
        $this->fetch($url)->parseRss();

        return new RssVo($this->data);
    }

    /**
     * @param string $url
     *
     * @return AtomVo
     */
    public function atom($url)
    {
        $this->fetch($url)->parseAtom();

        return new AtomVo($this->data);
    }

    /**
     * @param $url
     *
     * @return FeedReader
     */
    private function fetch($url)
    {
        $this->data = [];
        $this->namespaces = [];

        $this->simpleXmlElement = simplexml_load_file($url);

        return $this;
    }

    /**
     * @return FeedReader
     */
    private function parseRss()
    {
        $this->namespaces = $this->simpleXmlElement->getNamespaces(true);

        /** @noinspection PhpUndefinedFieldInspection */
        $channel = $this->simpleXmlElement->channel;

        // channel infos
        $this->parseRssChannel($channel[0]);

        // item infos
        $this->parseRssChannelItems($channel[0]);

        return $this;
    }

    /**
     * @param \SimpleXMLElement $channel
     *
     * @return FeedReader
     */
    private function parseRssChannel(\SimpleXMLElement $channel)
    {
        $knownTags = [
            'title',
            'link',
            'description',
            'language',
        ];

        // read data
        $this->data = $this->readTags($knownTags, $channel, 'item');

        // namespace data
        $namespaceData = $this->getRssNamespaceData($channel);

        if (empty($namespaceData) === false)
        {
            $this->data['namespaces'] = $namespaceData;
        }

        return $this;
    }

    /**
     * @param \SimpleXMLElement $channel
     *
     * @return FeedReader
     */
    private function parseRssChannelItems(\SimpleXMLElement $channel)
    {
        $knownTags = [
            'guid',
            'title',
            'link',
            'description',
            'author',
            'pubDate',
        ];

        /** @noinspection PhpUndefinedFieldInspection */
        foreach ($channel->item as $entry)
        {
            // read data
            $entryData = $this->readTags($knownTags, $entry);

            // namespace data
            $namespaceData = $this->getRssNamespaceData($entry);

            if (empty($namespaceData) === false)
            {
                $entryData['namespaces'] = $namespaceData;
            }

            $this->data['items'][] = $entryData;
        }

        return $this;
    }

    /**
     * @return FeedReader
     */
    private function parseAtom()
    {
        $this->namespaces = $this->simpleXmlElement->getNamespaces(true);

        /** @noinspection PhpUndefinedFieldInspection */
        $channel = $this->simpleXmlElement;

        // channel infos
        $this->parseAtomChannel($channel[0]);

        // item infos
        $this->parseAtomChannelEntries($channel[0]);

        return $this;
    }

    /**
     * @param \SimpleXMLElement $channel
     *
     * @return FeedReader
     */
    private function parseAtomChannel(\SimpleXMLElement $channel)
    {
        $knownTags = [
            'updated',
            'id',
            'title',
            'link',
            'author',
        ];

        // read data
        $this->data = $this->readTags($knownTags, $channel, 'entry');

        return $this;
    }

    /**
     * @param \SimpleXMLElement $channel
     *
     * @return FeedReader
     */
    private function parseAtomChannelEntries(\SimpleXMLElement $channel)
    {
        $knownTags = [
            'id',
            'title',
            'author',
            'link',
            'published',
            'updated',
            'summary',
            'content',
        ];

        /** @noinspection PhpUndefinedFieldInspection */
        foreach ($channel->entry as $entry)
        {
            // read data
            $entryData = $this->readTags($knownTags, $entry);

            $this->data['entries'][] = $entryData;
        }

        return $this;
    }

    /**
     * @param array  $data
     * @param string $attr
     * @param mixed  $value
     *
     * @return array
     */
    private function handleDataAssignment(array $data, $attr, $value)
    {
        if (isset($data[$attr]))
        {
            if (gettype($data[$attr]) === 'string')
            {
                $data[$attr] = [$data[$attr]];
            }

            $data[$attr][] = $value;
        }
        else
        {
            $data[$attr] = $value;
        }

        return $data;
    }

    /**
     * @param array             $knownTags
     * @param \SimpleXMLElement $entry
     * @param null|string       $ignoreTags
     *
     * @return array
     */
    private function readTags(array $knownTags, $entry, $ignoreTags = null)
    {
        $data = [
            'metas' => []
        ];

        foreach ($entry as $tag => $value)
        {
            if ($ignoreTags !== null && strpos($ignoreTags, $tag) !== false)
            {
                continue;
            }

            // read attributes
            /** @noinspection PhpUndefinedMethodInspection */
            $attributes = $value->attributes();

            // cast value
            $value = $this->cleanData($value);

            // save known data
            if (in_array($tag, $knownTags) === true)
            {
                $data = $this->handleDataAssignment($data, $tag, $value);

                if ($attributes !== null)
                {
                    $data = $this->handleAttributes($attributes, $data);
                }

                continue;
            }

            // save unknown data
            $data['metas'] = $this->handleDataAssignment($data['metas'], $tag, $value);

            if ($attributes !== null)
            {
                $data['metas'][$tag] = $this->handleAttributes($attributes, $data['metas'][$tag]);
            }
        }

        return $data;
    }

    /**
     * @param \SimpleXMLElement $element
     *
     * @return array
     */
    private function getRssNamespaceData(\SimpleXMLElement $element)
    {
        $data = [];

        foreach ($this->namespaces as $ns => $url)
        {
            $nsElements = $element->children($url);

            foreach ($nsElements as $k => $v)
            {
                $data[$ns][$k] = $this->cleanData($v);

                /** @noinspection PhpUndefinedMethodInspection */
                if ($v->attributes() !== null)
                {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $data[$ns][$k] = $this->handleAttributes($v->attributes(), $data[$ns][$k]);
                }
            }
        }

        return $data;
    }

    /**
     * @param \SimpleXMLElement $attributes
     * @param mixed             $data
     *
     * @return array
     */
    private function handleAttributes($attributes, $data)
    {
        if ($attributes->count() > 0)
        {
            if (gettype($data) === 'string' && empty($data) === false)
            {
                $data = ['content' => $data];
            }

            foreach ($attributes as $k => $v)
            {
                $data['attrs'][$k] = $this->cleanData($v);
            }
        }

        return $data;
    }

    /**
     * @param \SimpleXMLElement $value
     *
     * @return array|string
     */
    private function cleanData($value)
    {
        if ($value->count() > 0)
        {
            $data = [];

            foreach ($value as $k => $v)
            {
                $data[$k] = $this->cleanData($v);
            }

            return (array)$data;
        }

        return trim($value);
    }
}