#!/usr/bin/python3
import sys, serial, math

argument=str(sys.argv).split('\'')

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
ser.close()

if not len(reply) == 103:
	print('No response from sensor, exiting...')
	raise SystemExit

value=reply.split(';')

temp=float(value[5])
rh=float(value[1])
dp=round(get_dew_point_c(temp, rh),2)
print('Probe readings:', temp,'°C  |', rh,'% rH  |  Dew Point: ', dp,'°C (calculated by this script)\r\n')
