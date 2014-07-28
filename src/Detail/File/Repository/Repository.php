<?php

namespace Detail\File\Repository;

use Detail\File\BackgroundProcessing\Repository\BackgroundProcessingRepositoryInterface;
use Detail\File\Exception\ItemNotFoundException;
use Detail\File\Item\ItemInterface;
use Detail\File\Storage\StorageInterface;

class Repository implements
    BackgroundProcessingRepositoryInterface
{
    protected $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    protected function getStorage()
    {
        return $this->storage;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($id, $revision = null)
    {
        return $this->getStorage()->hasItem($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getItem($id, $revision = null)
    {
        $item = $this->getStorage()->getItem($this, $id, $revision);

        if ($item === null) {
            throw new ItemNotFoundException(
                sprintf('Item "%s" does not exist in the repository')
            );
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemContents($id, $revision = null)
    {
        return $this->getStorage()->getItemContents($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemMeta($id, $revision = null)
    {
        return $this->getStorage()->getItemMeta($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemName($id, $revision = null)
    {
        return $this->getStorage()->getItemName($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemType($id, $revision = null)
    {
        return $this->getStorage()->getItemType($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemSize($id, $revision = null)
    {
        return $this->getStorage()->getItemSize($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemPublicUrl($id, $revision = null)
    {
        return $this->getStorage()->getItemPublicUrl($id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function createItem($id, $file, array $meta = array(), $createDerivatives = true)
    {
        return $this->getStorage()->createItem($this, $id, $file, $meta);
    }

    /**
     * {@inheritdoc}
     */
    public function createItemFromContents($id, $contents, array $meta = array(), $createDerivatives = true)
    {
        return $this->getStorage()->createItemFromContents($this, $id, $contents, $meta);
    }

    /**
     * {@inheritdoc}
     */
    public function createItemInBackground(
        $id, $url, array $meta = array(), $createDerivatives = true, array $callbackData = array()
    ) {
//        $this->getBackgroundCreateQueue()->sendMessage();

        /** @todo Implement and use driver to send a message to the queue */
        var_dump($id, $url, $meta, $createDerivatives, $callbackData);
        exit;

        $this->getBackgroundDriver()->sendCreateMessage(
            $this, $id, $url, $meta, $createDerivatives, $callbackData
        );
    }

    /**
     * {@inheritdoc}
     */
    public function reportItemCreatedInBackground(ItemInterface $item, array $callbackData = array())
    {
        $this->getBackgroundDriver()->sendCompleteMessage(
            $this, $item->getId(), $item->getPublicUrl(), $item->getMeta(), $createDerivatives, $callbackData
        );
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItem($id)
    {
        // TODO: Implement deleteItem() method.
    }

    /**
     * {@inheritdoc}
     */
    public function destroyItem($id)
    {
        // TODO: Implement destroyItem() method.
    }

    /**
     * {@inheritdoc}
     */
    public function copyItem($id, $targetId, $withRevisions = true)
    {
        // TODO: Implement copyItem() method.
    }

    /**
     * {@inheritdoc}
     */
    public function refreshItem($id, array $meta = array(), $createDerivatives = true, $force = true)
    {
        // TODO: Implement refreshItem() method.
    }
}
