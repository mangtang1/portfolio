import base58
import hashlib
import os
import pymysql
import sys
import
from hashlib import sha256 as sha
from ecdsa import SigningKey, NIST256p
from crypt import *
from key_man import *

con = pymysql.connect(get_key('coin'))
cursor = con.cursor()

def ripemd160(x):
    ret = hashlib.new('ripemd160')
    ret.update(x)
    return ret

def make_wif_address(public_key):
    public_hash = sha(bytes.fromhex(public_key)).digest()
    encPubkey = ripemd160(public_hash).digest()
    encPubkey = b'\x00' + encPubkey
    chunk = sha(sha(encPubkey).digest()).digest()
    checksum=chunk[:4]
    hex_bitcoin_address = encPubkey+checksum
    wif_bitcoin_address = base58.b58encode(hex_bitcoin_address)
    return wif_bitcoin_address
    
def make_wallet():
    sk = SigningKey.generate(curve=NIST256p)
    vk = sk.get_verifying_key()
    public_key = vk.to_string().hex()
    private_key = sk.to_string().hex()
    wif_bitcoin_address = make_wif_address(public_key)
#   print(public_key)
#   print(hex_bitcoin_address.hex())
#   print(wif_bitcoin_address.decode('utf-8'))
    return (public_key, private_key, wif_bitcoin_address.decode('utf-8'))

def insert_db(password_hash):
    (public_key, private_key, wif_bitcoin_address) = make_wallet()
    query = "insert into wallets (private_key, public_key,wallet_address, password) VALUES('%s','%s','%s','%s');" % (private_key,public_key,wif_bitcoin_address,password_hash)
    cursor.execute(query)
    return wif_bitcoin_address

def check_correct_address(public_key, wif_bitcoin_address):
    comp = make_wif_address(public_key).decode('utf-8')
    if comp==wif_bitcoin_address:
        return True
    else:
        return False
    
password = sys.argv[1]
print(insert_db(password))
con.commit()
con.close()
