<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ValidatorInterface $validator
    )
    {
    }

    /**
     * @param Category $category
     * @param bool $flush
     * @return Category|string
     */
    public function save(Category $category, bool $flush = false): string|Category
    {
        $errors = $this->validator->validate($category);

        if (count($errors) > 0) {
            return (string) $errors;
        }

        return $this->categoryRepository->save($category, $flush);
    }

    /**
     * @param $categoryEId
     * @return mixed
     */
    public function findByEId($categoryEId): mixed
    {
        return $this->categoryRepository->findOneBy([
            'eId' => $categoryEId
        ]);
    }
}
