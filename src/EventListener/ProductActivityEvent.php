<?php

namespace App\EventListener;

use App\Entity\Product;
use App\Service\EmailService;

class ProductActivityEvent
{
    /**
     * @param EmailService $emailService
     */
    public function __construct(protected EmailService $emailService)
    {
    }

    /**
     * @param Product $product
     */
    public function postPersist(Product $product)
    {
        $this->emailService->setSubject("New Product {$product->getTitle()} has been created");
        //$this->emailService->send();
    }

    /**
     * @param Product $product
     */
    public function postUpdate(Product $product): void
    {
        $this->emailService->setSubject("The product {$product->getTitle()} has been updated");
        //$this->emailService->send();
    }

    /**
     * @param Product $product
     */
    public function postRemove(Product $product): void
    {
        $this->emailService->setSubject("The product {$product->getTitle()} has been removed");
        //$this->emailService->send();
    }
}
