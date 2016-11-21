<?php

namespace Doctrine\Tests\Models\DDC869;

/**
 * @MappedSuperclass(repositoryClass = "Doctrine\Tests\Models\DDC869\DDC869PaymentRepository")
 */
class DDC869Payment
{

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="float") */
    protected $value;


    public static function loadMetadata(\Doctrine\ORM\Mapping\ClassMetadataInfo $metadata)
    {
        $metadata->mapField(array(
           'id'         => true,
           'fieldName'  => 'id',
           'type'       => 'integer',
           'columnName' => 'id',
        ));
        $metadata->mapField(array(
           'fieldName'  => 'value',
           'type'       => 'float',
        ));
        $metadata->isMappedSuperclass = true;
        $metadata->setCustomRepositoryClass("Doctrine\Tests\Models\DDC869\DDC869PaymentRepository");
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadataInfo::GENERATOR_TYPE_AUTO);
    }

}
