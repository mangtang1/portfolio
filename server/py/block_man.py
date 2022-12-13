import json
from hashlib import sha256 as sha
import timing
from crypto import *
from trans_man import *
from file_man import *
from get_form_datas import *
    
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
        hash = make_hash_data(json_block,"block")
        nonce = nonce + 1
        
        if int('0x'+target,16)>int('0x'+hash,16) :        
            return json_block

def make_info_block():
    block_datas = read_block_datas("chain")        
    info_block = {
    "time":timing.get_time(), 
    "hashprevblock":block_datas["last_block_hash"],
    "hash_cnt":block_datas["hash_cnt"],
    "version":block_datas["current_version"],
    "bits":block_datas["bits"],
    "award":block_datas["award"],
    "tax_rate":block_datas["tax_rate"],
    "half_life":block_datas["half_life"],
    "nonce":0,
    "minor":"",
    "trans_list":{}}
    return info_block

def make_block(info_block, trans_list): 
    info_block["trans_list"]=give_unused_coin(trans_list)
    return info_block

def make_mined_block(unmined_block, minor_address, minor_public_key, minor_private_key):
    trans_list = minor_get_award(unmined_block, minor_address, minor_public_key, minor_private_key)
    unmined_block["trans_list"]=trans_list
    unmined_block["minor"]=minor_address
    return cal_nonce(unmined_block)

def json_add_block(block):
    hash = make_hash_data(block,"block")
    block_datas=read_block_datas("chain")
    block_datas[hash]=block
    block_datas["last_block_hash"]=hash
    block_datas["hash_cnt"]+=1
    write_block_datas(block_datas, "chain")
    
