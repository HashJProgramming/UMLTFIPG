@echo off
title "UMLTFIPG System"

set VENV_PATH=.venv\Scripts\activate.bat
call %VENV_PATH%
if %errorlevel% == 1 (
    color c
    echo [=====================================================[ERROR]=====================================================]
    echo [=                                                VENV IS NOT EXIST                                              =]
    echo [=================================================================================================================]
    set PY_EXE=%~dp0..\python.exe
    call %PY_EXE%
    python -m venv .venv
    call %VENV_PATH%
    pip install -r server/requirements.txt
    cls
    color b
    echo [====================================================[SERVER]=====================================================]
    echo [=                                               UMLTFIPG System                                                 =]
    echo [=================================================================================================================]
    python -c "import sys; assert sys.version_info >= (3, 12, 0), 'Python version must be 3.12.0 or higher.'"
    python server/app.py
    pause
) else (
    call %VENV_PATH%
    pip install -r server/requirements.txt
    cls
    color b
    echo [====================================================[SERVER]=====================================================]
    echo [=                                               UMLTFIPG System                                                 =]
    echo [=================================================================================================================]
    python -c "import sys; assert sys.version_info >= (3, 12, 0), 'Python version must be 3.12.0 or higher.'"
    python server/app.py
    pause
)
