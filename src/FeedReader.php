<?php

namespace Simplon\Feed;

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
     * @param $url
     *
     * @return $this
     */
    public function readUrl($url)
    {
        $this->data = [];
        $this->namespaces = [];

        $this->simpleXmlElement = simplexml_load_file($url);

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function parse()
    {
        switch ($this->simpleXmlElement->getName())
        {
            case 'feed':
                break;

            case 'rss':
                $this->parseRss();
                break;

            default:
                throw new \Exception('Unknown feed type');
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return $this
     */
    private function parseRss()
    {
        $this->namespaces = $this->simpleXmlElement->getNamespaces(true);
        $channel = $this->simpleXmlElement->channel;

        // channel infos
        $this->parseRssChannel($channel[0]);

        // item infos
        $this->parseRssChannelItems($channel[0]);

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
                $data[$ns][$k] = trim($v);
            }
        }

        return $data;
    }

    /**
     * @param \SimpleXMLElement $channel
     *
     * @return $this
     */
    private function parseRssChannel(\SimpleXMLElement $channel)
    {
        $this->data['title'] = (string)$channel->title;
        $this->data['link'] = (string)$channel->link;
        $this->data['description'] = (string)$channel->description;
        $this->data['language'] = (string)$channel->language;

        // namespace data
        $namespaceData = $this->getRssNamespaceData($channel);

        if (empty($namespaceData) === false)
        {
            $this->data['ns'] = $namespaceData;
        }

        return $this;
    }

    /**
     * @param \SimpleXMLElement $channel
     *
     * @return $this
     */
    private function parseRssChannelItems(\SimpleXMLElement $channel)
    {
        foreach ($channel->item as $entry)
        {
            $entryData = [
                'guid'        => (string)$entry->guid,
                'title'       => (string)$entry->title,
                'link'        => (string)$entry->link,
                'description' => (string)$entry->description,
                'author'      => (string)$entry->author,
            ];

            // namespace data
            $namespaceData = $this->getRssNamespaceData($entry);

            if (empty($namespaceData) === false)
            {
                $entryData['ns'] = $namespaceData;
            }

            $this->data['items'][] = $entryData;
        }

        return $this;
    }
}