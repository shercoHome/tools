@echo off
set str=154.92.176.180
for /f %%i in (fn.txt) do (echo F|(xcopy /s /e %str% %%i))