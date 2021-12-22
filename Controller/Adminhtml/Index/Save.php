<?php

namespace Codilar\HelloWorld\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Action;
use Codilar\Employee\Model\EmployeeFactory as ModelFactory;
use Codilar\Employee\Model\ResourceModel\Employee as ResourceModel;
use Magento\Framework\App\Action\Context;

class Save extends Action
{
    /**
     * @var ModelFactory
     */
    protected $modelFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    public function __construct(
        Context $context,
        ModelFactory $modelFactory,
        ResourceModel $resourceModel
    )
    {
        parent::__construct($context);
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $emptyEmp = $this->modelFactory->create();
        if(!empty($data['entity_id'])){
            $this->resourceModel->load($emptyEmp,$data['entity_id']);
        }
        $emptyEmp->setFirstname($data['firstname'] ?? null);
        $emptyEmp->setLastname($data['lastname'] ?? null);
        $emptyEmp->setEmail($data['email'] ?? null);
        $emptyEmp->setMobile($data['mobile'] ?? null);
        $emptyEmp->setDate($data['date'] ?? null);
        $emptyEmp->setAddress($data['address'] ?? null);
        $this->resourceModel->save($emptyEmp);
        $this->messageManager->addSuccessMessage(__('%1 saved successfully', $emptyEmp->getFirstname()));
        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
