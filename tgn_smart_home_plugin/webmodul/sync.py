#python3 sync.py sync 1
#python3 sync.py 1 0

from tgnLIB import get_ip, read_eeprom
import paho.mqtt.client as mqtt
import urllib.request
import sys
import time

modul = []
user_key = ""
main_url = ""
sla_url = "/smart_home_bridge/com.php"
stat_list = ["Off","On"]
ROM_ADDRESS = 0x53
b1 = 0
b2 = 0
b3 = 0
b4 = 0
b5 = 0
b6 = 0
b7 = 0
b8 = 0
b9 = 0

modul_num = sys.argv[1]
modul_status = sys.argv[2]

try:
    print(">>Load id.config")
    f = open("/home/pi/tgn_smart_home/webmodul/id.config","r")
    for line in f:
        modul.append(line.rstrip())
except IOError:
    print("cannot open id.config.... file not found")
start_add_AAD = 0x2d
index = 0
user_key = ""
while index < 32:
    cach = read_eeprom(1,ROM_ADDRESS,0x03,start_add_AAD)
    if cach != "X":
        user_key = user_key + cach
    index = index + 1
    start_add_AAD = start_add_AAD + 1
start_add_AAD = 0x4e
index = 0
main_url = ""
while index < 50:
    cach = read_eeprom(1,ROM_ADDRESS,0x03,start_add_AAD)
    if cach != "X":
        main_url = main_url + cach
    index = index + 1
    start_add_AAD = start_add_AAD + 1
main_url = main_url + sla_url

def sync():
    print("Sync")
    client = mqtt.Client("Web_Modul")
    client.connect(get_ip())
    client.on_message=on_message
    client.loop_start()
    client.subscribe([("MQTChroma/*",1),("tgn/#",0)])
    time.sleep(2)
    client.loop_stop()
    bt_1 = main_url+"?api_key="+user_key+"&switch_id="+modul[1]+"&status="+stat_list[b1]
    bt_2 = main_url+"?api_key="+user_key+"&switch_id="+modul[2]+"&status="+stat_list[b2]
    bt_3 = main_url+"?api_key="+user_key+"&switch_id="+modul[3]+"&status="+stat_list[b3]
    bt_4 = main_url+"?api_key="+user_key+"&switch_id="+modul[4]+"&status="+stat_list[b4]
    bt_5 = main_url+"?api_key="+user_key+"&switch_id="+modul[5]+"&status="+stat_list[b5]
    bt_6 = main_url+"?api_key="+user_key+"&switch_id="+modul[6]+"&status="+stat_list[b6]
    bt_7 = main_url+"?api_key="+user_key+"&switch_id="+modul[7]+"&status="+stat_list[b7]
    bt_8 = main_url+"?api_key="+user_key+"&switch_id="+modul[8]+"&status="+stat_list[b8]
    bt_9 = main_url+"?api_key="+user_key+"&switch_id="+modul[9]+"&status="+stat_list[b9]
    get_url= urllib.request.urlopen(bt_1)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_2)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_3)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_4)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_5)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_6)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_7)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_8)
    print("Response Status: "+ str(get_url.getcode()) )
    get_url= urllib.request.urlopen(bt_9)
    print("Response Status: "+ str(get_url.getcode()) )

def sync_one():
    bt_1 = main_url+"?api_key="+user_key+"&switch_id="+modul[int(modul_num)]+"&status="+stat_list[int(modul_status)]
    get_url= urllib.request.urlopen(bt_1)
    print("Response Status: "+ str(get_url.getcode()) )

def on_message(client, userdata, message):
    global b9
    global b8
    global b7
    global b6
    global b5
    global b4
    global b3
    global b2
    global b1
    if(message.topic=="tgn/buttons/status/1"):
        b1 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/2"):
        b2 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/3"):
        b3 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/4"):
        b4 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/5"):
        b5 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/6"):
        b6 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/7"):
        b7 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/8"):
        b8 = int(message.payload.decode("utf-8"))
    if(message.topic=="tgn/buttons/status/9"):
        b9 = int(message.payload.decode("utf-8"))

if modul_num == "sync" and modul_status == "1":
    sync()
else:
    sync_one()