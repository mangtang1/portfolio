from block_man import *
from file_man import *
from trans_man import *
from get_form_datas import *
import sys

minor_address = sys.argv[1]
minor_public_key = sys.argv[2]
minor_private_key = sys.argv[3]
nonce = sys.argv[4]

unmined_block = read_block_datas("show")

mined_block = make_mined_block(unmined_block, minor_address, minor_public_key, minor_private_key)

if(mined_block["nonce"]==int(nonce)): print("good")
else : print("bad")