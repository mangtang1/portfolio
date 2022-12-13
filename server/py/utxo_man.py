import os
import pymysql

from get_form_datas import *
from hashlib import sha256 as sha
from crypto import *
from get_form_datas import *
from key_man import *
db_conn = pymysql.connect(**get_key('user'))
cursor = db_conn.cursor()


def check_allowed_trans(output):
    query = "select * from utxo where hash=%s"
    trans_hash = make_hash_data(output, "output")
    cursor.excute(query, (trans_hash))
    utxo = cursor.fetchone()
    if(len(utxo)>0): return True
    return False
    
def mod_utxo(mined_block):
    trans_list=mined_block["trans_list"]
    block_hash=make_hash_data(mined_block,"block")
    for address, trans in trans_list.items():
        for inp in trans["inputs"].values():
            trans_hash=make_hash_data(inp, "output")
            query = "delete from utxo where hash=%s"
            cursor.execute(query, (trans_hash))
        x=0
        for oup in trans["outputs"].values():
            trans_hash=make_hash_data(oup, "output")
            query = "insert into utxo (hash, address, public_key, mangtcoin, mes, block_hash, output_index) values('%s', '%s', '%s', %d, '%s', '%s', %d);"%(trans_hash, oup["address"], oup["public_key"], oup["mangtcoin"], oup["mes"], block_hash, x)
            cursor.execute(query)
            db_conn.commit()

            x+=1

def cal_utxo_list(address):
    ret = 0
    usable_output = []
    query = "select * from utxo where address = %s"
    cursor.execute(query, (address))
    result = cursor.fetchall()
    for utxo in result:
        ret+=utxo[3]
        tem={
        'hash':utxo[0],
        'address':utxo[1],
        'public_key':utxo[2],
        'mangtcoin':utxo[3],
        'mes':utxo[4],
        'block_hash':utxo[5],
        'output_index':utxo[6]
        }
        usable_output.append(tem)
        
    return ret, usable_output
    