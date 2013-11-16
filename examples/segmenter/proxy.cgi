#!/usr/bin/env python2
# -*- coding: UTF-8 -*-
# enable debugging
import cgitb
import cgi
import socket
import sys
import os

cgitb.enable()

print 'Content-Type:text/html;charset:utf-8\n'

try:
  form = cgi.FieldStorage()
  text = form["text"].value

  HOST, PORT = "localhost", 12345

  # Create a socket (SOCK_STREAM means a TCP socket)
  sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

  # Connect to server and send data
  sock.connect((HOST, PORT))
  sock.send(text)
  sock.shutdown(socket.SHUT_WR)

  # Receive data from the server and shut down
  back = sock.recv(16384);
  sock.close()

  print back
except Exception as ex:
  print "ERROR: restart the segmenter server?"

