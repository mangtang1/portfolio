import requests
import sys
from datetime import datetime
import json
import rsa
from math import floor
from hashlib import sha256 as sha
from ecdsa import SigningKey, NIST256p
path_form_datas = "form_datas.json"

def get_time():
    then = datetime(2000,1,1,0,0,0)
    now = datetime.now()
    sub = now-then
    tos = hex(int(sub.total_seconds()))[2:]
    tos="0"*(8-len(tos))+tos
    return tos

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

def sign_message(mes, private_key):
    pk = bytes.fromhex(private_key)
    key = SigningKey.from_string(bytes.fromhex(private_key), curve=NIST256p) 
    signature = key.sign(str(mes).encode())
    return bytes.hex(signature)
    

def veri_message(crypt_mes, real_mes, public_key) :
    try:
        key = SigningKey.from_string(bytes.fromhex(public_key), curve=NIST256p) 
        key.verify(bytes.fromhex(crypt_mes), str(real_mes).encode())
        return False
    except Exception as e:
        return True
    
def make_hash_data(data, form):
    data = data_to_form_string(data, form)
    json_data = data.encode()
    hash_ret = sha(json_data).hexdigest()
    return hash_ret

def sign_inputs(utxo_list, private_key):
    inputs = {}
    for index in range(len(utxo_list)):
        if(utxo_list[index].get("signature")): del(utxo_list[index]["signature"])
        utxo_list[index]["signature"]=sign_message(utxo_list[index]["mes"], private_key)
        inputs[index]=utxo_list[index]
    return inputs

def sign_trans(address, private_key):
    trans_list = read_block_datas("trans")
    trans=trans_list[address]
    if(trans.get("hash")): del(trans["hash"])
    if(trans.get("signature")): del(trans["signature"])
    trans["hash"]=make_hash_data(trans,"trans")
    trans["signature"]=sign_message(trans["hash"], private_key)
    trans_list[address]=trans
    write_block_datas(trans_list, "trans")  
    
def make_trans(utxo, utxo_list, address, public_key, private_key):
    trans={}
    trans["inputs"]=sign_inputs(utxo_list, private_key)
    trans["outputs"]={}
    trans["input_coin"]=utxo
    trans["output_coin"]=0
    trans["public_key"]=public_key
    return trans
    
def minor_get_award(unmined_block, address, public_key, private_key):
    award = unmined_block["award"]
    decr = 2**floor(unmined_block["hash_cnt"]/5000)
    
    award = floor(award/decr)
    if(not unmined_block.get("trans_list")== None): trans_list=unmined_block["trans_list"]
    else : trans_list={}
    for key, value in trans_list.items():
        award += value["input_coin"] - value["output_coin"]
       
    output={}
    output["address"]=address
    output["public_key"]=public_key
    output["mangtcoin"]=award
    output["mes"]=unmined_block["time"]
    trans={}
    if(trans_list.get(address)):
        trans=trans_list[address]
    else:
        trans=make_trans(0, [], address, public_key, private_key)
        
    trans["outputs"][len(trans["outputs"])]=output
    trans["output_coin"]+=award
    
    trans_list[address]=trans
    
    return trans_list
    
def make_str_block(block):
    data = data_to_form_string(block, "block")
    return data

def make_hash_block(block):
    data = make_str_block(block)
    json_data = data.encode()
    hash_ret = sha(json_data).hexdigest()
    return hash_ret
    
def cal_nonce(block):
    difficulty = block["bits"]
    zc = int("0x"+difficulty[0:2], 16)-3
    if zc>61 : zc=61
    target = difficulty[2:8]+"0"*zc
    target = "0"*(64-len(target))+target
    nonce=int(block["nonce"])
    while(True):
        json_block = block
        json_block["nonce"]=nonce
        hash = make_hash_block(json_block)
        nonce = nonce + 1
        #print(hash,nonce)
        if int('0x'+target,16)>int('0x'+hash,16) :        
            return json_block
            
            
def make_mined_block(unmined_block, minor_address, minor_public_key, minor_private_key):
    trans_list = minor_get_award(unmined_block, minor_address, minor_public_key, minor_private_key)
    unmined_block["trans_list"]=trans_list
    return cal_nonce(unmined_block)

url = "https://mangtang.shop/temp/show_block.json"
minor_address = sys.argv[1]
minor_public_key = sys.argv[2]
minor_private_key = sys.argv[3]

show_page = requests.get("https://mangtang.shop/temp/show_block.json")
jstr = show_page.content.decode()

unmined_block = json.loads(jstr)
mined_block = make_mined_block(unmined_block, minor_address, minor_public_key, minor_private_key)
# 이미 nonce 구했음

query = "https://mangtang.shop/coins/get_mined.php?minor_address=%s&minor_public_key=%s&minor_private_key=%s&nonce=%d"%(minor_address,minor_public_key,minor_private_key,mined_block["nonce"])

check_page = requests.get(query)
jstr = check_page.content.decode()

print(mined_block["nonce"], jstr)