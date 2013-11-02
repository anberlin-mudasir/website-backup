import java.io.*;
import java.io.File;
import java.util.*;
public class SN {
	public static void main(String[] args){
		DB db = new DB("database");
		db.start();
		User.db = db;
		User u1 = new User("假腿",null);
		User u2 = new User("毛哥",null);
		User u3 = new User("2M",null);
		User p1 = new User("假腿的基友",null);
		User p2 = new User("毛哥的师姐",null);
		User p3 = new User("2M的月之女祭司",null);
		User lcc = new User("lcc",null);
		
		u1.register();
		u2.register();
		u3.register();
		p1.register();
		p2.register();
		p3.register();
		lcc.register();
		
		u1.addFriend(p1.name);
		u2.addFriend(p2.name);
		u3.addFriend(p3.name);
		lcc.addFriend(u1.name);
		lcc.addFriend(u2.name);
		lcc.addFriend(u3.name);
		UI ui = new UI();
		UI ui2 = new UI();
		
		//db.shutdown();
	}
}
