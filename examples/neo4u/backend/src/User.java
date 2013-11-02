import java.io.*;
import java.util.*;


public class User {
	static DB db;
	String name;
	String PWD = new String("");
	String touxiang = new String("");
	String interest = new String("");
	boolean ismyfriend = false;
	User(){
	}
	User(String _name){
		name=_name;
	}
	User(String _name, String _pwd){
		name=_name;
		PWD = _pwd;
	}
	static boolean judgePWD(String login, String PWD){
		return db.judgePWD(login,PWD);
	}
	static boolean ifexist(String lookforname){
		return db.ifexist(lookforname);
	}
	Vector<User> searchUser(String sh){
		Vector<User> ret = db.searchUser(sh);
		for (User fri : ret){
			fri.ismyfriend = db.isFriend(name, fri.name);
		}
		System.out.println("SearchUser find "+ret.size());
		return ret;
	}
	boolean register(){
		return db.register(this);
	}
	void getProfile(){
		db.getProfile(this);
	}
	Vector<User> getFriends(){
		return db.getFriends(name);
	}
	Vector<User> getFriends(String lookupfriends){
		return db.lookupFriendName(name, lookupfriends);
	}
	Vector<User> getFriendsofFriend(){
		return db.getFriendsofFriend(name);
	}
	Vector<User> getFriendsofFriend_notFriend(){
		return db.getFriendsofFriend_notFriend(name);
	}
	Vector<User> getFriends_ismyfriend(String lookupfriends){
		User u = new User(lookupfriends);
		Vector<User> ret = u.getFriends();
		for (User fri : ret){
			fri.ismyfriend = db.isFriend(name, fri.name);
		}
		return ret;
	}
	Vector<User> getReverseFriend(){
		return db.getReverseFriends(name);
	}
	boolean addFriend(String newfriendname){
		return db.addFriends(name, newfriendname);
	}
	boolean deleteFriend(String friendname){
		return db.deleteFriends(name, friendname);
	}
	void showFriends(){
		for (User fri : getFriends()){
			System.out.println(name+" has friend "+fri.name);
		}
	}
	void showFriendsofFriend(){
		for (User fri : getFriendsofFriend()){
			System.out.println(name+" has friend_of_friend "+fri.name);
		}
	}
	void showFriendsofFriend_notFriend(){
		for (User fri : getFriendsofFriend_notFriend()){
			System.out.println(name+" has friend_of_friend_notFriend "+fri.name);
		}
	}
	void clearNews(){
		System.out.println(name+" clearNews");
		db.clearNews(name);
	}
	Vector<News> getNews(){
		return db.getNews(name);
	}
	Vector<News> getNewsofFriends(){
		return getNewsofFriends(null);
	}
	Vector<News> getNewsofFriends(String ddl){
		Vector<News> a = db.getNewsofFriends(name,ddl);
		int n = a.size();
		News[] s = new News[n];
		for (int i = 0; i<n; i++){
      s[i] = a.elementAt(i);
    }
		for (int i = 0; i<n; i++){
			for (int j = i+1; j<n; j++){
				if (s[i].posttime.compareTo(s[j].posttime) < 0){
					News tmp = s[i];
					s[i] = s[j];
					s[j] = tmp;
				}
			}
		}
		a.clear();
		for (int i = 0; i<n; i++){
			a.add(s[i]);
      System.out.println("XXXX "+s[i].posttime+" "+s[i].user);
		}
		return a;
	}
	void postNews(String s){
		System.out.println(name+" post news "+s+" "+News.format(new Date()));
		db.postNews(name, new News(s,name));
	}
	void showNewsofFriends(){
		System.out.println(name+" showNewsofFriends");
		for (News fs : getNewsofFriends()){
			System.out.println(name+" has news "+fs.user+" "+fs.posttime+" "+fs.message);
		}
	}
	void newsDelete(News news){
		System.out.println(name + "delete news "+news.posttime+" "+news.user);
		db.deleteNews(name, news);
	}
}
