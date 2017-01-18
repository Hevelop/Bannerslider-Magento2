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

namespace Magestore\Bannerslider\Controller;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magestore\Bannerslider\Model\BannerFactory;
use Magestore\Bannerslider\Model\ReportFactory;
use Magestore\Bannerslider\Model\ResourceModel\Report\CollectionFactory;
use Magestore\Bannerslider\Model\SliderFactory;

/**
 * Index action
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
abstract class Index extends Action
{
    /**
     * Slider factory.
     *
     * @var SliderFactory
     */
    protected $_sliderFactory;

    /**
     * banner factory.
     *
     * @var BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Report factory.
     *
     * @var ReportFactory
     */
    protected $_reportFactory;

    /**
     * Report collection factory.
     *
     * @var CollectionFactory
     */
    protected $_reportCollectionFactory;

    /**
     * A result that contains raw response - may be good for passing through files
     * returning result of downloads or some other binary contents.
     *
     * @var RawFactory
     */
    protected $_resultRawFactory;


    /**
     * logger.
     *
     * @var Monolog
     */
    protected $_monolog;

    /**
     * stdlib timezone.
     *
     * @var Timezone
     */
    protected $_stdTimezone;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    /**
     * Index constructor.
     *
     * @param Context                                $context
     * @param SliderFactory                          $sliderFactory
     * @param BannerFactory                          $bannerFactory
     * @param ReportFactory                          $reportFactory
     * @param CollectionFactory $reportCollectionFactory
     * @param RawFactory                      $resultRawFactory
     * @param Monolog                                    $monolog
     * @param Timezone                          $stdTimezone
     */
    public function __construct(
        Context $context,
        SliderFactory $sliderFactory,
        BannerFactory $bannerFactory,
        ReportFactory $reportFactory,
        CollectionFactory $reportCollectionFactory,
        RawFactory $resultRawFactory,
        Monolog $monolog,
        Timezone $stdTimezone
    ) {
        parent::__construct($context);
        $this->_sliderFactory = $sliderFactory;
        $this->_bannerFactory = $bannerFactory;
        $this->_reportFactory = $reportFactory;
        $this->_reportCollectionFactory = $reportCollectionFactory;

        $this->_resultRawFactory = $resultRawFactory;
        $this->_monolog = $monolog;
        $this->_stdTimezone = $stdTimezone;
        $this->_objectManager = $context->getObjectManager();
    }


    public function getCookieManager(){
        return $this->_objectManager->create(CookieManagerInterface::class);
    }
    /**
     * get user code.
     *
     * @param mixed $id
     *
     * @return string
     */
    protected function getUserCode($id)
    {
        $ipAddress = $this->_objectManager->create(Request::class)->getClientIp(true);
        $cookiefrontend = $this->getCookieManager()->getCookie('frontend');
        $usercode = $ipAddress.$cookiefrontend.$id;

        return md5($usercode);
    }
}
