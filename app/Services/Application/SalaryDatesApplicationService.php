<?php

namespace App\Services\Application;

use App\Services\Application\Contracts\ApplicationServiceInterface;
use App\Components\CustomStatusCodes;
use App\Contracts\{FileInterface,SalaryDateInterface};

/**
 * Summary of SalaryDatesApplicationService
 * By this application service we are generating final
 * data for csv and then send data to CSVFileService
 * @author MuhammadAteeb <muhammad_ateeb_hussain@hotmail.com>
 */
class SalaryDatesApplicationService implements ApplicationServiceInterface
{
    protected SalaryDateInterface $salarydateservice;
    protected FileInterface $fileService;

    /**
     * Summary of __construct
     * @param SalaryDateInterface $salarydateservice
     * @param FileInterface $fileService
     */
    public function __construct(
        SalaryDateInterface $salarydateservice,
        FileInterface $fileService
    ) {
        $this->salarydateservice = $salarydateservice;
        $this->fileService = $fileService;
    }

    /**
     * Summary of execute
     * @param mixed $request
     * @return array|object
     */
    public function execute(array $request): array | object
    {
        $data = $this->createData($request);
        $content = $this->salarydateservice->createSalesDepartmentSalaryData($data);
        if ($content['status']) {
            $this->fileService->createFile($request['file_name']);
            $this->fileService->writeSalesRemainderFile($content, $request['file_name']);
        }
        $result['code'] = CustomStatusCodes::SUCCESS;
        $result['message'] = CustomStatusCodes::SUCCESS_GENERAL_MESSAGE;
        $result['body'] = $content;
        $result['http_code'] = CustomStatusCodes::HTTP_SUCCESS_CODE;
        $result['status'] = $content['status'];
        return $result;
    }

    /**
     * Summary of createData
     * @param array $request
     * @return array
     */
    public function createData(array $request): array
    {
        return array(
            'new_date' =>  $request['new_date'] ?? false,
            'month' =>  $request['previous_data']['month'] ?? false,
            'month_int' => $request['previous_data']['month_int'] ?? false,
            'day' => $request['previous_data']['day'] ?? false,
            'date' => $request['previous_data']['date'] ?? false,
            'file_name' => $request['previous_data']['file_name'] ?? false,
            'salary_date_finzlized_data' => $request['previous_data']['salary_date_finzlized_data'] ?? false,
        );
    }
}
