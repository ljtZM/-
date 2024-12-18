@echo off
chcp 65001 > nul
setlocal enabledelayedexpansion

echo ===========================================
echo Script execution begins, please follow the prompts...
echo ===========================================

:: Prompt user for MySQL password
set /p db_password=Please enter your MySQL password:

:: Create a temporary PowerShell script to update the database password
set tmp_ps1=%temp%\update-db-password.ps1
echo $mysql_password = '%db_password%' > %tmp_ps1%
echo $config_file_path = "backend/config/db.php" >> %tmp_ps1%
echo (Get-Content $config_file_path) ^| ForEach-Object {$_ -replace "'password' => ''", "'password' => '$mysql_password'"} ^| Set-Content $config_file_path >> %tmp_ps1%
echo Write-Host "Database password updated successfully!" >> %tmp_ps1%

:: Execute the PowerShell script with a temporary change to the execution policy
PowerShell -NoProfile -ExecutionPolicy Bypass -File %tmp_ps1%

:: Clean up the temporary PowerShell script
del %tmp_ps1%

:: Move to backend directory for Composer installation
cd backend
echo Installing Composer dependencies...
start /wait cmd /c "composer install && echo Composer installation completed! && exit"

echo Starting backend server...
start cmd /k "echo Starting PHP backend server... && php yii serve && echo Backend server started successfully!"

:: Return to the parent directory
cd /d "%~dp0"

:: Frontend deployment starts
echo ===========================================
echo Frontend deployment begins...
echo ===========================================

:: Enter frontend directory and install dependencies
cd my-frontend
echo Installing frontend dependencies...
start /wait cmd /c "npm install && npm install @fortawesome/fontawesome-free && echo Frontend dependencies installation completed! && exit"

:: Start frontend server
echo Starting frontend development server...
start cmd /k "set VUE_APP_PORT=8081 && npm run serve && echo Frontend server started successfully!"

:: Completion message
echo ===========================================
echo Script execution completed, frontend and backend services have been started.
echo ===========================================
pause
