<?php
namespace Ddd\Time\Bridge\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ddd\Time\Factory\TimeIntervalFactory;

class TimeIntervalType extends Type
{
    const TIME_INTERVAL = 'timepoint_interval';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($timepointIntervalFromDatabase, AbstractPlatform $platform)
    {
        list($begin, $end) = explode(',', $timepointIntervalFromDatabase);

        return TimeIntervalFactory::create($begin, $end);
    }

    public function convertToDatabaseValue($timepointInterval, AbstractPlatform $platform)
    {
        if ($timepointInterval !== null) {
            $beginString = $timepointInterval->getBegin()->toDateTime()->format($platform->getDateTimeFormatString());
            $endString = $timepointInterval->getEnd()->toDateTime()->format($platform->getDateTimeFormatString());
        }

        return sprintf('%s,%s', $beginString, $endString);
    }

    public function getName()
    {
        return self::TIME_INTERVAL;
    }
}
