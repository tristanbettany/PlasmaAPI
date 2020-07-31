@ECHO OFF

2>NUL CALL :CASE_%1
IF ERRORLEVEL 1 CALL :DEFAULT_CASE

ECHO Done!
EXIT /B

:CASE_build
    ECHO Removing temporary application files...
    @RD /S /Q "vendor"
    ECHO Stopping...
    docker-compose down -v > NUL
    ECHO Building...
    docker-compose up -d --build > NUL
    ECHO Installing composer dependencies...
    docker container exec -w /Site api_php composer install > NUL
    ECHO Migrating up...
    docker container exec -w /Site api_php ./propel migration:up
    ECHO Seeding database...
    docker container exec -w /Site api_php ./cli db:seed
    GOTO END_CASE

:CASE_stop
    ECHO Stopping...
    docker-compose down > NUL
    GOTO END_CASE

:CASE_start
    ECHO Starting...
    docker-compose up -d > NUL
    GOTO END_CASE

:CASE_install
    ECHO Installing composer dependencies...
    docker container exec -w /Site api_php composer install > NUL
    GOTO END_CASE

:CASE_update
    ECHO Updating composer dependencies...
    docker container exec -w /Site api_php composer update > NUL
    GOTO END_CASE

:CASE_dump
    ECHO Dumping autoload...
    docker container exec -w /Site api_php composer dump-autoload > NUL
    GOTO END_CASE

:CASE_seed
    ECHO Seeding database...
    docker container exec -w /Site api_php ./cli db:seed
    GOTO END_CASE

:CASE_diff
    ECHO Diffing database with schema...
    docker container exec -w /Site api_php ./propel migration:diff
    GOTO END_CASE

:CASE_up
    ECHO Migrating up...
    docker container exec -w /Site api_php ./propel migration:up
    GOTO END_CASE

:CASE_down
    ECHO Migrating down...
    docker container exec -w /Site api_php ./propel migration:down
    GOTO END_CASE

:DEFAULT_CASE
    ECHO Unknown function "%1"
    GOTO END_CASE
:END_CASE
    VER > NUL
    GOTO :EOF