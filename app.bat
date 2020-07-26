@ECHO OFF

2>NUL CALL :CASE_%1
IF ERRORLEVEL 1 CALL :DEFAULT_CASE

ECHO Done!
EXIT /B

:CASE_build
    ECHO Removing temporary application files...
    @RD /S /Q "vendor"
    ECHO Stopping...
    docker-compose down -v > nul
    ECHO Building...
    docker-compose up -d --build > nul
    ECHO Installing composer dependencies...
    docker container exec -w /Site api_php composer install > nul
    GOTO END_CASE

:CASE_stop
    ECHO Stopping...
    docker-compose down > nul
    GOTO END_CASE

:CASE_start
    ECHO Starting...
    docker-compose up -d > nul
    GOTO END_CASE

:CASE_install
    ECHO Installing composer dependencies...
    docker container exec -w /Site api_php composer install > nul
    GOTO END_CASE

:CASE_dump
    ECHO Dumping autoload...
    docker container exec -w /Site api_php composer dump-autoload > nul
    GOTO END_CASE

:DEFAULT_CASE
    ECHO Unknown function "%1"
    GOTO END_CASE
:END_CASE
    VER > NUL
    GOTO :EOF