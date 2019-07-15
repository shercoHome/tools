@echo off
set str=temp
for /f %%i in (site_name_copy.txt) do (echo F|(xcopy /s /e %str% %%i))