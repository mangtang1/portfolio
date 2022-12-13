import qrcode
import sys

if(len(sys.argv)<2):
    print("python3 %s wallet_address"%sys.argv[0])
    exit()

address=sys.argv[1]

url = "https://mangtang.shop/wallet/qrcode.php"
img_path = "/var/www/html/imgs"
img = qrcode.make(url+"?address=%s"%sys.argv[1])
img.save(img_path+"/"+address+".png")
