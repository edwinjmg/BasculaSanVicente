echo off
c:\xampp\mysql\bin\mysqldump.exe -hlocalhost -uroot -ptoor datos_bodega_nueva > C:\Users\SISTEMAA\OneDrive\Documentos\Programa_Bascula\copia_seguridad_SI_los_venados_%date:~-4%_%date:~8,2%_.sql
exit