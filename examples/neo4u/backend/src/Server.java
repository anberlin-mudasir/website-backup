import java.util.*;
import java.io.*;
import java.net.*;

public class Server {
  public static String index_dir;
  public static DB db;
  
  public static void main(String[] args) throws Exception {
    if (args.length < 1){ 
      System.out.println("Usage: java "+Server.class.getName()
                         + " <index dir>");
      return;
    }
    index_dir = args[0];
    db = new DB(index_dir);
    if (!db.start()) {
      System.out.println("[error]:db failed to load...");
      return;
    }
    User.db=db;

    ServerSocket ss = new ServerSocket(10000);
    Socket socket;
  
    System.out.println("[infor]:listening...");
    while(true) {
      try {
        socket = ss.accept();
        BufferedReader br = new BufferedReader(new InputStreamReader(socket.getInputStream()));
        PrintWriter out = new PrintWriter(socket.getOutputStream(),true);
        ArrayList<String> query = new ArrayList<String>();
        String line;
        while((line=br.readLine()) != null) {
          line=line.trim();
          if (line.length() != 0) {
            query.add(line);
          }
        }
        if (query.size() == 0) {
          System.out.println("[query]:[null]");
        } else {
          System.out.println("[query]:["+join(query,",")+"]");
        }
        ArrayList<String> result = dispatch(query);
        String resp = join(result, "\n");
        
        System.out.println("[return]:"+resp);
        out.println(resp);
        br.close();
        out.close();
        socket.close();
      } catch (Exception e) {
        e.printStackTrace();
      }
    }
  }

  public static void newuser(ArrayList<String> res, String name, String pwd) {
    User u = new User(name, pwd);
    if (User.ifexist(name)) {
      res.add("exist");
      return;
    }
    if (u.register()) {
      res.add("success");
    } else {
      res.add("fail");
    }
  }
  public static void existuser(ArrayList<String> res, String name) {
    User u = new User(name, null);
    if (User.ifexist(name)) {
      res.add("exist");
    } else {
      res.add("nouser");
    }
  }
  public static void getmsg(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(target, null);
    Vector<News> news = u.getNews();
    for (News n : news) {
      res.add(n.message);
      res.add(n.posttime);
    }
  }
  public static void getnews(ArrayList<String> res, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, pwd);
    Vector<News> news = u.getNewsofFriends();
    for (News n : news) {
      res.add(n.user);
      res.add(n.message);
      res.add(n.posttime);
    }
  }
  public static void recommendfriends(ArrayList<String> res, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    Vector<User> users = u.getFriendsofFriend_notFriend();
    if (users == null)
      return;
    for (User n : users) {
      res.add(n.name);
    }
  }

  public static void getfriends(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    Vector<User> users = u.getFriends_ismyfriend(target);
    if (users == null)
      return;
    for (User n : users) {
      res.add(n.name);
      res.add(""+n.ismyfriend);
    }
  }


  public static void getreversefriends(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(target, null);
    Vector<User> users = u.getReverseFriend();
    if (users == null)
      return;
    for (User n : users) {
      res.add(n.name);
    }
  }

  public static void getfriendnum(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(target, null);
    Vector<User> users = u.getFriends();
    if (users == null)
      res.add("0");
    else
      res.add(""+users.size());
  }
  public static void getreversefriendnum(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(target, null);
    Vector<User> users = u.getReverseFriend();
    if (users == null)
      res.add("0");
    else
      res.add(""+users.size());
  }
  public static void setread(ArrayList<String> res, String target_name, String target_time, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    News n = new News();
    n.user=target_name.trim();
    n.posttime=target_time.replaceAll("#","+").trim();
    u.newsDelete(n);
    res.add("success");
  }
  public static void setallread(ArrayList<String> res, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    u.clearNews();
    res.add("success");
  }


  public static void setfriend(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    u.addFriend(target);
    res.add("success");
  }

  public static void delfriend(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    u.deleteFriend(target);
    res.add("success");
  }

  public static void search(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    Vector<User> users = u.searchUser(target+"*");
    if (users == null) {
      return;
    }
    for (User n : users) {
      res.add(n.name);
      res.add(""+n.ismyfriend);
    }
  }
  public static void postmsg(ArrayList<String> res, String str, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    u.postNews(str);
    res.add("success");
  }
  public static void isfriend(ArrayList<String> res, String target, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, null);
    if (u.db.isFriend(name, target)) {
      res.add("true");
    } else {
      res.add("false");
    }
  }
  public static void pullnews(ArrayList<String> res, String ddl, String name, String pwd) {
    if (!judge(res,name, pwd)) {
      return;
    }
    res.clear();
    User u = new User(name, pwd);
    String dl = ddl.replaceAll("#","+").trim();
    Vector<News> news ;
    if (dl.equals("0000")) {
      news = u.getNewsofFriends();
    } else {
      news = u.getNewsofFriends(dl);
    }
    if (news != null) {
      res.add(""+news.size());
    } else {
      res.add("0");
    }
    for (News n : news) {
      res.add(n.user);
      res.add(n.message);
      res.add(n.posttime);
    }
  }



  public static boolean judge(ArrayList<String> res, String name, String pwd) {
    User u = new User(name, pwd);
    if (!User.ifexist(name)) {
      res.add("nouser");
      return false;
    } else if (!User.judgePWD(name,pwd)) {
      res.add("fail");
      return false;
    } else {
      res.add("success");
      return true;
    }
  }

  public static ArrayList<String> dispatch(ArrayList<String> query) {
    ArrayList<String> res = new ArrayList<String>();
    String method = query.get(0);

    if (match(method,"newuser")) {
      if (query.size() == 3) 
        newuser(res, query.get(1), query.get(2));
    } else if (match(method,"existuser")) {
      if (query.size() == 2) 
        existuser(res, query.get(1));
    } else if (match(method, "getmsg")) {
      if (query.size() == 4) {
        getmsg(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "getfriends")) {
      if (query.size() == 4) {
        getfriends(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "getfriendnum")) {
      if (query.size() == 4) {
        getfriendnum(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "getreversefriends")) {
      if (query.size() == 4) {
        getreversefriends(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "getreversefriendnum")) {
      if (query.size() == 4) {
        getreversefriendnum(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "recommendfriends")) {
      if (query.size() == 3) {
        recommendfriends(res, query.get(1), query.get(2));
      }
    } else if (match(method, "judge")) {
      if (query.size() == 3) {
        judge(res, query.get(1), query.get(2));
      }
    } else if (match(method, "getnews")) {
      if (query.size() == 3) {
        getnews(res, query.get(1), query.get(2));
      }
    } else if (match(method, "setread")) {
      if (query.size() == 5) {
        setread(res, query.get(1), query.get(2), query.get(3), query.get(4));
      }
    } else if (match(method, "setallread")) {
      if (query.size() == 3) {
        setallread(res, query.get(1), query.get(2));
      }
    } else if (match(method, "setfriend")) {
      if (query.size() == 4) {
        setfriend(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "delfriend")) {
      if (query.size() == 4) {
        delfriend(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "search")) {
      if (query.size() == 4) {
        search(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "postmsg")) {
      if (query.size() == 4) {
        postmsg(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "isfriend")) {
      if (query.size() == 4) {
        isfriend(res, query.get(1), query.get(2), query.get(3));
      }
    } else if (match(method, "pullnews")) {
      if (query.size() == 4) {
        pullnews(res, query.get(1), query.get(2), query.get(3));
      }
    }

    if (res.size()==0) {
      res.add("fail");
    }
    return res;
  }

  public static boolean match(String a, String b) {
    if (a==null && b!=null)
      return false;
    return a.equals(b);
  }

  public static String join(ArrayList<String> set, String delimeter) {
    if (set == null || set.size() == 0)
      return "";
    String str="";
    for (String s : set) 
      str+=s+delimeter;
    return str.substring(0,str.length()-delimeter.length());
  }
  public static ArrayList<String> split(String s) {
    ArrayList<String> set = new ArrayList<String>();
    String[] ss = s.split("\\s");
    for (String str: ss) 
      set.add(str);
    return set;
  }
}
