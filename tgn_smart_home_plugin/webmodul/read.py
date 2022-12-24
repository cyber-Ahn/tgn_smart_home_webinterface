from tgnLIB import get_ip, read_eeprom
import paho.mqtt.client as mqtt
import urllib.request
import time

modul = []
data_list = []
button = ["x"]
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
loop_time = 15

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
        b1 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/2"):
        b2 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/3"):
        b3 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/4"):
        b4 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/5"):
        b5 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/6"):
        b6 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/7"):
        b7 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/8"):
        b8 = message.payload.decode("utf-8")
    if(message.topic=="tgn/buttons/status/9"):
        b9 = message.payload.decode("utf-8")
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

client = mqtt.Client("Web_Modul_2")
client.connect(get_ip())
client.on_message=on_message
client.loop_start()
client.subscribe([("MQTChroma/*",1),("tgn/#",0)])
time.sleep(2)
client.loop_stop()
button.append(b1)
button.append(b2)
button.append(b3)
button.append(b4)
button.append(b5)
button.append(b6)
button.append(b7)
button.append(b8)
button.append(b9)
bt_1 = main_url+"?api_key="+user_key+"&switch_id=0&status=read"
get_url= urllib.request.urlopen(bt_1)
print("Response Status: "+ str(get_url.getcode()) )
if str(get_url.getcode()) == "200":
    modul_status = ["x"]
    modul_name =["#modul id"] 
    cach = str(get_url.read())
    data_list = cach.split("<br>")
    num = len(data_list)-1
    for i in range(1, num):
        cach_b = data_list[i].split("|")
        modul_name.append(cach_b[1])
        cach_c = stat_list.index(cach_b[2])
        modul_status.append(str(cach_c))
    num = len(modul_name)
    for i in range(num):
        num_b = modul.index(modul_name[i])
        if(modul_status[i] != button[num_b]):
            topic_set = "tgn/buttons/status/"+str(num_b)
            print("Update: " + topic_set)
            client = mqtt.Client("Web_Modul_Read")
            client.connect(get_ip())
            client.publish(topic_set,modul_status[i],qos=0,retain=True)