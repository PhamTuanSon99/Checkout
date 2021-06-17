<?php
namespace AHT\Checkout\Controller\Index;

class SaveData extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

     /**
     * @param \Magento\Framework\Serialize\Serializer\Json
     */
    protected $_json;

    /**
     * @param \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_json = $json;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        //get data
        $data = $this->getRequest()->getContent();
        $response = $this->_json->unserialize($data);

        //set session data
        $date = $this->_checkoutSession->setDate($response['date']);
        $comment = $this->_checkoutSession->setComment($response['comment']);
    }
}