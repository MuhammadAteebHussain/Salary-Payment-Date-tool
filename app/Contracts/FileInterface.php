<?php

namespace App\Contracts;

/**
 * CSVFileService class
 * @package App\Service\General\CSVFileService
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */

interface FileInterface
{
    /**
     * Summary of createFile
     * @param string $filename
     * @return bool
     */
    public function createFile(string $filename): bool;
    /**
     * Summary of writeSalesRemainderFile
     * @param array $data
     * @param string $filename
     * @return string
     */
    public function writeSalesRemainderFile(array $data, string $filename): string;
}
