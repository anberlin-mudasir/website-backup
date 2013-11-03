#include <iostream>
#include <string>
#include <cstdio>
#include "./lib/NLPIR.h"
using namespace std;

/* byte length of current utf8 char,
 * including the leading char */
int utf8len(char heading) {
  if (heading > 0) return 1;
  unsigned c = int(heading) & 0xFFU;
  if ((c & 0xE0) == 0xC0) return 2;  // 11: 0x110x xxxx 10xx xxxx 
  if ((c & 0xF0) == 0xE0) return 3;  // 16: 0x1110 xxxx 10xx xxxx 10xx xxxx
  if ((c & 0xF8) == 0xF0) return 4;  // 21: 0x1111 0xxx 10xx xxxx 10xx xxxx 10xx xxxx
  if ((c & 0xFC) == 0xF8) return 5;  // 26: 0x1111 10xx 10xx xxxx 10xx xxxx 10xx xxxx 10xx xxxx
  if ((c & 0xFE) == 0xFC) return 6;  // 31: 0x1111 110x xxxx xxxx 10xx xxxx 10xx xxxx 10xx xxxx 10xx xxxx
  return -1;
}

int utf8(int uni) {
  return ((uni & 0xF000) << 4) | 
         ((uni & 0xFC0) << 2) |
         ((uni & 0x3F) | 0xE08080);
}
int unicode(int utf8) {
  int code = (utf8 & 0xF3F3F);
  return ((code >> 4) & 0xF000) |
         ((code >> 2) & 0xFC0) | 
          (code & 0x3F);
}

// unicode range for chinese char:
// 0×20000 -0x2A6DF more-shit (not included, of course!)
// 0x3400 ~ 0x4DBF shit-like chinese (not included)
//
// 0x4E00 ~ 0x9FBF normal chinese
// 0xFF01 ~ 0xFF5E quan-jiao symbols
// 0x3001 ~ 0x3002 douhao, juhao
// 0x3008 ~ 0x300B shu ming hao
// 0x2013 ~ 0x2014 po zhe hao
// 0x25CB chinese 'zero'
//
inline void trim(string &s, int f, int t) {
  for (int i = f; i < t; i++) s[i] = ' ';
}
// remove shits
void trim(string &s) {
  int pos = 0, end = s.length();
  while (pos < end) {
    int len = utf8len(s[pos]);
    if (len != 1 && len != 3) {
      trim(s, pos, pos + len);
    } else if (len == 3) {
      unsigned utf8 =  ((s[pos]   & 0xFF) << 16) | 
                       ((s[pos+1] & 0xFF) << 8)  | 
                        (s[pos+2] & 0xFF);
      unsigned uni = unicode(utf8);
      if (
          (uni >= 0x4E00 && uni <= 0x9FBF) ||
          (uni >= 0xFF01 && uni <= 0xFF5E) ||
          (uni >= 0x3001 && uni <= 0x3002) ||
          (uni >= 0x3008 && uni <= 0x300B) ||
          (uni >= 0x2013 && uni <= 0x2014) ||
          (uni == 0x25CB)) {
      } else {
        trim(s, pos, pos + len);
      }
    }
    pos += len;
  }
}

void strip(string &s) {
  int n = s.length();
  if (n == 0) return;
  while (n > 1 && isspace(s[n-1])) n--;
  s = s.substr(0, n);
}

bool envInit() {
  return NLPIR_Init("./include", UTF8_CODE);
}
void envExit() {
  NLPIR_Exit();
}
const char *segment(string &str, bool postag) {
  return NLPIR_ParagraphProcess(str.c_str(), postag);
}
const char *segment(CNLPIR *util, string &str, bool postag) {
  return util->ParagraphProcess(str.c_str(), postag);
}
