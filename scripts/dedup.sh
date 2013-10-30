#!/bin/sh
for i in `cat gbk.txt`; do grep "${i%@@*}" lib/dict.txt.long ; done 
