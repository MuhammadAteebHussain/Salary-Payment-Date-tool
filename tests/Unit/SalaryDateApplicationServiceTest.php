<?php

namespace Tests\Unit;

use App\Services\Application\SalaryDatesApplicationService;
use Tests\TestCase;

class SalaryDateApplicationServiceTest extends TestCase
{
    protected SalaryDatesApplicationService $salaryapplicationservice;
    protected array $data;
    public function setUp(): void
    {
        parent::setUp();
        $this->salaryapplicationservice = $this->app->make(SalaryDatesApplicationService::class);
        $this->data = array(
            'new_date' => false,
            'file_name' => "test",
        );
       
    }
    public function test_execute()
    {
        $this->salaryapplicationservice->execute($this->data);
        $this->assertTrue(true);
    }
}
