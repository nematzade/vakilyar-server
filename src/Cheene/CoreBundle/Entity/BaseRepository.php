<?php

namespace Cheene\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class BaseRepository extends EntityRepository {
    const RANGE = 'range';
    const GT = 'gt';
    const LT = 'lt';
    const EQ = 'eq';
    const LIKE = 'like';

    /**
     * @param array $values
     * @param array|mixed $key
     */
    private function validateCriteria(array $values, $key)
    {
        if (is_array($key)) {
            foreach($key as $k) {
                $this->validateCriteria($values, $k);
            }
        } else {
            if (! array_key_exists($key, $values))
                throw new Exception("$key not exist in requested array!");
        }
    }
}