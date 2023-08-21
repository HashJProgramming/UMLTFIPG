@echo off
title "HASH'J Programming"

set VENV_PATH=.venv\Scripts\activate.bat
call %VENV_PATH%
if %errorlevel% == 1 (
    color c
    echo [=====================================================[ERROR]=====================================================]
    echo [=                                                VENV IS NOT EXIST                                              =]
    echo [=================================================================================================================]
    set PY_EXE=%~dp0..\python.exe
    call %PY_EXE%
    python.exe -m pip install --upgrade pip
    python -m venv .venv
    call %VENV_PATH%
    pip install -r server/requirements.txt
    cls
    color b
    echo [====================================================[HASH'J]=====================================================]
    echo [=                                               UMLTFIPG System                                                 =]
    echo [=================================================================================================================]
    python server/app.py
    deactivate
    pause
) else (
    call %VENV_PATH%
    python.exe -m pip install --upgrade pip
    pip install -r server/requirements2.txt
    cls
    color b
    echo [====================================================[HASH'J]=====================================================]
    echo [=                                               UMLTFIPG System                                                 =]
    echo [=================================================================================================================]
    python server/app.py
    deactivate
    pause
)
