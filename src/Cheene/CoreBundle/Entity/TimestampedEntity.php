<?php

namespace Cheene\CoreBundle\Entity;

interface TimestampedEntity {
    /**
     * Get created at
     *
     * @return \DateTime creation date
     */
    public function getCreatedAt();

    /**
     * Set created at
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get updated at
     *
     * @return \DateTime creation date
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
