#!/usr/bin/python3
import sys, serial, math, mysql.connector, time
from datetime import datetime
argument=str(sys.argv).split('\'')
date_time=datetime.today().strftime('%Y-%m-%d %H:%M:%S')

if not len(sys.argv) == 2:
        print ('Which port is the probe connected to ? (eg. /dev/ttyS0)')
        raise SystemExit

def get_dew_point_c(t_air_c, rel_humidity):
    A = 17.27
    B = 237.7
    alpha = ((A * t_air_c) / (B + t_air_c)) + math.log(rel_humidity/100.0)
    return (B * alpha) / (A - alpha)

ser=serial.Serial(argument[3],
        baudrate=19200,
        bytesize=serial.EIGHTBITS,
        parity=serial.PARITY_NONE,
        stopbits=serial.STOPBITS_ONE,
        timeout=1)

ser.write(b'{ 99RDD}\r\n')
reply=ser.read(105).decode('ascii','ignore')
if not len(reply) == 103:
    	print('No response from sensor, exiting...')
   	raise SystemExit
ser.close()
value=reply.split(';')
temp=float(value[5])
rh=float(value[1])
dp=get_dew_point_c(temp, rh)

print('Probe readings:', round(temp,2), '°C  |', round(rh,2), '% rH  |  Dew Point: ', round(dp,2), '°C (calculated by this script)\r')

mydb = mysql.connector.connect(
  host="localhost",
  user="database_user",
  password="database_password",
  database="database")

mycursor = mydb.cursor()

sql = 'INSERT INTO database_table (date_time, temp, rh, dp) VALUES (%s, %s, %s, %s)'
val = (date_time, round(temp,2), round(rh,2), round(dp,2))

mycursor.execute(sql, val)
mydb.commit()
mydb.close()

print('Reading uploaded successfully!\r')
