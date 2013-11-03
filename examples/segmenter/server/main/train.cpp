#include <iostream>
#include <fstream>
#include <string>
#include <cstdio>
#include "./lib/NLPIR.h"
using namespace std;

int main(int argc, char** argv) {
  if(!NLPIR_Init("./include", UTF8_CODE)) {
    printf("Init fails\n");  
    return 0;
  }
  if (argc <= 1) {
    printf("Usage: %s <train dict file>", argv[0]);
  }
  string input;
  int ret;
  if (argc > 1) {
    ifstream fin(argv[1]);
    if (!fin) {
      printf("User dict fails\n");  
      return 0;
    }
    getline(fin, input);
    if (input.find("#DICT" ,0) == string::npos) {
      printf("Bogus user dict\n");  
      return 0;
    }
    while (getline(fin, input)) {
      ret = NLPIR_AddUserWord(input.c_str());
      printf("word=%s ret=%s\n", input.c_str(), ret ? "succeed" : "failed");
    }
    NLPIR_SaveTheUsrDic();
    return 0;
  }
  return 0;
}
