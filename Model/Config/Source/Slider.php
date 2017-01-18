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
 * @copyright   Copyright (c) 2012-2016 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace Magestore\Bannerslider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magestore\Bannerslider\Model\SliderFactory;

class Slider implements ArrayInterface
{

    /**
     * @var SliderFactory
     */
    protected $sliderFactory;


    /**
     * Slider constructor.
     * @param SliderFactory $sliderFactory
     */
    public function __construct(
        SliderFactory $sliderFactory
    ) {
        $this->sliderFactory = $sliderFactory;
    }


    /**
     * @return array
     */
    public function getSliders()
    {
        $sliderModel = $this->sliderFactory->create();
        return $sliderModel->getCollection()->getData();
    }


    /**
     * @return array
     */
    public function toOptionArray()
    {
        $sliders = [];
        foreach ($this->getSliders() as $slider) {
            $sliders[] = [
                'value' => $slider['slider_id'],
                'label' => $slider['title']
            ];
        }
        return $sliders;
    }
}