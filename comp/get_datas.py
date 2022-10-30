import requests
import sys

argc = len(sys.argv)
if(argc<3):
    print("get_datas.py id password")
    exit()
    
url = "https://mangtang.shop/wallet/copywallet.php"
id = sys.argv[1]
password = sys.argv[2]
show_page = requests.get(url+"?id=%s&password=%s"%(id,password))
jstr = show_page.content.decode()

if("wrong" in jstr):
    print("Wrong Id Or Password!")
    
else:
    print("python3 mine_show_block.py %s"%(jstr))