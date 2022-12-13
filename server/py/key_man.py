import json

key_path = "/home/server/keys/key.json"
keys = {}

with open(key_path, "r") as file:
    keys=json.load(file)

def get_key(*args):
    arr = keys
    for key in args:
        arr=arr[key]
    
    return arr