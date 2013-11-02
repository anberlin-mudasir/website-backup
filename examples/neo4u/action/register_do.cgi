#!/usr/bin/env python2
import md5
import cgi
import cgitb
import socket

cgitb.enable();

print 'Content-Type:text/html;charset:utf-8\n'

form = cgi.FieldStorage()
name = ""
pwd = "" 

HOST, PORT = "localhost", 10000
if "pwd" in form:
  pwd = form["pwd"].value
if "name" in form:
  name = form["name"].value
if name == "":
  print "fail"
  exit()


if pwd == "":
  data = ["existuser", name]
else:
  pwd=md5.new(pwd).hexdigest()
  data = ["newuser", name, pwd]

sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
sock.connect((HOST, PORT))
sock.send("\n".join(data))
sock.shutdown(socket.SHUT_WR)

received=sock.recv(65536)
sock.close()

print received.strip()
