@ECHO OFF

2>NUL CALL :CASE_%1
IF ERRORLEVEL 1 CALL :DEFAULT_CASE

ECHO Done!
EXIT /B

:CASE_rebuild
    ECHO Rebuilding...
    docker-compose down -v > nul
    docker-compose up -d --build > nul
    GOTO END_CASE

:CASE_down
    ECHO Bringing Down...
    docker-compose down -v > nul
    GOTO END_CASE

:CASE_up
    ECHO Bringing Up...
    docker-compose up -d --build > nul
    GOTO END_CASE

:DEFAULT_CASE
    ECHO Unknown function "%1"
    GOTO END_CASE
:END_CASE
    VER > NUL
    GOTO :EOF