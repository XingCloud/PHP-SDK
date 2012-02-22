@echo off
cd %~dp0
SETLOCAL EnableDelayedExpansion

SET currentPath=%~dp0
for %%x in ("%currentPath%") do set currentPath=%%~sx

%currentPath%wget.exe --no-check-certificate -t 3 -O gameengine.zip https://github.com/XingCloud/PHP-SDK/zipball/master

%currentPath%7z.exe -y x gameengine.zip -ogameengine/

for /f "tokens=* delims=" %%i in ('dir /B %currentPath%gameengine') do (
	xcopy /s /h /d /y /exclude:exclude.txt "%currentPath%gameengine\%%i\*.*" "%currentPath%\..\" 
)

del %currentPath%gameengine.zip

rd /s /q %currentPath%gameengine

ENDLOCAL