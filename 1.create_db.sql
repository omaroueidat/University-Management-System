USE master 
go

CREATE DATABASE univdb
ON 
( NAME = univdb,
  FILENAME = 'C:\Databases\univdb\univdb.mdf')
LOG ON
( NAME = 'univdb_log',
  FILENAME = 'C:\Databases\univdb\univdb.ldf')

go