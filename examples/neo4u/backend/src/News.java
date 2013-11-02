import java.io.*;
import java.util.*;
import java.text.*;

import org.neo4j.graphdb.*;
import org.neo4j.graphdb.factory.*;
import org.neo4j.kernel.impl.util.*;

public class News {
	String message;
	String posttime;
	String user;
	News(){
		message=new String("");
		posttime =  format();
		user = "err";
	}
	News(String _ns){
		message = _ns;
		posttime =  format();
		user = "err";
	}
	News(String _ns, String us){
		message = _ns;
		posttime =  format();
		user = us;
	}
	public static String format(Date d){
		return new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.SSSZ").format(d);
	}
	public static String format(){
		return format(new Date());
	}
}
