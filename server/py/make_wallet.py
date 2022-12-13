from random import SystemRandom
def make_wallet():
    rand = SystemRandom()
    priv = hex(s.randint(0, 2 ** 256 - 1))[2:]
    while len(priv < 64):
        priv = '0' + priv
    
    