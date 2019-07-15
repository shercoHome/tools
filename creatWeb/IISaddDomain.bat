@echo off
for /f "skip=1" %%i in (list/ajian_domain.txt) do (
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe add site /name:"%%i" /physicalPath:D:\wwwroot\%%i)
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe set site /site.name:"%%i" /+bindings.[protocol='http',bindingInformation='*:80:%%i'])
echo F|(%systemroot%/system32/Inetsrv/APPCMD.exe set site /site.name:"%%i" /+bindings.[protocol='http',bindingInformation='*:80:www.%%i'])
)