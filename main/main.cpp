#include "segment.h"

int main(int argc, char** argvs) {
  if (!env_init()) {
    printf("Init fails\n");  
    return 0;
  }
  string input;
  while (getline(cin, input)) {
    trim(input);
    printf("%s\n", segment(input, 1));
  }
  env_exit();
  return 0;
}
