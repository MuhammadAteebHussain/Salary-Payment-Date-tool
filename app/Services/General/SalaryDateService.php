<?php

namespace App\Services\General;

use App\Contracts\SalaryDateInterface;
use Carbon\Carbon;

/**
 * Summary of SalaryDateService
 *  Author Muhammad Ateeb Hussain
 * @package SalaryDateInterface
 */
class SalaryDateService implements SalaryDateInterface
{


    protected $currentmonthdetails;
    protected $actualsalarydate;
    protected Carbon $dateconfig;
    protected $appconfig;
    protected $listmonths;
    protected $weekdays;
    protected $weekends;
    protected $year;

    /**
     * Summary of __construct
     * @param Carbon $dateconfig
     */
    public function __construct(Carbon $dateconfig)
    {
        $this->dateconfig = $dateconfig;
        $this->appconfig = config('custom')['salesremainder'];
        $this->listmonths = $this->appconfig['listmonths'];
        $this->weekdays = $this->appconfig['weekdays'];
        $this->weekends = $this->appconfig['weekends'];
        $this->year = $this->appconfig['year'];
    }

    /**
     * Summary of createSalesDepartmentSalaryData
     * @param array $data
     * @return array
     */
    public function createSalesDepartmentSalaryData(array $data): array
    {
        $listmonths = $this->listmonths;
        $year = $this->year;
        $salarydata = array();
        $finaldata = array();
        if ($data['new_date']) {
            $listmonths = array_slice($listmonths, $data['month_int'] - 1);
            $salarydata = $data['salary_date_finzlized_data'];
        }
        foreach ($listmonths as $month) {

            $currentmonth = $month['number'];
            $monthname = $month['month'];
            $status = false;
            $currentmonthdetails = $this->getSalaryRemainderData(
                $monthname,
                $year,
                $currentmonth,
                $data['new_date'],
                $status,
                $salarydata
            );
            $actualsalarydate = $this->getActualPaymentRemainderDate($currentmonthdetails, $data['new_date']);
            if (!$actualsalarydate) {
                //process start again with finalization data if weekend found on last day
                return $currentmonthdetails;
            } else {
                $data['new_date'] = false;
            }
            $salarydata[$monthname]  = array(
                'actual_salary_date' => $actualsalarydate,
                'actual_bonus_date' => $this->getBonusRemainderData($year, $currentmonth),
                'month' => $monthname,
                'status' => $status,
            );
        }
        $finaldata['status'] = true;
        $finaldata['pay_remainder_data'] = $salarydata;
        return $finaldata;
    }

    /**
     * Summary of getSalaryRemainderData
     * @param mixed $monthname
     * @param mixed $year
     * @param mixed $currentmonth
     * @param mixed $data
     * @param mixed $status
     * @param mixed $previous_data
     * @return array
     */
    public function getSalaryRemainderData($monthname, $year, $currentmonth, $newdate, $status, $previous_data)
    {
        $salarymonth = $this->dateconfig->create($year, $currentmonth);
        $endmonth = $this->dateconfig->parse($salarymonth)->endOfMonth();
        $lastdaydate =   $endmonth->toDateString();
        $lastdaymonth =    $endmonth->dayName;

        return  array(
            'month' => $monthname,
            'month_int' => $currentmonth,
            'day' => $lastdaymonth,
            'date' => $lastdaydate,
            'file_name' => $newdate,
            'salary_date_finzlized_data' => $previous_data,
            'salary_month_object' => $salarymonth,
            'last_date' => $endmonth->toDateString(),
            'last_day' => $endmonth->dayName,
            'status' => $status,
        );
    }

    /**
     * Summary of getActualPaymentRemainderDate
     * @param array $currentmonthdetails
     * @param bool|string $newdate
     * @return bool|string
     */
    public function getActualPaymentRemainderDate(array $currentmonthdetails, bool|string $newdate)
    {
        if (!$newdate) {
            $actualdate = isset($this->appconfig['weekdays'][$currentmonthdetails['last_day']]) ?
                $this->dateconfig
                ->parse(
                    $currentmonthdetails['salary_month_object']->endOfMonth()
                )
                ->toDateString() : false;
        } else {
            $actualdate = $this->dateconfig->create($newdate)->toDateString();
            $newdate = false;
        }
        return $actualdate;
    }

    /**
     * Summary of getBonusRemainderData
     * @param mixed $year
     * @param mixed $currentmonth
     * @return string
     */
    public function getBonusRemainderData($year, $currentmonth)
    {
        $bonuscutofdate = $this->appconfig['bonuscutofdate'];
        $generalbonusdate = $this->dateconfig->create($year, $currentmonth, $bonuscutofdate);
        $bonuscutofday =   $this->dateconfig->parse($generalbonusdate)->dayName;
        return isset($this->appconfig['weekdays'][$bonuscutofday]) ?
            $this->dateconfig->parse($generalbonusdate)->toDateString() :
            $this->dateconfig->parse($generalbonusdate)->modify("next wednesday")
            ->toDateString();
    }

    public function getAllMonthLastDayWeekendByYear(string $year): array
    {
        $months = $this->listmonths;
        $lastdayweekendmonths = array();
        foreach ($months as $i => $month) {
            $salarymonth = $this->dateconfig->create($year, $month['number']);
            $endmonth = $this->dateconfig->parse($salarymonth)->endOfMonth();
            if (isset($this->weekends[$endmonth->dayName])) {
                $newrandomdate = $this->dateconfig->create($endmonth->toDateString());
                $lastdayweekendmonths[$i]['month'] =  $month['month'];
                $lastdayweekendmonths[$i]['random_date'] =  ($newrandomdate->addDays(3)->toDateString());
            }
        }
        return $lastdayweekendmonths;
    }
}
