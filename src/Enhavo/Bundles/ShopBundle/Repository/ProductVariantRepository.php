<?php
/**
 * Created by PhpStorm.
 * User: philippsester
 * Date: 16.09.20
 * Time: 11:42
 */

namespace Enhavo\Bundle\ShopBundle\Repository;

use Enhavo\Bundle\ResourceBundle\Filter\FilterQuery;
use Enhavo\Bundle\ResourceBundle\Repository\FilterRepositoryInterface;
use Enhavo\Bundle\ResourceBundle\Repository\FilterRepositoryTrait;
use Enhavo\Bundle\ShopBundle\Model\ProductInterface;
use Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductVariantRepository as SyliusProductVariantRepository;

class ProductVariantRepository extends SyliusProductVariantRepository implements FilterRepositoryInterface
{
    use FilterRepositoryTrait;

    public function findByProductId($productId, FilterQuery $filterQuery)
    {
        $filterQuery->addWhere('product',FilterQuery::OPERATOR_EQUALS, $productId);
        return $this->filter($filterQuery);
    }

    public function findByOptionValues(array $optionValues, ProductInterface $product = null)
    {
        $ids = [];
        foreach ($optionValues as $optionValue) {
            $ids[] = $optionValue->getId();
        }

        $qb = $this->createQueryBuilder('pv')
            ->select('pv, count(ov.id) as ocount')
            ->join('pv.optionValues', 'ov')
            ->andWhere('ov.id IN (:optionValues)')
            ->groupBy('pv.id')
            ->having('ocount = :length')
            ->setParameter('optionValues', $ids)
            ->setParameter('length', count($ids))
        ;

        if ($product) {
            $qb->join('pv.product', 'p');
            $qb->andWhere('p.id = :productId');
            $qb->setParameter('productId', $product->getId());
        }

        $result = $qb->getQuery()->getResult();

        $values = [];
        foreach ($result as $entry) {
            $values[] = $entry[0];
        }
        return $values;
    }
}

