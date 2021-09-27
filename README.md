# ftt

![](https://cdn.discordapp.com/attachments/888970831491899392/892046482188935178/S8sIXL3.png)


*Packages required*

- RTL_433
- Screen
- inotifywait
- Tail
- PHP (Tested on 8.0)

*Frequencies*

We use several frequencies where the rtl_433 hops over, it will hop when a package is received or timer reaches 300 seconds.
These frequencies are used in most cases altho be different per country.

- 433.9Mhz
- 868.5Mhz
- 865Mhz
- 869.8Mhz
- 908.4Mhz
- 915Mhz
- 916Mhz
- 919.8Mhz
- 921.4Mhz
- 922.5Mhz
- 923.9Mhz
- 926Mhz

*Settings*

Change the webhook URL in the `config.inc.php` file

*Starting & Stopping*

Starting the application

`johndoe@linux:~/ftt$./start`

Stopping the application

`johndoe@linux:~/ftt$./stop`
