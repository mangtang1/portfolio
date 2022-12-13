import json
import math
from crypto import *
from math import floor
path_form_datas = "/home/server/jsons/form_datas.json"

def check_wif(data):
    alp = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz'
    for k in data:
        if(not(k in alp)): return False
    return True
    
def check_hex(data):
    alp = '0123456789abcdef'
    for k in data:
        if(not (k in alp)): return False
    return True

def read_form_datas(key):
    with open(path_form_datas, "r") as file:
        form_datas = json.load(file)
    
    return form_datas[key]
       
def data_to_form_string(data,form):
    res = "{"
    x=0
    form_data = read_form_datas(form)
    for key_name, val in data.items():
        fd="%s"
        if(key_name in form_data.keys()):
            fd = form_data[key_name]
            
        elif(str(type(key_name))=="<class 'int'>" and ("%d" in form_data.keys())):
            fd = form_data["%d"]
            
        elif(check_hex(key_name) and ("%h" in form_data.keys())):
            fd = form_data["%h"]
            
        elif(check_wif(key_name) and ("%a" in form_data.keys())):
            fd = form_data["%a"]

        else:
            continue
            
        if(fd == "%d"):
            res=res+"%d"%floor(val)
        elif(fd == "%s"):
            res=res+"\"%s\""%(val)
        elif(fd == "%a"):
            res=res+"\"%s\""%(val)
        elif(fd == "%h"):
            res=res+"\"%s\""%(val)
        elif(fd == "%f"):
            res=res+"\"%.6f\""%(val)
        elif(fd=="%j"):
            te = data_to_form_string(val, key_name)
            res=res+"\{%s\}"%(te)
        elif(fd[:3]=="%j_"):
            te = data_to_form_string(val, fd[3:])
            res=res+"\{%s\}"%(te)
    res=res+"}"
    return res
            