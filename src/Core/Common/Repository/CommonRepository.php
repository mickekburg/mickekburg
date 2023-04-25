<?php

namespace Core\Common\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class CommonRepository extends EntityRepository implements ICommonRepository
{
    public function getParents(int $item_id): array
    {
        $results = [];
        $entity_manager = $this->getEntityManager();
        $entity = $this->find($item_id);
        $table = $entity_manager->getClassMetadata(get_class($entity))->getTableName();
        try {
            $parent = $entity->getParent();
            $table_parent = $entity_manager->getClassMetadata(get_class($parent))->getTableName();
            $sql = "
                SELECT T2.id 
                FROM (
                    SELECT
                        @r AS _id,
                        (SELECT @r := parent_id FROM " . $table_parent . " WHERE id = _id) AS parent_id,
                        @l := @l + 1 AS lvl
                    FROM
                        (SELECT @r := " . $parent->getId() . ", @l := 0) vars,
                        " . $table_parent . " m
                    WHERE @r <> 0) T1
                JOIN " . $table_parent . " T2
                ON T1._id = T2.id
                ORDER BY T1.lvl DESC;
            ";
            $rsm = new ResultSetMappingBuilder($entity_manager);
            $rsm->addEntityResult(get_class($parent), 'T2');
            $rsm->addFieldResult('T2', 'id', 'id');
            $query = $entity_manager->createNativeQuery($sql, $rsm);
            $results = $query->getResult();
        } catch (\Exception) {

        }
        return $results;
    }

}