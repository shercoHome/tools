@echo off
for /f %%i in (site_name.txt) do (
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe delete site "%%i")
)