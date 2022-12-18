<?php

namespace App\Contracts;

/**
 * Summary of SalaryDateInterface
 * @package SalaryDateService
 */
interface SalaryDateInterface
{
    /**
     * Summary of createSalesDepartmentSalaryData
     * @param array $data
     * @return array
     */
    public function createSalesDepartmentSalaryData(array $data) : array;
    public function getAllMonthLastDayWeekendByYear(string $year) : array;
}
