#include <deque>
#include <pthread.h>
#include <sys/time.h>
#include <cstdlib>
#include "segment.h"
#include "socktcp.h"

deque<int> tasks;

pthread_mutex_t sem_proc;
pthread_cond_t cond_proc;
int port, num_threads;
int num_inited = 0;

void * processor(void *);
void signals_init();
void threads_init();

void *processor(void *) {
  int id = 0;
  CNLPIR *util;

  pthread_mutex_lock(&sem_proc);
  util = new CNLPIR();
  id = num_inited++;
  printf("# proc init... [%d]\n", id);
  pthread_mutex_unlock(&sem_proc);

  for (;;) {
    pthread_mutex_lock(&sem_proc);
    while (!tasks.size()) {
      pthread_cond_wait(&cond_proc, &sem_proc);
    }
    int selffd = tasks.front();
    tasks.pop_front();
    pthread_mutex_unlock(&sem_proc);
    
    string query, reply;

    tcpRead(selffd, query);

    strip(query);
    trim(query);

    reply = segment(util, query, 1);

    fprintf(stderr, "[%d] %s\n", id, query.c_str());

    tcpWrite(selffd, reply);
    tcpClose(selffd);
  }
  // never
  return NULL;
}

void error(const char *msg) {
  perror(msg);
  exit(1);
}

void env_init() {
  if (!envInit()) {
    error("# ERROR: seg module init fail");  
  }
}

void signals_init() {
  pthread_mutex_init(&sem_proc, NULL);
  pthread_cond_init(&cond_proc, NULL);
}

void threads_init() {
  pthread_t threads[num_threads];
  for (int i = 0; i < num_threads; i++) {
    pthread_create(&threads[i], NULL, processor, NULL);
  }

  int listenfd, connfd;
  if ((listenfd = tcpServerInit(port)) < 0) {
    error("# ERROR:");
  }
  for (;;) {
    connfd = tcpServerListen(listenfd);
    if (connfd < 0) {
      tcpClose(connfd);
      continue;
    }
    pthread_mutex_lock(&sem_proc);
    tasks.push_back(connfd);
    pthread_mutex_unlock(&sem_proc);
    pthread_cond_broadcast(&cond_proc);
  }
}


int main(int argc, char** argv) {
  if (argc < 3) {
    printf("Usage: %s <port> <num threads>\n", argv[0]);
    exit(0);
  }
  port = atoi(argv[1]);
  num_threads = atoi(argv[2]);

  env_init();
  signals_init();
  threads_init();

  return 0;
}
