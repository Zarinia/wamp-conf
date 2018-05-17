set PATH=%~dp0\share\mcc\Python;%PATH%
set PYTHONLIB=%~dp0\share\mcc\Python\Lib

@ECHO ON
@"%~dp0\share\mcc\Python\python.exe" "%~dp0\bin\ndb_setup.py" -d DEBUG %*

