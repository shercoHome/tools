@echo off
for /f %%i in (fnsite.txt) do (echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe add site /name:"%%i" /bindings:"http/%%i:80:" /physicalPath:%cd%\%%i))