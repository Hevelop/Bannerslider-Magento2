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

namespace Magestore\Bannerslider\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magestore\Bannerslider\Model\BannerFactory;
use Magestore\Bannerslider\Model\ResourceModel\Banner\CollectionFactory;
use Magestore\Bannerslider\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;
use Magestore\Bannerslider\Model\SliderFactory;
use Magestore\Bannerslider\Model\ResourceModel\Banner\Collection;

/**
 * Abstract Action
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
abstract class AbstractAction extends Action
{
    const PARAM_CRUD_ID = 'entity_id';

    /**
     * @var Js
     */
    protected $_jsHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * A factory that knows how to create a "page" result
     * Requires an instance of controller action in order to impose page type,
     * which is by convention is determined from the controller action class.
     *
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Banner factory.
     *
     * @var BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Slider factory.
     *
     * @var SliderFactory
     */
    protected $_sliderFactory;

    /**
     * Banner Collection Factory.
     *
     * @var CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * Registry object.
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * File Factory.
     *
     * @var FileFactory
     */
    protected $_fileFactory;

    /**
     * @var Filter
     */
    protected $_massActionFilter;

    /**
     * @var UploaderFactory
     */
    protected $_uploaderFactory;

    /**
     * @var AdapterFactory
     */
    protected $_adapterFactory;
    /**
     * @param Context $context
     * @param BannerFactory $bannerFactory
     * @param SliderFactory $sliderFactory
     * @param CollectionFactory $bannerCollectionFactory
     * @param SliderCollectionFactory $sliderCollectionFactory
     * @param Registry $coreRegistry
     * @param FileFactory $fileFactory
     * @param PageFactory $resultPageFactory
     * @param LayoutFactory $resultLayoutFactory
     * @param ForwardFactory $resultForwardFactory
     * @param StoreManagerInterface $storeManager
     * @param Js $jsHelper
     */
    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        SliderFactory $sliderFactory,
        CollectionFactory $bannerCollectionFactory,
        SliderCollectionFactory $sliderCollectionFactory,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        PageFactory $resultPageFactory,
        LayoutFactory $resultLayoutFactory,
        ForwardFactory $resultForwardFactory,
        StoreManagerInterface $storeManager,
        Js $jsHelper,
        Filter $massActionFilter,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_storeManager = $storeManager;
        $this->_jsHelper = $jsHelper;
        $this->_massActionFilter = $massActionFilter;

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultForwardFactory = $resultForwardFactory;

        $this->_bannerFactory = $bannerFactory;
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_uploaderFactory = $uploaderFactory;
        $this->_adapterFactory = $adapterFactory;
    }


    /**
     * @return AbstractCollection
     *
     * @throws LocalizedException
     */
    protected function _createMainCollection()
    {
        /** @var AbstractCollection $collection */
        $collection = $this->_objectManager->create(Collection::class);
        if (!$collection instanceof AbstractCollection) {
            throw new LocalizedException(
                __(
                    '%1 isn\'t instance of Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection',
                    get_class($collection)
                )
            );
        }

        return $collection;
    }

    /**
     * Get back result redirect after add/edit.
     *
     * @param Redirect $resultRedirect
     * @param null                                          $paramCrudId
     *
     * @return Redirect
     */
    protected function _getBackResultRedirect(Redirect $resultRedirect, $paramCrudId = null)
    {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::PARAM_CRUD_ID => $paramCrudId,
                        '_current' => true,
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
