#!/usr/bin/env python2
# -*- coding: utf-8 -*-

import json
import sys
lists = open('products.txt').readlines()

for line in lists:
  mapping  = json.loads(line)
  model = mapping['model'].encode('utf-8')
  brand = mapping['brand'].encode('utf-8')
  name = mapping['name'].encode('utf-8')
  print model, brand, name
