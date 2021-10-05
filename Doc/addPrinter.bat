rem first change the directory to the script location
cd %WINDIR%\System32\Printing_Admin_Scripts\en-US\
rem vbs script path: %WINDIR%\System32\Printing_Admin_Scripts\en-US\Prnmngr.vbs 

rem first add the port, specify name of port, assign it an IP Address, specify the type and the Port.
cscript prnport.vbs -a -r "LoopBack" -h 127.0.0.1 -o raw -n 9100
cscript prnport.vbs -a -r "LoopBack_2" -h 127.0.0.1 -o raw -n 9101
pause

rem specify the name of the new printer, specify the driver, specify the port it will use.
cscript prnmngr.vbs -a -p "VirtualPrinter" -m "ZDesigner LP 2844" -r "LoopBack"
pause

cscript prnmngr.vbs -a -p "Zebra  LP2844" -m "ZDesigner LP 2844" -r "USB0001"
rem cscript prnmngr.vbs -a -p "Zebra  GK420d" -m "ZDesigner GK420d" -r "LPT1:"
rem cscript prnmngr.vbs -a -p "Zebra  GC420d" -m "ZDesigner GC420d" -r "COM1:"
pause

NET STOP SPOOLER
NET START SPOOLER
pause