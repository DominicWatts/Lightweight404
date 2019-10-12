<?php


namespace Xigen\NotFound\Block\Not;

/**
 * Class Found
 * @package Xigen\NotFound\Block\Not
 */
class Found extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * Found constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->pageFactory = $pageFactory;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->filterProvider = $filterProvider;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPageId()
    {
        $storeId = $this->storeManager->getStore()->getId();
        return $this->scopeConfig->getValue(
            \Magento\Cms\Helper\Page::XML_PATH_NO_ROUTE_PAGE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getContent()
    {
        $page = $this->pageFactory->create()->load($this->getPageId());
        if ($page) {
            return $this->getCmsFilterContent($page->getContent());
        }
        return null;
    }

    /**
     * @param $content
     * @return string
     * @throws \Exception
     */
    public function getCmsFilterContent($content)
    {
        return $this->filterProvider->getPageFilter()->filter($content);
    }
}
