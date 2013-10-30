#ifndef SOCKTCP_H
#define SOCKTCP_H

#include <sys/socket.h>
#include <arpa/inet.h>
#include <unistd.h>
#include <memory.h>
#include <string>

using namespace std;

int tcpBind(int sockfd, string bindIP, int bindPort) {
  struct sockaddr_in servaddr;
  servaddr.sin_family = AF_INET;
  inet_pton(AF_INET, bindIP.c_str(), &servaddr.sin_addr.s_addr);
  servaddr.sin_port = htons(bindPort);
  return bind(sockfd, (struct sockaddr *)&servaddr, sizeof(servaddr));
}

int tcpBind(int sockfd, int bindPort) {
  struct sockaddr_in servaddr;
  servaddr.sin_family = AF_INET;
  servaddr.sin_addr.s_addr = htonl(INADDR_ANY);
  servaddr.sin_port = htons(bindPort);
  return bind(sockfd, (struct sockaddr *)&servaddr, sizeof(servaddr));
}

int tcpServerInit(int port) {
  int listenfd;
  if ((listenfd = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP))<0)
        return -1;
  if (tcpBind(listenfd, "127.0.0.1", port)<0)
        return -1;
  listen(listenfd, 5);
    return listenfd;
}
int tcpServerListen(int listenfd) {
    return accept(listenfd, NULL, NULL);
}
int tcpConn(string serverIP, int port) {
  int sockfd;
  struct sockaddr_in servaddr;
  sockfd = socket(AF_INET, SOCK_STREAM, 0);
  memset(&servaddr, 0, sizeof(servaddr));
  servaddr.sin_family = AF_INET;
  servaddr.sin_port = htons(port);
  inet_pton(AF_INET, serverIP.c_str(), &servaddr.sin_addr.s_addr);

  if(connect(sockfd, (struct sockaddr *)&servaddr, sizeof(servaddr)) < 0)
    return -1;
  return sockfd;
}

int tcpWrite(int sockfd, const string& content) {
  int sendsize(0), t_index(0), t_len(content.size());
  int tmpsize;
  string sendsubstr;
  while(t_index < t_len) {
    sendsubstr = content.substr(t_index, 1024);
    tmpsize = write(sockfd, sendsubstr.c_str(), sendsubstr.size());
    if( tmpsize < 0)
      return tmpsize;
    sendsize += tmpsize;
    t_index += 1024;
  }
  return sendsize;
}
int tcpWriteFinish(int sockfd) {
    return shutdown(sockfd,SHUT_WR);
}
int tcpRead(int sockfd, string& content) {
  char readbuf[1024*4];
  int t_len, retval(0);
  memset(readbuf, 0, sizeof(readbuf));
  content.clear();
  
  while((t_len = read(sockfd, readbuf, sizeof(readbuf)-1)) > 0) {
    retval += t_len;
    content += string(readbuf, t_len);
    memset(readbuf, 0, sizeof(readbuf));
  }
  return retval;
}


int tcpClose(int sockfd) {
  return close(sockfd);
}


#endif
