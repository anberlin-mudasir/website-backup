#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h> 

void error(const char *msg) {
  perror(msg);
  exit(0);
}

int main(int argc, char *argv[]) {
  if (argc < 3) {
    fprintf(stderr,"usage %s hostname port\n", argv[0]);
    exit(0);
  }

  int sockfd, portno, n;
  struct sockaddr_in serv_addr;
  struct hostent *server;
  char buffer[25600];
  char query[25600];

  server = gethostbyname(argv[1]);
  if (server == NULL) {
    fprintf(stderr,"ERROR, no such host\n");
    exit(0);
  }

  portno = atoi(argv[2]);
  if ((sockfd = socket(AF_INET, SOCK_STREAM, 0))<0)
    error("ERROR opening socket");
  bzero((char *) &serv_addr, sizeof(serv_addr));
  serv_addr.sin_family = AF_INET;
  bcopy((char *)server->h_addr, 
     (char *)&serv_addr.sin_addr.s_addr,
     server->h_length);
  serv_addr.sin_port = htons(portno);
  if (connect(sockfd,(struct sockaddr *) &serv_addr,
        sizeof(serv_addr)) < 0) 
    error("ERROR connecting");

  //printf("Please enter the message: ");
  bzero(query,25500);
  for (int i=0; i<7; i++) {
    bzero(buffer,25500);
    if (!fgets(buffer,25500,stdin))
      break;
    strcat(query,buffer);
  }
  //printf("%s\n",query);
  if ((n = write(sockfd,query,strlen(query)))<0)
     error("ERROR writing to socket");

  shutdown(sockfd,SHUT_WR);
  //printf("Waiting for server's reply: ");
  bzero(buffer,25600);
  if ((n = read(sockfd,buffer,25500))<0)
     error("ERROR reading from socket");
  printf("%s\n",buffer);
  
  close(sockfd);
  return 0;
}
