import rsa
import math
from hashlib import sha256 as sha
from get_form_datas import *
from ecdsa import SigningKey, NIST256p


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
    
