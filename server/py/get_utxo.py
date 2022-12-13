from utxo_man import *
import sys

rec_address = sys.argv[1]

utxo, utx_list = cal_utxo_list(str(rec_address))


res = '|'.join(str(s) for s in utx_list).replace("'", '"')
print(utxo,'/',res);