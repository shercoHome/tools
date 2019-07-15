@echo off
set str=tempForCopy
for /f "skip=1" %%i in (list/ajian_domain.txt) do (echo F|(xcopy /s /e %str% "D:/wwwroot/%%i\"))