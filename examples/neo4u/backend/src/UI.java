import javax.swing.*;//框架

import java.awt.*;//字体

import java.awt.event.*;//事件监听

import java.lang.*;
import javax.swing.*;
import javax.swing.text.*;
import javax.swing.event.*;


import java.util.*;
import java.util.Timer;
class STOPS{
	static public boolean Stops = false;
}

public class UI extends JFrame{
	UI(){
		new Login();
		this.addWindowListener(new WindowAdapter(){
			public void windowClosing(WindowEvent e) {
				STOPS.Stops = true;
				User.db.shutdown();
				System.exit(0);
			}
		});
		try{
		UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
		}catch (Exception e){e.printStackTrace();}
	}
	public class Login extends JFrame{
		 public JPanel pnluser;
		 public JLabel lbluserLogIn;
		 public JLabel lbluserName;
		 public JLabel lbluserPWD;
		 public JTextField txtName;
		 public JPasswordField pwdPwd;
		 public JButton btnSub;
		 public JButton btnReset;
		 public JButton btnRegister;
		 
		 public Login(){
		  pnluser = new JPanel();
		  lbluserLogIn = new JLabel();
		  lbluserName = new JLabel();
		  lbluserPWD = new JLabel();
		  txtName = new JTextField();
		  pwdPwd = new JPasswordField();
		  btnSub = new JButton();
		  btnReset = new JButton();
		  btnRegister = new JButton();
		  userInit();
		 }

		 public void userInit(){
		  this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);//设置关闭框架的同时结束程序
		  this.setSize(600,200);//设置框架大小为长300,宽200
		  this.setResizable(false);//设置框架不可以改变大小
		  this.setTitle("User Login");//设置框架标题
		  this.pnluser.setLayout(null);//设置面板布局管理

		  this.lbluserLogIn.setText("User Login");//设置标签标题
		  this.lbluserLogIn.setFont(new Font("宋体",Font.BOLD | Font.ITALIC,14));//设置标签字体
		  this.lbluserName.setText("User Name:");
		  this.lbluserPWD.setText("Password:");
		  this.btnSub.setText("Login");
		  this.btnReset.setText("Reset");
		  this.btnRegister.setText("Register Now!");
		  this.lbluserLogIn.setBounds(120,15,120,20);//设置标签x坐标120,y坐标15,长60,宽20
		  this.lbluserName.setBounds(50,55,120,20);
		  this.lbluserPWD.setBounds(50,85,120,25);
		  this.txtName.setBounds(200,55,240,20);
		  this.pwdPwd.setBounds(200,85,240,20);
		  
		  this.btnSub.setBounds(85,120,120,20);
		  this.btnSub.addActionListener(new ActionListener()//匿名类实现ActionListener接口
		   {
		    public void actionPerformed(ActionEvent e){
		     btnsub_ActionEvent(e);
		    }    
		   }
		  ); 
		  this.btnReset.setBounds(205,120,120,20);
		  this.btnReset.addActionListener(new ActionListener()//匿名类实现ActionListener接口
		   {
		    public void actionPerformed(ActionEvent e){
		     btnreset_ActionEvent(e);
		    }    
		   }
		  );
		  this.btnRegister.setBounds(325,120,120,20);
		  this.btnRegister.addActionListener(new ActionListener()
		   {
		    public void actionPerformed(ActionEvent e){
			     btnregister_ActionEvent(e);
			    }    
			   }
		  );   
		  this.pnluser.add(lbluserLogIn);//加载标签到面板
		  this.pnluser.add(lbluserName);
		  this.pnluser.add(lbluserPWD);
		  this.pnluser.add(txtName);
		  this.pnluser.add(pwdPwd);
		  this.pnluser.add(btnSub);
		  this.pnluser.add(btnReset);
		  this.pnluser.add(btnRegister);
		  this.add(pnluser);//加载面板到框架
		  this.setVisible(true);//设置框架可显  
		 }
		 
		 public void btnsub_ActionEvent(ActionEvent e){
		  String name = txtName.getText();
		  String pwd = String.valueOf(pwdPwd.getPassword());
		  System.out.println("UI Login try "+name);
		  if (User.judgePWD(name, pwd)){
			  loginsucc(new String(name));
			  this.dispose();
		  }else{
		   JOptionPane.showMessageDialog(null,"err","err",JOptionPane.ERROR_MESSAGE);
		   return;
		  }
		 }
		 public void btnregister_ActionEvent(ActionEvent e){
			  User us = new User();
			  us.name = txtName.getText();
			  System.out.println("UI register try "+us.name);
			  us.PWD =  String.valueOf(pwdPwd.getPassword());
			  if (us.register()){
				  System.out.println("UI register success "+us.name);
				  loginsucc(new String(us.name));
				  this.dispose();
			  }else{
				   JOptionPane.showMessageDialog(null,"err","err",JOptionPane.ERROR_MESSAGE);
				   return;
			  }
		 }
		 public void btnreset_ActionEvent(ActionEvent e){
		  txtName.setText("");
		  pwdPwd.setText("");
		 }
	}
//---------------------------------------------------------
	class UserScreen extends JPanel{
		UserButton uname = new UserButton();
	//	JButton editprofile = new JButton();
		UserScreen(String s){
			uname.setText(s);
			JSplitPane js1 = new JSplitPane(JSplitPane.VERTICAL_SPLIT);
			JSplitPane js2 = new JSplitPane(JSplitPane.VERTICAL_SPLIT);
			JSplitPane js3 = new JSplitPane(JSplitPane.VERTICAL_SPLIT);
			js1.setLeftComponent(uname);
			js1.setRightComponent(js2);
			js2.setLeftComponent(new UserPost(s));
			js2.setRightComponent(js3);
			js3.setLeftComponent(new AddFriend(s));
			//js3.setRightComponent(new Button());
			this.add(js1);
		}
	}
	class ProfileScreen extends JPanel{
		JTextPane profile = new JTextPane();
		ProfileScreen(String name){
			User u = new User(name, "");
			u.getProfile();
			profile.setText(u.name );//+ " " + " age:" + u.age + " interest:" + u.interest);
			this.add(profile);
		}
	}
	class FriendnewsScreen extends JPanel{
		User u;
		F5 f;
		JTextPane jt =  new JTextPane();
		JTextPane title = new JTextPane();
		Box box = Box.createVerticalBox();
		class F5 extends Thread {
			FriendnewsScreen ths;
			F5(FriendnewsScreen t){ths = t;}
			String ddl = null;
			public void run() {
				while (!STOPS.Stops){
					for (News n : u.getNewsofFriends(ddl)){
						jt.setText(n.user+"\n"+n.message+"\n"+n.posttime+"\n\n" + jt.getText());
					}
					ddl = News.format(new Date());
					ths.validate();
					try{
						sleep(2000);
					} catch (Exception e){
						e.printStackTrace();
					}
				}
			}
		}
		FriendnewsScreen(String name){
			u = new User(name, "");
			f = new F5(this);
			title.setText("新鲜事");
			box.add(title);
			box.add(jt);
			add(box);
			f.start();
			this.setVisible(true);
		}
		
	}
	class NewsScreen extends JPanel{
		JTextPane jt = new JTextPane();
		NewsScreen(String s){
			User u = new User(s, "");
			for (News n : u.getNews()){
				jt.setText(jt.getText()+n.user+"\n"+n.message+"\n"+n.posttime+"\n\n");
			}
			add(jt);
			validate();
		}
	}
	class UserButton extends JButton{
		UserButton(){
			this.addActionListener(new ActionListener() {
			    public void actionPerformed(ActionEvent e){
			     friendClick(e);
			    }    
			   }
			  ); 
		}
		public void friendClick(ActionEvent e){
		  new HomePage(this.getText());
		}
	}
	class FriendlistScreen extends JPanel{
		FriendlistScreen(String s){
			Box box = Box.createVerticalBox();
			User u = new User(s, "");
			JTextPane title = new JTextPane();
			title.setText("你的好友");
			box.add(title);
			for (User f : u.getFriends()){
				//UserButton bt = new UserButton();
				UserButton bt = new UserButton();
				bt.setText(f.name);
				box.add(bt);
			}
			this.add(box);
		}
	}
	class UserlistScreen extends JPanel{
		UserlistScreen(Vector<User> ul){
			for (User f : ul){
				//UserButton bt = new UserButton();
				UserButton bt = new UserButton();
				bt.setText(f.name);
				this.add(bt);
			}
			this.validate();
		}
	}
	class HomePage extends JFrame{
		HomePage(String name){
			setExtendedState( JFrame.MAXIMIZED_BOTH );
			
			
			JSplitPane mr = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, true  );
			JSplitPane l = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, true);
			add(l);
			l.setDividerLocation(0.25);
			l.setLeftComponent( new ProfileScreen(name));
			l.setRightComponent(mr);

			mr.setLeftComponent(new NewsScreen(name));
			mr.setRightComponent(new FriendlistScreen(name));
			
			mr.setDividerLocation(500);
			
			mr.validate();
			this.setVisible(true);
			this.validate();
		}
	}
	class UserPost extends JPanel{
		JTextField mes = new JTextField(10);
		JButton bt = new JButton("post!");
		String name;
		UserPost(String s){
			name = s;
			add(mes);
			add(bt);
			bt.addActionListener(new ActionListener()  {
			    public void actionPerformed(ActionEvent e){
			    	newapost();
			    }    
			   }
			  );
		}
		void newapost(){
			User u = new User(name, "");
			u.postNews(mes.getText());
		}
	}
	class SearchUser extends JSplitPane{
		JTextField t = new JTextField(10);
		JButton bt = new JButton("find someone!");
		UserlistScreen uls = null;
		SearchUser(){
			JPanel left = new JPanel(); 
			this.setOrientation(JSplitPane.VERTICAL_SPLIT);
			this.setDividerSize(0);
			this.setLeftComponent(left);
			this.setRightComponent(new JPanel());
			//this.setDividerLocation(40);
			left.add(t);
			left.add(bt);
			bt.addActionListener(new ActionListener()  {
			    public void actionPerformed(ActionEvent e){
			    	searchUser();
			    }
			   }
			  );
		}
		void searchUser(){
      /*
			if (uls != null){
				this.remove(uls);
			}
			this.setRightComponent(uls = new UserlistScreen(User.searchUser(t.getText())));
			uls.validate();
			this.validate();*/
		}
	}
	class AddFriend extends JPanel{
		Box box = Box.createVerticalBox();
		JTextField t = new JTextField(10);
		JButton bt = new JButton("add someone as friend!");
		JTextPane suc = new JTextPane();
		String name;
		AddFriend(String s){
			name = s;
			box.add(t);
			box.add(bt);
			box.add(suc);
			this.add(box);
			bt.addActionListener(new ActionListener()  {
			    public void actionPerformed(ActionEvent e){
			    	addfriend();
			    }
			   }
			  );
		}
		void addfriend(){
			User u = new User(name, "");
			if (u.addFriend(t.getText())){
				suc.setText("Success!");
			}else{
				suc.setText("Fail!");
			}
			this.validate();
		}
	}
	class FOF extends JPanel{
		FOF(String s){
			User u = new User(s, "");
			
			Box box = Box.createVerticalBox();
			JTextPane title = new JTextPane();
			title.setText("推荐好友");
			box.add(title);
			for (User f : u.getFriendsofFriend_notFriend()){
				UserButton ub = new UserButton();
				ub.setText(f.name);
				box.add(ub);
			}
			this.add(box);
			this.validate();
		}
	}
	void loginsucc(String name){
		System.out.println("UI Login success "+name);
		setExtendedState( JFrame.MAXIMIZED_BOTH );
		
		JSplitPane r12 = new JSplitPane(JSplitPane.VERTICAL_SPLIT, true  );//right up
		//for Friends, Search, FoF
		JSplitPane r23 = new JSplitPane(JSplitPane.VERTICAL_SPLIT, true  );//right up
		//for FoF
		JSplitPane mr = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, true  );
	
		JSplitPane l = new JSplitPane(JSplitPane.HORIZONTAL_SPLIT, true);
		

		add(l);
		
		l.setDividerLocation(0.25);
		
		l.setLeftComponent( new UserScreen(name));
		l.setRightComponent(mr);
		
		FriendnewsScreen fns = new FriendnewsScreen(name);
		mr.setLeftComponent(fns);
		mr.setRightComponent(r12);
		
		r12.setLeftComponent(new FriendlistScreen(name));
		r12.setRightComponent(r23);
		r23.setLeftComponent(new SearchUser());
		r23.setRightComponent(new FOF(name));
		
		mr.setDividerLocation(500);
		
		this.validate();
		
		this.setVisible(true);
	}
}
