<?php
namespace Ddd\Time\Bridge\Doctrine\Types;

use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ddd\Time\Factory\DateFactory;

class DateType extends BaseDateType
{
    public function convertToPHPValue($dateFromDatabase, AbstractPlatform $platform)
    {
        $datetime = parent::convertToPHPValue($dateFromDatabase);

        return DateFactory::fromDateTime($datetime);
    }

    public function convertToDatabaseValue($date, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue($date->toDateTime());
    }
}
