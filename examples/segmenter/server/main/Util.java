import java.util.ArrayList;

public class Util {
  public enum Type {
    WORD_SIGN(0),   // 符号
    WORD_FOUND(1),  // 词典有此词，且无歧义
    WORD_MISS(2),   // 词典无此词，但无歧义
    WORD_CONFUSE(3); // 有歧义（词典肯定无此词，但有可能有它的子集

    private int t;
    Type(int t) {
      this.t = t;
    }
    public String toString() {
      return String.valueOf(t);
    }
  }

  public static boolean hanzi(char c) {
    if((c>='\u4e00' && c<='\u9fbf') || 
       (c>='\u3400' && c<='\u4d86') || c == '\u25cb') {
      return true;
    }
    return false;
  }
  public static String tagToString(String str) {
    int k = str.indexOf("#");
    if (k == -1)
      return "";
    else 
      return str.substring(0,k);
  }
  public static int tagToType(String str) {
    int k = str.indexOf("#");
    if (k == -1)
      return -1;
    else 
      return Integer.valueOf(str.substring(k+1));
  }
  public static void collectSegments(ArrayList<String> s, 
      ArrayList<Integer> t, String line) {
    String[] list = line.trim().replaceAll("  "," ").split(" ");  
    for (int i=0; i<list.length; i++) {
      String[] pair = list[i].split("#");
      if (pair.length != 2)
        continue;
      s.add(pair[0]);
      t.add(Integer.valueOf(pair[1]));
    }
  }
}
