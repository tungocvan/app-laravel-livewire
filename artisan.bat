@echo off
setlocal
for %%i in (%cd%) do set currentDirectory=%%~nxi
docker exec -d tnv-phpmyadmin php /var/www/laravel-workspace/%currentDirectory%/artisan %*
echo "Dong bo voi server..."
docker exec -d tnv-phpmyadmin bash /var/www/laravel-workspace/%currentDirectory%/dong-bo.sh
echo "Da Dong bo voi server..."
call dong-bo.bat
echo "Dong bo voi server da hoan thanh."
endlocal
