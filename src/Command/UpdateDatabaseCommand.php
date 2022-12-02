<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Product;
use App\Service\CategoryService;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:update-database',
    description: 'Read from json file and update into database',
)]
class UpdateDatabaseCommand extends Command
{
    /**
     * @param ProductService $productService
     * @param CategoryService $categoryService
     * @param EntityManagerInterface $entityManager
     * @param string|null $name
     */
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected EntityManagerInterface $entityManager,
        string $name = null
    )
    {
        parent::__construct($name);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categories = file_get_contents('resources/categories.json');
        $categories = json_decode($categories, true);

        $products = file_get_contents('resources/products.json');
        $products = json_decode($products, true);

        $categoryEntities = [];
        foreach ($categories as $category) {
            $categoryEId = $category['eId'];

            //check existing category ?
            $categoryEntity = $this->categoryService->findByEId($categoryEId);

            if (empty($categoryEntity)) {
                $categoryEntity = new Category($categoryEId);
            }

            $categoryEntity->setTitle($category['title']);

            $categoryEntity = $this->categoryService->save($categoryEntity);

            if ($categoryEntity instanceof Category) {
                $categoryEntities[$categoryEId] = $categoryEntity;
            }
        }

        foreach ($products as $product) {
            $productEId = $product['eId'];

            //check existing product ?
            $productEntity = $this->productService->findByEId($productEId);

            if (empty($productEntity)) {
                $productEntity = new Product($product['eId']);
            }

            $productEntity->setTitle($product['title']);
            $productEntity->setPrice($product['price']);

            $productEntity = $this->productService->save($productEntity);

            if ($productEntity instanceof Product) {
                $categoriesEId = $product['categoriesEId'];
                foreach ($categoriesEId as $categoryEId) {
                    if (!empty($categoryEntities[$categoryEId])) {
                        $productEntity->addCategory($categoryEntities[$categoryEId]);
                    }
                }
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
