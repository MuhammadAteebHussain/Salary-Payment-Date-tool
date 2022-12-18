<?php
namespace App\Services\General;

use App\Contracts\FileInterface;

/**
 * CSVFileService class
 * @package App\Contracts\FileInterface
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
class CSVFileService  implements FileInterface
{

  protected $path;
  protected $extension = '.csv';
  protected $appconfig;
  
  public function __construct()
  {
    $this->appconfig = config('custom')['salesremainder'];
    $this->path = $this->appconfig['storage_paths']['path'];
  }
  
  /**
   * createFile function
   *
   * @param string $filename
   * @return boolean
   */
  public function createFile(string $filename): bool
  {
    $filename =  public_path($this->path . $filename);
    $creaated = file_put_contents($filename.$this->extension, "");
    return $creaated ? true : false;
  }

  /**
   * createFile function
   *
   * @param string $data
   * @param string $file_name
   * @return boolean
   */
  public function writeSalesRemainderFile(array $data, string $filename): string
  {
    $filename =  public_path($this->path. $filename.$this->extension);
    $handle = fopen($filename, 'w');
    fputcsv($handle, [
      "Month",
      "Salary Date",
      "Bonus Date",
    ]);
    foreach ($data['pay_remainder_data'] as $sheetdata) {
      fputcsv($handle, [
        $sheetdata['month'],
        $sheetdata['actual_salary_date'],
        $sheetdata['actual_bonus_date'],
      ]);
    }
    fclose($handle);
    return $filename;
  }

}
