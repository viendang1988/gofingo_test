<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected ValidatorInterface $validator
    )
    {
    }

    /**
     * @param Product $product
     * @param bool $flush
     * @return Product|string
     */
    public function save(Product $product, bool $flush = false): Product|string
    {
        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
            return (string) $errors;
        }

        return $this->productRepository->save($product, $flush);
    }

    /**
     * @param Product $product
     * @param bool $flush
     */
    public function remove(Product $product, bool $flush = false)
    {
        $this->productRepository->remove($product, $flush);
    }

    /**
     * @param $productEId
     * @return mixed
     */
    public function findByEId($productEId): mixed
    {
        return $this->productRepository->findOneBy([
            'eId' => $productEId
        ]);
    }
}
