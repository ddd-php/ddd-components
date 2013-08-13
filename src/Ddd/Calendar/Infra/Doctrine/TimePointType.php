<?php
namespace Ddd\Calendar\Infra\Doctrine;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Ddd\Time\Factory\TimePointFactory;

/**
 * My custom datatype.
 */
class TimePointType extends Type
{
    const TIMEPOINT = 'timepoint';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getDateTimeTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $dtime = \DateTime::createFromFormat($platform->getDateTimeFormatString(), $value);
        if (!$dtime) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return TimePointFactory::fromDateTime($dtime);
    }

    public function convertToDatabaseValue($timepoint, AbstractPlatform $platform)
    {
        if ($timepoint !== null) {
            $dtime = $timepoint->asPHPDateTime();
            return $dtime->format($platform->getDateTimeFormatString());
        }
    }

    public function getName()
    {
        return self::TIMEPOINT;
    }
}
