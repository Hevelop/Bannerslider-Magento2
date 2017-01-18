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

namespace Magestore\Bannerslider\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magestore\Bannerslider\Model\ResourceModel\Report as ResourceModelReport;
use Magestore\Bannerslider\Model\ResourceModel\Report\Collection;

/**
 * Report Model
 * @category Magestore
 * @package  Magestore_Bannerslider
 * @module   Bannerslider
 * @author   Magestore Developer
 */
class Report extends AbstractModel
{
    /**
     * Report constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ResourceModelReport $resource
     * @param Collection $resourceCollection
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ResourceModelReport $resource,
        Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }
}
