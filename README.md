#  Salary Payment Date tool CSV

Salary Payment Date is a CLI tool utility to help a fictional company determine the dates they need to pay salaries to their sales department. This tool takes input filename and after taking filename input the tool start processing for creating sales department salaries pay dates with bonus for the whole year(we can configure year in .env file). The salary cut of date is the last day of month (If not weekend) and the bonus cut of date is 15th (If not weekend but date can bhe change by by .env file) of every month . In Salary case if weekend found so tool will asked to user a new date. It can be any date But if user will send wrong input then process will be terminated. In bonus case if cut of date will be on weekend so date will automatically set the next wednesday after cut of date. 

The tool is based on Laravel 9. It is completelty based on dockerize environment so you have no worried about setup.

## Clone Project

Use the below link for cloning.

```bash
git clone https://github.com/MuhammadAteebHussain/salary_payment_date_tool.git
```

## Installation
Note: make sure you have install docker and docker-compose latest
  Copy .env.example (currently you will get .env) to .env 

## 
- stop any previous development environment

```bash
docker-compose -f docker-compose.yml down --remove-orphans
docker-compose -f docker-compose.yml rm -f -s
```
## 
- starting development environment please make sure check the ports in docker-compose.yml
```bash
docker-compose up -d --build
```
## 
- For checking your containers status.
```bash
docker-compose ps -a
```
## 
- Enter in the PHP container by using the below command.
```bash
docker exec -it salary_dates_creator_backend_php  bash
```
##
- give write access to storage directory
##
-  Then RUN Command
```bash
composer install
composer dumpautload -o
```

## Running Project

##
- RUN Unit tests it will also return code coverage that is more than 86%
```bash
XDEBUG_MODE=coverage php artisan test --coverage
```
- after running that command you will see unit/feature test execution. the generated file by unit tests you can see in  public/files/ directory.

##
- For Custom file generation you can run the below command.
```bash
php artisan salary:sales_department_salary_dates_generate_file
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
