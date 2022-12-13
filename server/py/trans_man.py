import json
import timing
from hashlib import sha256 as sha
from crypto import *
from file_man import *
from get_form_datas import *
from math import floor
from utxo_man import *


def check_address_trans(address):
    trans_list = read_block_datas("trans")
    if(address in trans_list.keys()):
        return True
    return False

def cal_tax(mangtcoin):
    return floor(int(mangtcoin)*tax_rate)


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
    trans["tax"]=0
    trans["public_key"]=public_key
    return trans
    
def add_output_to_trans(send_address, rec_address, rec_public_key, send_private_key, mangtcoin):
    mangtcoin=int(mangtcoin)
    trans = read_block_datas("trans")[send_address]
    output={}
    output["address"]=rec_address
    output["public_key"]=rec_public_key
    output["mangtcoin"]=mangtcoin
    output["mes"]=timing.get_time()
    trans["outputs"][len(trans["outputs"])]=output
    trans["output_coin"]+=mangtcoin
    trans["tax"]+=cal_tax(mangtcoin)
    return trans


def give_unused_coin(trans_list):
    for address, trans in trans_list.items():        
        output={}
        output["address"]=address
        output["public_key"]=trans["public_key"]
        output["mangtcoin"]=trans["input_coin"]-(trans["output_coin"]+trans["tax"])
        output["mes"]=timing.get_time()
        trans["outputs"][len(trans["outputs"])]=output
        trans["output_coin"]+=output["mangtcoin"]
        trans_list[address]=trans
    
    return trans_list

def minor_get_award(unmined_block, address, public_key, private_key):
    award = unmined_block["award"]
    
    decr = 2**floor(unmined_block["hash_cnt"]/unmined_block["half_life"])
    
    award = floor(award/decr)
    
    if(unmined_block.get("trans_list")): trans_list=unmined_block["trans_list"]
    else : trans_list={}
    for key, value in trans_list.items():
        award += value["tax"]
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
    