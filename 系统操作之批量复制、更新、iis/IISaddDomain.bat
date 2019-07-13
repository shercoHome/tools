@echo off
for /f %%i in (fnsite.txt) do (
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe add site /name:"%%i" /physicalPath:%cd%\%%i)
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe set site /site.name:"%%i" /+bindings.[protocol='http',bindingInformation='*:80:%%i'])
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe set site /site.name:"%%i" /+bindings.[protocol='http',bindingInformation='*:80:www.%%i'])
)