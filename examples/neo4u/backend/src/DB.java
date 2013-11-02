import java.io.*;
import java.util.*;
import java.text.*;


import org.neo4j.graphdb.*;
import org.neo4j.graphdb.factory.*;
import org.neo4j.kernel.impl.util.*;
import org.neo4j.graphdb.index.*;
import org.neo4j.helpers.collection.IteratorUtil;
import org.neo4j.cypher.javacompat.*;

public class DB {
	public static String DB_PATH;// = "database";
	private static final String USERNAME_KEY = "username";
	private static final String PWD_KEY = "userpwd";
	private static final String LASTCLEAR_KEY = "lastclear";
	private static final String NEWSMESSAGE_KEY = "newsmessage";
	private static final String NEWSPOSTTIME_KEY = "newsposttime";
	private static final String NEWSUSER_KEY = "newsuser";
	private static final String TOUXIANG_KEY = "touxiang";
	private static final String INTEREST_KEY = "interest";
	
    private static GraphDatabaseService graphDb;
    private static Index<Node> userIndex;
  
   public DB(String path) {
     DB_PATH = path;
   }
    static void printK(String s){
//    	System.out.println(s);
    }
    static void printO(String s){
//    	System.out.println(s);
    }
    private static enum RelTypes implements RelationshipType {
        friend,
        nextnews,
        ROOTTOUSER,
        USERS_REFERENCE,
        friendnameindex,
        deletenews,
        clearException;
    }
    
    private void deleteDir(File f) {
    	if (f == null) return ;
    	if (f.isDirectory()){
	        File fs[] = f.listFiles(); 
	        for (int i = 0; i < fs.length; i++) {
	            deleteDir(fs[i]);
	        } 
    	}
        f.delete();
    }


    
    public boolean start() {
        // START SNIPPET: startDb
    	//deleteDir(new File("C:\\Users\\lccycc\\workspace\\SN\\"+DB_PATH));

        graphDb = new GraphDatabaseFactory().newEmbeddedDatabase( DB_PATH );
        userIndex = graphDb.index().forNodes( "users" );
        registerShutdownHook();
        // END SNIPPET: startDb

        // START SNIPPET: addUsers
        boolean success = false;
        Transaction tx = graphDb.beginTx();
        try {
            // Create users sub reference node
            Node usersReferenceNode = graphDb.createNode();
            graphDb.getReferenceNode().createRelationshipTo(
                usersReferenceNode, RelTypes.USERS_REFERENCE );

            tx.success();
            success = true;
        }finally {
            tx.finish();
        }
        return success;
    }
    public boolean ifexist(String lookforname){
    	Node foundUser = null;
    	Transaction tx = graphDb.beginTx();
    	try {
	    	foundUser = userIndex.query( USERNAME_KEY,
	                lookforname ).getSingle();
	    	tx.success();
    	}finally{
    		tx.finish();
    	}
    	if (foundUser != null) printK("exist");
    	else printK("not exist");
    	return foundUser != null;
    }
    public boolean judgePWD(String login,String PWD){
    	String res = null;
    	Transaction tx = graphDb.beginTx();
    	try {
	    	Node n = lookfor(login);
	    	if (n != null){
	    		res = (String)n.getProperty(PWD_KEY);
	    	}
	    	tx.success();
    	}finally{
    		tx.finish();
    	}
    	return res != null && res.equals(PWD);
    }
    public boolean register(User newuser){
    	printK(newuser.name);
    	if (!ifexist(newuser.name)){
    		createAndIndexUser(newuser);
    		return true;
    	}
    	return false;
    }
    public void getProfile(User u){
    	User ut = node2User(lookfor(u.name));
    	u.name = ut.name;
    	u.touxiang = ut.touxiang;
    	u.interest = ut.interest;
    	/*
    	 * PWD is not show
    	 */
    }
    public Vector<User> searchUser(String sh){
	   	 Vector<User> res = new Vector<User>();
	   	 Transaction tx = graphDb.beginTx();
		 try {
			 IndexHits<Node> md = userIndex.query( USERNAME_KEY, sh );
		     for(Node n : md){
		       		res.add(node2User(n));
		     }
		   	tx.success();
		 }finally {
		   	tx.finish();
		 }
		 return res;
   }
   public Vector<User> getFriends(String user){
    	Vector<User> res = new Vector<User>(); 
    	for (Node n : getFriendNodes(user)){
    		res.add(node2User(n));
    	}
    	return res;
    }
    public Vector<User> getReverseFriends(String user){
    	Vector<User> res = new Vector<User>(); 
    	for (Node n : getReverseFriendNodes(user)){
    		res.add(node2User(n));
    	}
    	return res;
    }

    public Vector<User> getFriendsofFriend(String s){
    	Vector<User> res = new Vector<User>(); 
    	for(Node n : getFriendsofFriend(lookfor(s))){
    		res.add(node2User(n));
    	}
    	return res;
    }
    public Vector<User> getFriendsofFriend_notFriend(String s){
    	Vector<User> res = new Vector<User>(); 
    	for(Node n : getFriendsofFriend_notFriend(lookfor(s))){
    		User a = node2User(n);
        if (!a.name.equals(s)){
          res.add(a);
        }
    	}
    	return res;
    }
    //if to is a friend of from;
    boolean isFriend(String from, String to){
    	Node ff = lookfor(from), tt = lookfor(to);
    	boolean ret;
    	if (ff == null || tt == null){
    		return false;
    	}
    	Transaction tx = graphDb.beginTx();
        try {
        	RelationshipIndex friendr = getFriendNameIndex(from);
        	Relationship rel =  friendr.query(USERNAME_KEY, to).getSingle();
        	if (rel != null){
        		//ret = false;
        		ret = true;
        	}else{
        		//ret = true;
        		ret = false;
        	}
    		tx.success();
        }finally {
        	tx.finish();
        }
    	//dangerous here, don't know if we can change property
    	//may add the same friend twice
    	return ret;
    }
    boolean addFriends(String from, String to){
    	if (from.equals(to)) return false;
    	Node ff = lookfor(from), tt = lookfor(to);
    	boolean ret;
    	if (ff == null || tt == null){
    		printK("addFriends fail");
    		return false;
    	}
    	Transaction tx = graphDb.beginTx();
        try {
        	RelationshipIndex friendr = getFriendNameIndex(from);
        	Relationship rel =  friendr.query(USERNAME_KEY, to).getSingle();
        	if (rel != null){
        		ret = false;
        	}else{
        		rel = ff.createRelationshipTo( tt,
        				RelTypes.friend );
    	
        		friendr.add(rel, USERNAME_KEY, to);
        		ff.createRelationshipTo( tt, RelTypes.clearException );
        		ret = true;
        	}
    		tx.success();
        }finally {
        	tx.finish();
        }
    	//dangerous here, don't know if we can change property
    	//may add the same friend twice
    	return ret;
    }
    Vector<User> lookupFriendName(String from, String to){
    	Node ff = lookfor(from);
    	if (ff == null){
    		return null;
    	}
    	Vector<User> res = new Vector<User>();
    	
    	
    	Transaction tx = graphDb.beginTx();
        try {
        	RelationshipIndex friendr = getFriendNameIndex(from);
        	IndexHits<Relationship> gg = friendr.query(USERNAME_KEY, to);
        	while (gg.hasNext()){
        		res.add(node2User(gg.next().getEndNode()));
        	}
        	gg.close();
	    	
        	tx.success();
        }finally {
        	tx.finish();
        }
    	return res;
    }
    boolean deleteFriends(String from, String to){
    	boolean ret;
    	Transaction tx = graphDb.beginTx();
        try {
	    	Node ff = lookfor(from);
	    	if (ff == null){
	    		ret = false;
	    	}else{
	    		RelationshipIndex friendr = getFriendNameIndex(from);
	    		Relationship gg = friendr.query(USERNAME_KEY, to).getSingle();
	    		if (gg == null) {
	    			printK("can't find gg");
	    			ret = false;
	    		}else{
	    			friendr.remove(gg);	
	    			ret = true;
	    		}
	    		gg.delete();
	    	}
	    	tx.success();
        }finally {
        	tx.finish();
        }
    	return ret;
    }
    
    public Vector<News> getNews(String user){
    	return getNews(lookfor(user), new String(""));
    }
    public Vector<News> getNewsofFriends(String user,String ddl){
    	Vector<News> res = new Vector<News>();
    	Transaction tx = graphDb.beginTx();
        try {
        	Node n = lookfor(user);
        	Vector<News> dln = getDeleteNews(n);
        	Vector<User> clu = getClearException(n);
        	String lastddl = null;
          lastddl = (String)n.getProperty(LASTCLEAR_KEY);
          if(ddl != null && ddl.compareTo(lastddl)<0){
            ddl = lastddl;
          }
        	for (Node fri:getFriendNodes(user)){        		
        		boolean cleare = false;
        		User ff = node2User(fri);
        		for (User uff : clu){
        			if (ff.name.equals(uff.name)){
        				cleare = true;
        				break;
        			}
        		}
        		Vector<News> get;
        		if (cleare && ddl == null){
        			get = getNews(fri,new String(""));
        		}else if (ddl == null){
        			get = getNews(fri, lastddl);
        		}else{
        			get = getNews(fri, ddl);
        		}
        		for (News gg : get){//judge if deleted
        			boolean err = false;
        			for (News dl : dln){
        				if (gg.posttime.equals(dl.posttime) && gg.user.equals(dl.user)){
        					err = true;
        					break;
        				}
        			}
        			if (!err){
        				res.add(gg);
        			}
        		}
        	}
        	tx.success();
        }finally {
        	tx.finish();
        }
        return res;
    }
    public void postNews(String user, News news){
    	Transaction tx = graphDb.beginTx();
        try {
        	Node n = lookfor(user);
        	
        	Node newnews = graphDb.createNode();
    	    newnews.setProperty(NEWSMESSAGE_KEY, news.message);
    	    newnews.setProperty(NEWSPOSTTIME_KEY, news.posttime);
    	    newnews.setProperty(NEWSUSER_KEY, user);
    	    
    	    if (n.hasRelationship(
    	        	RelTypes.nextnews, Direction.OUTGOING )){
    	    		Relationship lastnewsrela = n.getRelationships(
    	        	RelTypes.nextnews, Direction.OUTGOING ).iterator().next();
    	    		Node lastnews = lastnewsrela.getEndNode();
    	    		lastnewsrela.delete();
    	    		newnews.createRelationshipTo(lastnews, RelTypes.nextnews);
    	    }
    	    n.createRelationshipTo(newnews, RelTypes.nextnews);
    	    
        	tx.success();
        }finally {
        	tx.finish();
        }
    }
    public  void clearNews(String user){
    	Transaction tx = graphDb.beginTx();
        try {
        	Node n = lookfor(user);
        	n.removeProperty(LASTCLEAR_KEY);
        	n.setProperty(LASTCLEAR_KEY,News.format());
          deleteException(n);
        	tx.success();
        }finally {
        	tx.finish();
        }
    }
    public void saveUserProperty(User user){
    	Node node = lookfor(user.name);
    	if (node != null){
    		saveUserProperty(user,node);
    	}
    }
    public  void shutdown() {
    	printK("shut down dbs");
        graphDb.shutdown();
    }
    public void deleteNews(String user, News news){
    	Transaction tx = graphDb.beginTx();
        try {
        	Node nd = graphDb.createNode();
        	news.message = new String();
        	nd.setProperty(NEWSMESSAGE_KEY, news.message);
    	    nd.setProperty(NEWSPOSTTIME_KEY, news.posttime);
    	    nd.setProperty(NEWSUSER_KEY, news.user);
        	Node us = lookfor(user);
        	us.createRelationshipTo(nd, RelTypes.deletenews);
        	tx.success();
	    } finally {
	        tx.finish();
	    }
    }
//----------------------------------------------------------------------------
    private void deleteException(Node userNode){
    	Transaction tx = graphDb.beginTx();
        try {
	    	for ( Relationship dnl : userNode.getRelationships(
	        	RelTypes.clearException, Direction.OUTGOING ) ) {
            dnl.delete();
	        }
        	tx.success();
	    } finally {
	        tx.finish();
	    }
    }

    private Vector<News> getDeleteNews(Node userNode){
    	Vector<News> res = new Vector<News>();
    	Transaction tx = graphDb.beginTx();
        try {
	    	for ( Relationship dnl : userNode.getRelationships(
	        	RelTypes.deletenews, Direction.OUTGOING ) ) {
	    		Node dn = dnl.getEndNode();
	    		res.add(node2News(dn));
	        }
        	tx.success();
	    } finally {
	        tx.finish();
	    }
        return res;
    }
    private Vector<User> getClearException(Node userNode){
    	Vector<User> res = new Vector<User>();
    	Transaction tx = graphDb.beginTx();
        try {
	    	for ( Relationship dnl : userNode.getRelationships(
	        	RelTypes.clearException, Direction.OUTGOING ) ) {
	    		Node dn = dnl.getEndNode();
	    		res.add(node2User(dn));
	        }
        	tx.success();
	    } finally {
	        tx.finish();
	    }
        return res;
    }
    private Node lookfor(String username){
    	Node res;
    	Transaction tx = graphDb.beginTx();
        try {
        	res = userIndex.query( USERNAME_KEY,
                username ).getSingle();
        	if (res == null){
        		printK("lookfor fail "+username);
        	}
        	tx.success();
        }finally {
        	tx.finish();
        }
        return res;
    }
    
    private User node2User(Node n){
    	User u = new User();
    	u.name = (String)n.getProperty(USERNAME_KEY);
    	u.PWD = (String)n.getProperty(PWD_KEY);
    	u.touxiang = (String)n.getProperty(TOUXIANG_KEY);
    	u.interest = (String)n.getProperty(INTEREST_KEY);
    	return u;
    }
    private Vector<Node> getFriendNodes(String username){
    	Vector<Node> res = new Vector<Node>();
    	Transaction tx = graphDb.beginTx();
        try {
        	Node userNode = lookfor(username);
	    	for ( Relationship friend : userNode.getRelationships(
	        	RelTypes.friend, Direction.OUTGOING ) ) {
	    		Node user = friend.getEndNode();
	    		res.add(user);
	        }
	    	tx.success();
        }finally {
        	tx.finish();
        }
    	return res;
    }
    private Vector<Node> getReverseFriendNodes(String username){
    	Vector<Node> res = new Vector<Node>();
    	Transaction tx = graphDb.beginTx();
        try {
        	Node userNode = lookfor(username);
	    	for ( Relationship friend : userNode.getRelationships(
	        	RelTypes.friend, Direction.INCOMING ) ) {
	    		Node user = friend.getEndNode();
	    		res.add(user);
	        }
	    	tx.success();
        }finally {
        	tx.finish();
        }
    	return res;
    }
    private Vector<Node> getFriendsofFriend(Node n){
    	String q = "START joe=node("+n.getId()+")"
    			+ " MATCH joe-[:friend]->friend-[:friend]->friend_of_friend"
    			+ " RETURN friend_of_friend, COUNT(*)"
    			+ " ORDER BY COUNT(*) DESC, friend_of_friend."+USERNAME_KEY;
    	ExecutionEngine engine = new ExecutionEngine( graphDb );
        ExecutionResult result = engine.execute(q);
        
        Iterator<Node> n_column = result.columnAs( "friend_of_friend" );
        Vector<Node> res = new Vector<Node>();
        for ( Node node : IteratorUtil.asIterable( n_column ) ){
        	res.add(node);
        }
        return res;
    }
    private Vector<Node> getFriendsofFriend_notFriend(Node n){
    	String q = "START joe=node("+n.getId()+")"
    			+ " MATCH joe-[:friend]->friend-[:friend]->friend_of_friend"
    			+ " , joe-[r?:friend]->friend_of_friend"
    			+ " WHERE r IS NULL"
    			+ " RETURN friend_of_friend, COUNT(*)"
    			+ " ORDER BY COUNT(*) DESC, friend_of_friend."+USERNAME_KEY;
    	
    	ExecutionEngine engine = new ExecutionEngine( graphDb );
        ExecutionResult result = engine.execute(q);
        
        Iterator<Node> n_column = result.columnAs( "friend_of_friend" );
        Vector<Node> res = new Vector<Node>();
        for ( Node node : IteratorUtil.asIterable( n_column ) ){
        	res.add(node);
        }
        return res;
    }
   
    private News node2News(Node n){
    	News ns = new News();
    	ns.message = (String)n.getProperty(NEWSMESSAGE_KEY);
    	ns.posttime =  (String)n.getProperty(NEWSPOSTTIME_KEY);
    	ns.user = (String)n.getProperty(NEWSUSER_KEY);
    	return ns;
    }
    
    private Vector<News> getNews(Node n, String ddl){
    	Vector<News> res = new Vector<News>();
    	Transaction tx = graphDb.beginTx();
        try {
        	Relationship lastnewsrela = n.getRelationships(
    	        	RelTypes.nextnews, Direction.OUTGOING ).iterator().next();
        	
    	    News lastnews = node2News(lastnewsrela.getEndNode());
    	    
    	    while (lastnews.posttime.compareTo(ddl) > 0){
    	    	printK("find news "+lastnews.message);
    	    	res.add(lastnews);
    	    	if (lastnewsrela.getEndNode().hasRelationship(RelTypes.nextnews, Direction.OUTGOING )){
    	    		lastnewsrela = lastnewsrela.getEndNode().getRelationships(RelTypes.nextnews, Direction.OUTGOING).iterator().next();
    	    	}else{
    	    		break;
    	    	}
    	    	lastnews = node2News(lastnewsrela.getEndNode());
    	    }
        	tx.success();
        }finally {
        	tx.finish();
        }
        return res;
    }
   
    private  String userFriendNameIndexName( String username ) {
    	return username + "friendIndex";
    }

    private  RelationshipIndex getFriendNameIndex(String name){
    	return graphDb.index().forRelationships(userFriendNameIndexName(name));
    }
    
    private void valiUserProperty(Node node, String key, String value){
    	Transaction tx = graphDb.beginTx();
        try {
        	if (node.hasProperty(key)){
        		node.removeProperty(key);
        	}
        	node.setProperty(key, value); 
        	tx.success();
	    } finally {
	        tx.finish();
	    }
    }
    private  void saveUserProperty(User user, Node node){
        valiUserProperty(node, USERNAME_KEY, user.name );
        valiUserProperty(node, PWD_KEY, user.PWD );
        valiUserProperty(node, TOUXIANG_KEY, user.touxiang);
        valiUserProperty(node, INTEREST_KEY, user.interest);
        	
    }
    private  Node createAndIndexUser(User newuser) {
    	printK("Create!");
    	Node node;
    	Transaction tx = graphDb.beginTx();
        try {
	        node = graphDb.createNode();
	       
	        saveUserProperty(newuser, node);
	        
	        userIndex.add( node, USERNAME_KEY, newuser.name );
	        
	        //clearNews(newuser.name);
	        node.setProperty(LASTCLEAR_KEY,"");
	        postNews(newuser.name, new News("hi I'm "+newuser.name+" !"));
	        //String idxname = userFriendNameIndexName(newuser.name);
	        //Index<Relationship> friendNameIndex = graphDb.index().forRelationships(userFriendNameIndexName(newuser.name));
	        tx.success();
        } finally {
            tx.finish();
        }
        return node;
    }
    // END SNIPPET: helperMethods
    private  void registerShutdownHook() {
        // Registers a shutdown hook for the Neo4j and index service instances
        // so that it shuts down nicely when the VM exits (even if you
        // "Ctrl-C" the running example before it's completed)
        Runtime.getRuntime().addShutdownHook( new Thread() {
            @Override
            public void run() {
                shutdown();
            }
        } );
    }
}
