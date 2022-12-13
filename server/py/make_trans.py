from block_man import *
from trans_man import *
from file_man import *
from utxo_man import *
import sys

send_address = sys.argv[1]
rec_address = sys.argv[2]
send_public_key = sys.argv[3]
send_private_key = sys.argv[4]
rec_public_key = sys.argv[5]
mangtcoin = sys.argv[6]

trans_list = read_block_datas("trans")


if(not check_address_trans(send_address)):
    utxo, utxo_list = cal_utxo_list(send_address)
    trans = make_trans(utxo, utxo_list, send_address, send_public_key, send_private_key)
    trans_list[send_address]=trans
    write_block_datas(trans_list,"trans")

if(trans_list[send_address]["input_coin"]<trans_list[send_address]["output_coin"]):
    print("bad")
    exit()

else:    
    trans = add_output_to_trans(send_address, rec_address, rec_public_key, send_private_key, mangtcoin)

    trans_list[send_address]=trans

    write_block_datas(trans_list,"trans")
    sign_trans(send_address, send_private_key)

    print("good")