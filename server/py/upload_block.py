from block_man import *
from file_man import *
from trans_man import *
from get_form_datas import *
import sys

def setting():
        info_block = make_info_block()
        unmined_block = make_block(info_block, read_block_datas("trans"))
        write_block_datas(unmined_block, "show")
        write_block_datas({}, "trans")

setting()

