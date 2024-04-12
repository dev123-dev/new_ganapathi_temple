@ECHO OFF

for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set "dt=%%a"
set "YY=%dt:~2,2%" & set "YYYY=%dt:~0,4%" & set "MM=%dt:~4,2%" & set "DD=%dt:~6,2%"
set "HH=%dt:~8,2%" & set "Min=%dt:~10,2%" & set "Sec=%dt:~12,2%"

set "datestamp=%DD%_%MM%_%YYYY%" & set "timestamp=%HH%_%Min%_%Sec%"

"E:\xampp\mysql\bin\mysqldump.exe" --databases pinnac23_SLVT --result-file="E:\xampp\htdocs\SLVT\application\AutoBackup\%datestamp%_%timestamp%.sql" --user=root --password=