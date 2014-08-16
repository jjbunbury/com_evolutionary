set DS=\
set FILETOZIP=*.*
set CURRENTPATH=%cd%
set ZIP_NAME=com_evolutionary-%date%.zip
set TEMPDIR=C:\%date%

rmdir %TEMPDIR%
mkdir %TEMPDIR%
xcopy /s %CURRENTPATH%%DS%%FILETOZIP% %TEMPDIR%
echo Set objArgs = WScript.Arguments > _zipIt.vbs
echo InputFolder = objArgs(0) >> _zipIt.vbs
echo ZipFile = objArgs(1) >> _zipIt.vbs
echo CreateObject("Scripting.FileSystemObject").CreateTextFile(ZipFile, True).Write "PK" ^& Chr(5) ^& Chr(6) ^& String(18, vbNullChar) >> _zipIt.vbs
echo Set objShell = CreateObject("Shell.Application") >> _zipIt.vbs
echo Set source = objShell.NameSpace(InputFolder).Items >> _zipIt.vbs
echo objShell.NameSpace(ZipFile).CopyHere(source) >> _zipIt.vbs
echo wScript.Sleep 2000 >> _zipIt.vbs
CScript  _zipIt.vbs  %TEMPDIR%  %CURRENTPATH%%DS%%ZIP_NAME%
pause