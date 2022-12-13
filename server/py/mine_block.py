from block_man import *
from file_man import *
from trans_man import *
from get_form_datas import *
import sys

minor_address = sys.argv[1]
minor_public_key = sys.argv[2]
minor_private_key = sys.argv[3]
if(len(sys.argv)>4): nonce=int(sys.argv[4])
else: nonce=0

unmined_block = read_block_datas("show")

if(not "time" in  unmined_block.keys()):
    exit()

if(unmined_block["hash_cnt"]<read_block_datas("chain")["hash_cnt"]):
 exit

unmined_block["nonce"]=nonce

mined_block = make_mined_block(unmined_block, minor_address, minor_public_key, minor_private_key)
mod_utxo(mined_block)

json_add_block(mined_block)