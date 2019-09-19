<?php

namespace App\Http\OpenApi\Schema;

use cebe\openapi\SpecObjectInterface;
use cebe\openapi\Reader as BaseReader;

class Reader
{
    /**
     * @param  string $filename
     * @return \cebe\openapi\SpecObjectInterface
     * @throws \App\Http\OpenApi\Schema\UnreadableFileException
     * @throws \cebe\openapi\exceptions\TypeErrorException
     * @throws \cebe\openapi\exceptions\UnresolvableReferenceException
     */
    public static function read(string $filename)
    {
        switch (pathinfo($filename, PATHINFO_EXTENSION)) {
            case 'yml':
            case 'yaml':
                return static::readFromYaml($filename);

            case 'json':
                return static::readFromJson($filename);
        }

        throw new UnreadableFileException;
    }

    /**
     * @param  string $filename
     * @return \cebe\openapi\SpecObjectInterface
     * @throws \cebe\openapi\exceptions\TypeErrorException
     * @throws \cebe\openapi\exceptions\UnresolvableReferenceException
     */
    public static function readFromYaml(string $filename): SpecObjectInterface
    {
        return BaseReader::readFromYamlFile($filename);
    }

    /**
     * @param  string $filename
     * @return \cebe\openapi\SpecObjectInterface
     * @throws \cebe\openapi\exceptions\TypeErrorException
     * @throws \cebe\openapi\exceptions\UnresolvableReferenceException
     */
    public static function readFromJson(string $filename): SpecObjectInterface
    {
        return BaseReader::readFromJsonFile($filename);
    }
}
