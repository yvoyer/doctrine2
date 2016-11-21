<?php

namespace Doctrine\Tests\ORM\Persisters;

use Doctrine\ORM\Persisters\Entity\JoinedSubclassPersister;
use Doctrine\Tests\OrmTestCase;

/**
 * Tests for {@see \Doctrine\ORM\Persisters\Entity\JoinedSubclassPersister}
 *
 * @covers \Doctrine\ORM\Persisters\Entity\JoinedSubclassPersister
 */
class JoinedSubClassPersisterTest extends OrmTestCase
{
    /**
     * @var JoinedSubclassPersister
     */
    protected $persister;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->em = $this->_getTestEntityManager();

        $this->persister = new JoinedSubclassPersister(
            $this->em,
            $this->em->getClassMetadata('Doctrine\Tests\Models\JoinedInheritanceType\RootClass')
        );
    }

    /**
     * @group DDC-3470
     */
    public function testExecuteInsertsWillReturnEmptySetWithNoQueuedInserts()
    {
        $this->assertSame(array(), $this->persister->executeInserts());
    }
}
