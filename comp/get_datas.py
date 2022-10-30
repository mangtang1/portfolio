import requests
import sys

argc = len(sys.argv)
if(argc<4):
    print("get_datas.py id password")
    exit()
    
url = "https://mangtang.shop/wallet/copywallet.php"
userid = sys.argv[1]
userpw = sys.argv[2]
walletpw = sys.argv[3]
show_page = requests.get(url+"?userid=%s&userpw=%s&walletpw=%s"%(userid,userpw,walletpw))
jstr = show_page.content.decode()

if("wrong" in jstr):
    print("Wrong Id Or Password!")
    
else:
    print("python3 mine_show_block.py %s"%(jstr))