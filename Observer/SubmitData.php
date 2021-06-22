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
        $date = $this->_checkoutSession->getData('delivery_date');
        $comment = $this->_checkoutSession->getData('delivery_comment');

        //get data from event observer
        $order = $observer->getEvent()->getOrder();
        // var_dump($order);
        // die;

        $order->setData('delivery_note', $comment);
        $order->setData('delivery_date', $date);
        $order->save();
    }
}
