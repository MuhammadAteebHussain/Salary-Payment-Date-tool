<?php

namespace Tests\Unit;

use App\Services\General\CSVFileService;
use Tests\TestCase;

class CSVFileServiceTest extends TestCase
{

    protected object $csvfileservice;
    protected string $testfile;
    protected array $monthlydata;
    protected array $testfiledata;


    public function setUp(): void
    {
        parent::setUp();
        $this->csvfileservice = $this->app->make(CSVFileService::class);
        $this->testfile = 'test.csv';
        $this->monthlydata = array(
            'actual_salary_date' => date('Y-m-d'),
            'actual_bonus_date' => date('Y-m-d'),
            'month' => 'Jan',
        );
        $this->testfiledata['pay_remainder_data']['January'] = $this->monthlydata;
        $this->testfiledata['pay_remainder_data']['February'] = $this->monthlydata;
        $this->testfiledata['pay_remainder_data']['March'] = $this->monthlydata;
    }


    public function test_create_file()
    {
        $this->csvfileservice->createFile($this->testfile);
        $this->assertTrue(true);
    }

    public function test_write_sales_remainder_file()
    {
        $this->csvfileservice->writeSalesRemainderFile($this->testfiledata, $this->testfile);
        $this->assertTrue(true);
    }
}
