<?php 

namespace Bjit\ReusableLib\Utils;

use Bjit\ReusableLib\Enums\ReusableLibEnum;

final class CmnUtil 
{
    public static function fileExistsWithPattern($pattern)
    {
        $pattern = str_replace('.stub', '.php', $pattern);
        if (count(glob($pattern)) > ReusableLibEnum::DEFAULT_ZERO) {
            return true;
        }
        return false;
    }

    public static function duplicateFileWithPattern($pattern)
    {
        if (count(glob($pattern)) > ReusableLibEnum::DEFAULT_ONE) {
            return true;
        } 
        return false;
    }
}