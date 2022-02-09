<?php

namespace Pagarme\Pagarme\Block\Adminhtml\Marketplace;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Pagarme\Pagarme\Concrete\Magento2CoreSetup;
use stdClass;

class Recipient extends Template
{
    private $objectManager;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var array
     */
    private $sellers = [];

    /**
     * @var stdClass
     */
    private $recipient = null;

    /**
     * Link constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
        Registry $registry
    ){
        $this->coreRegistry = $registry;
        $this->objectManager = ObjectManager::getInstance();

        Magento2CoreSetup::bootstrap();
        parent::__construct($context, []);

        $recipientData = $this->coreRegistry->registry('recipient_data');
        if (!empty($recipientData)) {
            $this->recipient = json_decode($recipientData);
        }

        $sellerData = $this->coreRegistry->registry('sellers');
        if (!empty($sellerData)) {
            $this->sellers = unserialize($sellerData);
        }
    }

    public function getEditRecipient()
    {
        if (empty($this->recipient)) {
            return "";
        }

        return json_encode($this->recipient);
    }

    public function getSellers()
    {
        if (is_null($this->sellers)) {
            return [];
        }

        return $this->sellers;
    }
}
