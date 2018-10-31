<?php

namespace App\Type;

use App\Codebreaker\Code;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class CodeType extends StringType
{
    const CODEBREAKER_CODE = 'codebreaker_code';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        return Code::fromGuess(parent::convertToPHPValue($value, $platform));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function getName()
    {
        return self::CODEBREAKER_CODE;
    }
}
