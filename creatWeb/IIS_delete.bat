@echo off
for /f "skip=1" %%i in (list/ajian_domain.txt) do (
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe delete site "%%i")
)