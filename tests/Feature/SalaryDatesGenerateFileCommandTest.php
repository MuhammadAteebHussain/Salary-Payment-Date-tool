<?php

namespace Tests\Feature;

use App\Contracts\SalaryDateInterface;
use App\Services\General\SalaryDateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryDatesGenerateFileCommandTest extends TestCase
{

    protected object $salarydateservice;
    protected $appconfig;
    protected $filename;
    protected array $weekendmonths;
    protected string $reenterdatequestion;
    protected string $filenamequestion;
    protected string $wrongdate;
    

    public function setUp(): void
    {
        parent::setUp();
        $this->salarydateservice = $this->app->make(SalaryDateInterface::class);
        $this->appconfig = config('custom')['salesremainder'];
        $year = $this->appconfig['year'];
        $this->weekendmonths =  $this->salarydateservice->getAllMonthLastDayWeekendByYear($year);
        $this->reenterdatequestion = $this->appconfig['questions']['reenterdate'];
        $this->filenamequestion = $this->appconfig['questions']['filename'];
        $this->filename = $year.'_'.rand().'_final';
        $this->wrongdate = '20222222222';
    }

   
    /**
     * Summary of test_salarysheet_generate_command
     * @return void
     */
    public function test_salarysheet_generate_command()
    {
        $result = $this->artisan('salary:sales_department_salary_dates_generate_file');
        $result->expectsQuestion($this->filenamequestion, $this->filename);
        foreach ($this->weekendmonths as $month) {
            $result->expectsQuestion(sprintf($this->reenterdatequestion, $month['month']), $month['random_date']);
        }
        $result->assertExitCode(1);
    }
}
