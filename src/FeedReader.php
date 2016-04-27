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
     * @param string $url
     *
     * @return $this
     * @throws \Exception
     */
    private function fetch($url)
    {
        $this->data = [];
        $this->namespaces = [];

        // fix broken XML
        $xml = @file_get_contents($url);

        if (empty($xml))
        {
            throw new \Exception('file does not exist');
        }

        $xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $xml);

        $this->simpleXmlElement = simplexml_load_string($xml);

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
            'image',
            'category',
            'ttl',
            'generator',
            'cloud',
            'pubDate',
            'lastBuildDate',
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
            'category',
            'comments',
            'source',
            'enclosure',
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
            'id',
            'title',
            'subtitle',
            'author',
            'link',
            'updated',
            'category',
            'contributor',
            'generator',
            'icon',
            'logo',
            'rights',
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
            'summary',
            'content',
            'link',
            'author',
            'updated',
            'published',
            'category',
            'contributor',
            'source',
            'rights',
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
                    $data[$ns][$k] = $this->handleAttributes($data[$ns][$k], $v->attributes());
                }
            }
        }

        return $data;
    }

    /**
     * @param mixed $data
     * @param \SimpleXMLElement $attributes
     *
     * @return array
     */
    private function handleAttributes($data, $attributes)
    {
        if ($attributes->count() > 0)
        {
            if (gettype($data) === 'string' && empty($data) === false)
            {
                $data = ['content' => $data];
            }

            $helper = [];

            foreach ($attributes as $k => $v)
            {
                $helper[$k] = $this->cleanData($v);
            }

            if (isset($data['attrs']))
            {
                $data = [
                    ['attrs' => $data['attrs']],
                    ['attrs' => $helper],
                ];
            }
            elseif (isset($data[0]['attrs']))
            {
                $data[] = ['attrs' => $helper];
            }
            else
            {
                $data['attrs'] = $helper;
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $tag
     * @param mixed $value
     *
     * @return array
     */
    private function handleDataAssignment(array $data, $tag, $value)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $attributes = $value->attributes();

        // cast value
        $value = $this->cleanData($value);

        // catch multi-assignments
        if (isset($data[$tag]))
        {
            if (gettype($data[$tag]) === 'string')
            {
                $data[$tag] = [$data[$tag]];
            }

            // only set if we got some value
            if (empty($value) === false)
            {
                $data[$tag][] = $value;
            }
        }

        // first assignment
        else
        {
            $data[$tag] = $value;
        }

        // handle attributes
        if ($attributes !== null)
        {
            $data[$tag] = $this->handleAttributes($data[$tag], $attributes);
        }

        return $data;
    }

    /**
     * @param array $knownTags
     * @param \SimpleXMLElement $entry
     * @param null|string $ignoreTags
     *
     * @return array
     */
    private function readTags(array $knownTags, $entry, $ignoreTags = null)
    {
        $data = [
            'metas' => [],
        ];

        foreach ($entry as $tag => $value)
        {
            if ($ignoreTags !== null && strpos($ignoreTags, $tag) !== false)
            {
                continue;
            }

            // save known data
            if (in_array($tag, $knownTags) === true)
            {
                $data = $this->handleDataAssignment($data, $tag, $value);

                continue;
            }

            // save unknown data
            $data['metas'] = $this->handleDataAssignment($data['metas'], $tag, $value);
        }

        if (empty($data['metas']))
        {
            unset($data['metas']);
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