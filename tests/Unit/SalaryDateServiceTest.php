<?php

namespace Tests\Unit;

use App\Services\General\SalaryDateService;
use Tests\TestCase;

class SalaryDateServiceTest extends TestCase
{


    protected $currentmonth;
    protected array $appconfig;
    protected SalaryDateService $salarydateservice;
    protected array $currentdata;
    protected array $previousdata;
    protected $monthname;
    protected $year;
    protected $newdate;

    public function setUp(): void
    {
        parent::setUp();
        $this->salarydateservice = $this->app->make(SalaryDateService::class);
        $this->testfile = 'test.csv';
        $this->data = array(
            'new_date' => false,
            'file_name' => "test.csv",
        );
        $this->appconfig = config('custom')['salesremainder'];
        $this->monthname = 'January';
        $this->year = $this->appconfig['year'];
        $this->currentmonth = 1;
        $this->newdate = date('Y-m-d');
        $this->status = false;
        $this->previousdata = $this->data;
    }


    public function test_create_sales_department_data()
    {
        $this->salarydateservice->createSalesDepartmentSalaryData($this->data);
        $this->assertTrue(true);
    }

    public function test_get_salary_department_data()
    {

        $this->salarydateservice->getSalaryRemainderData(
            $this->monthname,
            $this->year,
            $this->currentmonth,
            $this->newdate,
            $this->status,
            $this->previousdata
        );
        $this->assertTrue(true);
    }

    public function test_get_actual_payment_remainder_date()
    {

        $currentmonthdetails = $this->salarydateservice->getSalaryRemainderData(
            $this->monthname,
            $this->year,
            $this->currentmonth,
            $this->newdate,
            $this->status,
            $this->previousdata
        );
        $this->salarydateservice->getActualPaymentRemainderDate(
            $currentmonthdetails,
            $this->newdate
        );
        $this->assertTrue(true);
    }

    public function test_get_bonus_remainder_data()
    {
        $this->salarydateservice->getBonusRemainderData(
            $this->year,
            $this->currentmonth
        );
        $this->assertTrue(true);
    }

    public function test_all_months_last_weekends()
    {
        $this->salarydateservice->getAllMonthLastDayWeekendByYear(
            $this->year
        );
        $this->assertTrue(true);
    }
}
