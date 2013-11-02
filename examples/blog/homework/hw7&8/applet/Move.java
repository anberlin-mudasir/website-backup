import java.awt.*;
import java.applet.*;
import java.util.Random;
public class Move extends Applet implements Runnable 
{
    Thread runner;
    Image Buffer;
    Graphics gBuffer;
    Ball []balls=new Ball[3];
	Random []rands=new Random[3];
		
    public void init()
    {
        Buffer=createImage(getWidth(),getHeight());
        gBuffer=Buffer.getGraphics();
				
		int w=getWidth();
        int h=getHeight();
		
        for (int i=0; i<3; i++)
        {
	        rands[i] = new Random();
            balls[i]=new Ball(w,h,80+rands[i].nextInt(w-160),80+rands[i].nextInt(w-160),(rands[i].nextFloat()-0.5)*10,(rands[i].nextFloat()-0.5)*10);
        }
    }
    public void start()
    {
        if (runner == null)
        {
            runner = new Thread (this);
            runner.start();
        }
    }
    public void stop()
    {
        if (runner != null)
        {
            stop();
            runner = null;
        }
    }
    public void run()
    {
        while(true)
        {
            try {runner.sleep(15);}
            catch (Exception e) { }
            for (int i=0; i<3; i++)
                balls[i].move();
            repaint();
        }
    }
    public void update(Graphics g)
    {
        paint(g);
    }
    public void paint(Graphics g)
    {
        gBuffer.setColor(Color.black);
        gBuffer.fillRect(0,0,300,300);
        for (int i=0; i<3; i++)
            balls[i].paint(gBuffer);
        g.drawImage (Buffer,0,0, this);
    }
}
class Ball
{
    int width, height;
    static final int diameter=80;
    double x, y, xinc, yinc;
    Graphics g;

    public Ball(int w, int h, int x, int y, double xinc, double yinc)
    {
        this.width=w;
        this.height=h;
        this.x=x;
        this.y=y;
        this.xinc=xinc;
        this.yinc=yinc;
    }
    public void move()
    {
        x+=xinc;
        y+=yinc;        
        if(x<0 || x>width-diameter)
        {
            xinc=-xinc;
            x+=xinc;
        }
        if(y<0 || y>height-diameter)
        {
            yinc=-yinc;
            y+=yinc;
        }
    }
    public void paint(Graphics gr)
    {
        g=gr;
		g.setColor(Color.white);
        g.fillOval((int)x,(int)y,diameter,diameter);
    }
}
