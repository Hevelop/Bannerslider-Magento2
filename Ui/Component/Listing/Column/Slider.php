<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Bannerslider
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\Bannerslider\Ui\Component\Listing\Column;

use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magestore\Bannerslider\Model\SliderFactory;
use Magestore\Bannerslider\Ui\Component\Listing\Column\AbstractColumn;

/**
 * @category Magestore
 * @package  Magestore_Storelocator
 * @module   Storelocator
 * @author   Magestore Developer
 */
class Slider extends AbstractColumn
{

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var SliderFactory
     */
    protected $_sliderFactory;

    /**
     * Constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param SliderFactory $sliderFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        SliderFactory $sliderFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
        $this->_sliderFactory = $sliderFactory;
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return array
     */
    protected function _prepareItem(array & $item)
    {
        $slider = $this->_sliderFactory->create()->load($item[$this->getData('name')]);

        if (isset($item[$this->getData('name')])) {
            if ($item[$this->getData('name')]) {

                $item[$this->getData('name')] = sprintf(
                    '%s',
                    $slider->getTitle()
                );
            } else {
                $item[$this->getData('name')] = '';
            }
        }

        return $item;
    }
}
