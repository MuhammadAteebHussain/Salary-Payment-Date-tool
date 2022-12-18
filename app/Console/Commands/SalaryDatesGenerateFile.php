<?php

namespace App\Console\Commands;

use App\Services\Application\SalaryDatesApplicationService;
use Illuminate\Console\Command;

class SalaryDatesGenerateFile extends Command
{
    protected SalaryDatesApplicationService $salarydatesservice;
    public array | bool $previousdata = false;
    public string $filename = "";
    protected array $appconfig;
    protected string $reenterdate;
    protected string $filenamequestion;

    /**
     * 'Summary of __construct'
     * @param SalaryDatesApplicationService $salarydatesservice
     */
    public function __construct(SalaryDatesApplicationService $salarydatesservice)
    {
        $this->salarydatesservice = $salarydatesservice;
        $this->appconfig = config('custom')['salesremainder'];
        $this->reenterdate = $this->appconfig['questions']['reenterdate'];
        $this->filenamequestion = $this->appconfig['questions']['filename'];
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:sales_department_salary_dates_generate_file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate salary dates csv for sales department';

    /**
     * Summary of handle
     * The command is taking input filename
     * for generating sales remainder
     * salary and if any weekend found
     * for generating salries date then it will ask another date
     * @author MuhammadAteeb <muhammad_ateeb_hussain@hotmail.com>
     * @package SalaryDatesApplicationService->execute
     * @return bool
     */
    public function handle()
    {
        try {
            if (!$this->previousdata) {
                $this->filename = $this->ask($this->filenamequestion);
                $request['file_name'] = $this->filename;
                $result = $this->salarydatesservice->execute($request);
                $this->previousdata = $result;
                !$result['status'] ? $this->handle() : '';
            } else {
                if (!$this->previousdata['status']) {
                    $result = $this->previousdata;
                    $request['previous_data'] = $result['body'];
                    $request['new_date'] = $this->ask(sprintf($this->reenterdate, $result['body']['month']));
                    $request['file_name'] = $this->filename;
                    $result = $this->salarydatesservice->execute($request);
                    $this->previousdata = $result;
                    $this->handle();
                } else {
                    $this->info('The command was successful!');
                }
            }
            return true;
        } catch (\Exception $ex) {
            $this->error('Process terminated please check date format');
        }
    }
}
