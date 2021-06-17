<?php

namespace AHT\Checkout\Observer;

class SubmitData implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Checkout\Model\Session
     */
    private $_checkoutSession;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_checkoutSession = $checkoutSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //get data
        $date = $this->_checkoutSession->getDate();
        $comment = $this->_checkoutSession->getComment();

        //get data from event observer
        $order = $observer->getEvent()->getOrder();
        $order->setData('delivery_comment', $comment);
        $order->setData('delivery_date', $date);
        $order->save();
    }
}
