<?php
namespace Ddd\Time\Bridge\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ddd\Time\Factory\DateIntervalFactory;

class DateIntervalType extends Type
{
    const DATE_INTERVAL = 'date_interval';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($dateIntervalFromDatabase, AbstractPlatform $platform)
    {
        list($begin, $end) = explode(',', $dateIntervalFromDatabase);

        return DateIntervalFactory::create($begin, $end);
    }

    public function convertToDatabaseValue($dateInterval, AbstractPlatform $platform)
    {
        if ($dateInterval !== null) {
            $beginString = $dateInterval->getBegin()->toDateTime()->format($platform->getDateFormatString());
            $endString = $dateInterval->getEnd()->toDateTime()->format($platform->getDateFormatString());
        }

        return sprintf('%s,%s', $beginString, $endString);
    }

    public function getName()
    {
        return self::DATE_INTERVAL;
    }
}
