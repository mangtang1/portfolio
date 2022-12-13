from block_man import *
from get_form_datas import *
from file_man import *
import json

import sys
    
def check_type(data, tp):
    return str(type(data))=="<class '%s'>"%tp

def check_hex(data):
    alp = '0123456789abcdef'
    for k in data:
        if(not (k in alp)): return False
    return True

def search_block(args):   
    argc=len(args)
    if(argc>=2) : sor=args[1]
    if(argc>=3) : sh=int(args[2])
    else : sh=0
    if(argc>=4) : eh=int(args[3])
    else : eh=0
    if(argc>=5) : level=argc-4
    else : level=0
    if(argc>=5) : block=args[4]
    if(argc>=7) : address=args[6]
    if(argc>=8) : inout=args[7]
    if(argc>=9) : index=args[8]
    ret = {}
    arr=read_block_datas("chain")
    if(level>=1):
        arr=arr.get(block)
    if(level>=2):
        arr=arr.get("trans_list")
    if(level>=3):
        arr=arr.get(address)
    if(level>=4):
        arr=arr.get(inout)
    if(level>=5):
        arr=arr.get(index)
    ken = list(arr.keys())
    if(sor=="inc"):
        if(eh==0): keys= ken[sh:]
        else : keys=ken[sh:eh]
    else:
        k=-sh
        sh=-eh-1
        eh=k
        if(eh==0) : keys=ken[:sh:-1]
        else : keys=ken[eh:sh:-1]
        
    for key in keys:
        ret[key]=arr[key]
    return ret


argc = len(sys.argv)

if(argc==1):
    print("범위를 지정해주세요.")
    exit()

else:
    ret = search_block(sys.argv)
res = ""

res = json.dumps(ret)
    
print(res)