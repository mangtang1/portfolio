
from datetime import datetime

def get_time():
    then = datetime(2000,1,1,0,0,0)
    now = datetime.now()
    sub = now-then
    tos = hex(int(sub.total_seconds()))[2:]
    tos="0"*(8-len(tos))+tos
    return tos
    
