<?php

namespace Doctrine\Tests\ORM\Functional;

use Doctrine\Tests\Models\CMS\CmsUser;
use Doctrine\Tests\Models\CMS\CmsPhonenumber;
use Doctrine\Tests\Models\CMS\CmsAddress;
use Doctrine\Tests\Models\CMS\CmsArticle;
use Doctrine\ORM\UnitOfWork;

/**
 * Description of DetachedEntityTest
 *
 * @author robo
 */
class DetachedEntityTest extends \Doctrine\Tests\OrmFunctionalTestCase
{
    protected function setUp() {
        $this->useModelSet('cms');
        parent::setUp();
    }

    /**
     * @group DDC-203
     */
    public function testDetachedEntityThrowsExceptionOnFlush()
    {
        $ph = new CmsPhonenumber();
        $ph->phonenumber = '12345';
        $this->_em->persist($ph);
        $this->_em->flush();
        $this->_em->clear();
        $this->_em->persist($ph);
        try {
            $this->_em->flush();
            $this->fail();
        } catch (\Exception $expected) {}
    }

    /**
     * @group DDC-822
     */
    public function testUseDetachedEntityAsQueryParameter()
    {
        $user = new CmsUser;
        $user->name = 'Guilherme';
        $user->username = 'gblanco';
        $user->status = 'developer';

        $this->_em->persist($user);

        $this->_em->flush();
        $this->_em->detach($user);

        $dql = "SELECT u FROM Doctrine\Tests\Models\CMS\CmsUser u WHERE u.id = ?1";
        $query = $this->_em->createQuery($dql);
        $query->setParameter(1, $user);

        $newUser = $query->getSingleResult();

        $this->assertInstanceOf('Doctrine\Tests\Models\CMS\CmsUser', $newUser);
        $this->assertEquals('gblanco', $newUser->username);
    }

    /**
     * @group DDC-920
     */
    public function testDetachManagedUnpersistedEntity()
    {
        $user = new CmsUser;
        $user->name = 'Guilherme';
        $user->username = 'gblanco';
        $user->status = 'developer';

        $this->_em->persist($user);
        $this->_em->detach($user);

        $this->_em->flush();

        $this->assertFalse($this->_em->contains($user));
        $this->assertFalse($this->_em->getUnitOfWork()->isInIdentityMap($user));
    }
}

