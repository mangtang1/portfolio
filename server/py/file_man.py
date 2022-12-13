import json
from get_form_datas import *
from key_man import *
default_path = get_key("default_path")
admin_private_key = get_key("admin","admin_private_key")
admin_public_key = get_key("admin","admin_public_key")
admin_wallet_address = get_key("admin","admin_wallet_address")
admin_password = get_key("admin","admin_password")


def name_to_json_path(name):
    return default_path+"/"+name+"_block.json"    

def read_block_datas(name):
    path=name_to_json_path(name)
    with open(path, "r") as file:
        return json.load(file)

def write_block_datas(block, name):
    path=name_to_json_path(name)
    with open(path, 'w', encoding='utf-8') as make_file:
        json.dump(block, make_file, indent='\t')
    
tax_rate = read_block_datas("chain")["tax_rate"]
admin_award = read_block_datas("chain")["award"]