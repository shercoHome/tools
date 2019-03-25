@echo off
set str=update
for /f %%i in (fn.txt) do (echo F|(xcopy /y /s /e %str% %%i))