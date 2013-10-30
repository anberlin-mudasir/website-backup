import java.io.FileReader;
import java.io.File;
import java.io.BufferedReader;
import java.util.Collections;
import java.util.ArrayList;

public class Eval {
  static ArrayList<String> cmp(ArrayList<String> a, ArrayList<String> b) {
    ArrayList<String> s = new ArrayList<String>();
    int la = a.size(), lb = b.size();
    int pa = 0, pb = 0, va = 0, vb = 0;
    String sa = null, sb = null;
    while (pa < la && pb < lb) {
      if (va == vb) {
        sa = a.get(pa);
        sb = b.get(pb);
        va += sa.length();
        vb += sb.length();
        if (sa.equals(sb) && sa != null) {
          s.add(a.get(pa));
        }
        pa++; pb++;
      } else if (va<vb) {
        sa = a.get(pa);
        va += sa.length();
        pa++;
      } else {
        sb = b.get(pb);
        vb += sb.length();
        pb++;
      }
    }
    return s;
  }
  static int noSign(ArrayList<String> list) {
    int l=list.size();
    for (String s: list) {
      for (int i=0; i<s.length(); i++) {
        if (!Util.hanzi(s.charAt(i))) {
          l--;
          break;
        }
      }
    }
    return l;
  }
  static String padding(int n) {
    String s = "###############################";
    return s.substring(0,n);
  }
  // debug 模式下，单独统计词典词命中的正确率
  // 否则，正常计算P, R值
  public static void main(String[] argv) throws Exception {
    if (argv.length < 2) {
      eprintln("Usage: java Eval <base file> <test file> <isdebug>");
      return;
    }
    boolean debug;
    int checktype = 0;
    if (argv.length == 2)  {
      debug = false;
    } else {
      checktype = Integer.valueOf(argv[2]);
      if (checktype > 3 || checktype < 0) {
        debug = false;
      } else {
        debug = true;
      }
    }

    File f1 = new File(argv[0]);
    File f2 = new File(argv[1]);
    BufferedReader br1 = new BufferedReader(new FileReader(f1));
    BufferedReader br2 = new BufferedReader(new FileReader(f2));
    String line1, line2;
    int all_words=0, got_words=0, right_words=0;
    int all_words_nosign=0, got_words_nosign=0, right_words_nosign=0;
    int got_words_sure=0, right_words_sure=0;
    while (true) {
      line1 = br1.readLine();
      line2 = br2.readLine();
      if (line1 == null || line2 == null) {
        if (line1 != null)
          eprintln(line1);
        else if (line2 != null)
          eprintln(line2);
        break;
      } 
      line1=line1.trim();
      line2=line2.trim();
      line1=line1.replaceAll("   "," ");
      line1=line1.replaceAll("  "," ");
      println(line1);
      line1=line1.replaceAll(" ","@");
      line2=line2.replaceAll("   "," ");
      line2=line2.replaceAll("  "," ");
      println(line2);
      line2=line2.replaceAll(" ","@");
      ArrayList<String> list1 = new ArrayList<String>();
      ArrayList<String> list2 = new ArrayList<String>();
      Collections.addAll(list1,line1.split("@"));
      Collections.addAll(list2,line2.split("@"));
      if (debug) {
        for (int i=0; i<list2.size(); i++) {
          String x = list2.get(i);
          int type = Util.tagToType(x);
          if (type == checktype) {
            got_words_sure++;
            list2.set(i, Util.tagToString(x));
          } else {
            list2.set(i, padding(Util.tagToString(x).length()));
          }
        }
      }
      ArrayList<String> common = cmp(list1, list2);
      all_words += list1.size();
      got_words += list2.size();
      right_words += common.size();
      all_words_nosign += noSign(list1);
      got_words_nosign += noSign(list2);
      right_words_nosign += noSign(common);
    }
    if (!debug) {
      double p = (double)right_words/got_words;
      double r = (double)right_words/all_words;
      double f = 2*p*r/(p+r);
      double p_nosign = (double)right_words_nosign/got_words_nosign;
      double r_nosign = (double)right_words_nosign/all_words_nosign;
      double f_nosign = 2*p_nosign*r_nosign/(p_nosign+r_nosign);
      eprintln("准确率:         %f (%d/%d)", p, right_words, got_words);
      eprintln("召回率:         %f (%d/%d)", r, right_words, all_words);
      eprintln("F-Score:        %f", f);
      eprintln("准确率(无标点): %f (%d/%d)", p_nosign, right_words_nosign, got_words_nosign);
      eprintln("召回率(无标点): %f (%d/%d)", r_nosign, right_words_nosign, all_words_nosign);
      eprintln("F-Score:        %f",f_nosign);
    } else {
      switch(checktype) {
        case 0: eprint("符号词准确率:   ");break;
        case 1: eprint("词典词准确率:   ");break;
        case 2: eprint("非词典词准确率: ");break;
        case 3: eprint("歧义词准确率:   ");break;
        default: eprint("类型参数错误...");break;
      }
      eprintln("%f (%d/%d)",((double)right_words/got_words_sure), right_words, got_words_sure);
    }
    br1.close();
    br2.close();
  }
  static void println(String format, Object ... args) {
    System.out.println(String.format(format,args));
  }
  static void print(String format, Object ... args) {
    System.out.print(String.format(format,args));
  }
  static void eprintln(String format, Object ... args) {
    System.err.println(String.format(format,args));
  }
  static void eprint(String format, Object ... args) {
    System.err.print(String.format(format,args));
  }
}
