@echo off
setlocal

for %%i in (%cd%) do set currentDirectory=%%~nxi

docker exec -d tnv-phpmyadmin cp /var/www/local-pc/laravel-workspace/%currentDirectory%/default-window.prf /root/.unison/default.prf
docker exec -d tnv-phpmyadmin cp /var/www/local-pc/laravel-workspace/%currentDirectory%/default-window.prf /root/default.prf
docker exec -d tnv-phpmyadmin unison
endlocal
