#include "segment.h"

int main(int argc, char** argvs) {
  if (!env_init()) {
    printf("Init fails\n");  
    return 0;
  }
  const char* result = NULL;
  string str;
  while (getline(cin,str)) {
    result = segment(str, 0);
    cout << result << endl;
  }
  env_exit();
  return 0;
}
