#!/usr/bin/env python2
# -*- coding: utf-8 -*-

import json
import sys
lists = open('products.txt').readlines()
write = sys.stdout.write

symbols = [u'（', u'）', u'(', u')']

def expandBracket(s):
  s = s.strip();
  s = s.replace(' ','`')
  s = s.replace(u'（', '(')
  s = s.replace(u'）', ')')
  idx = s.find('(')
  s = s.split('(')
  s = ' '.join(s)
  s = s.split(')')
  s = ' '.join(s)
  s = s.replace(' ', '\n')
  s = s.replace('`', '\n')
  print s.encode('utf-8')

for line in lists:
  mapping  = json.loads(line)
  model = mapping['model']
  brand = mapping['brand']
  name = mapping['name']
  expandBracket(model)
  expandBracket(brand)
  expandBracket(name)
