# rotronic-HC2-probes
A collection of python3 scripts for accessing HC2 family temperature / humidity probes of Rotronic

<p>It took much on-line research to finaly "talk" to these probes digitally, and without any other Rotronic equipment. It is possible to hook them using a simple 3.3/5V FTDI FT232RL based adapter such as https://www.sparkfun.com/products/9716 or similar board cheaper.</p>

<p>It is also possible to use such an adapter with <a href="https://www.rotronic.com/en/humidity-measurement-feuchtemessung-temperaturmessung/software/software.html">Rotronic's HW4 app</a> (windows only) in order to configure or calibrate the probes, without any additional software.</p>

<p>OrangePi / RaspberryPi UART ports also work great (tested), if you are looking for even more freedom!</p>

<h3>Pinout:</h3>
<ul>
<li><strong>Green:</strong> 3.3V or 5V - either will work</li>
<li><strong>Gray:</strong> Ground</li>
<li><strong>Red:</strong> RxD - connect to adapter's TxD</li>
<li><strong>Blue:</strong> TxD - connect to adapter's RxD</li>
</ul>
<p><strong>*</strong> Note that some cheap adapters have messed up RxD and TxD markings so if the script does not work try connecting them otherwise...</p>

<p>If you have lamp/lemp stack already installed, you can use read_sensor.py in a cron job to collect sensor readings in a mysql table. data.php retrives the last 24h' readings from the mysql table and index.php uses them to create a nice chart.</p>
