import java.awt.*;
import java.applet.*;

public class SimpleDraw extends Applet 
{
    Font strFont;
    Color redColor;
    Color greenColor;
    Color bgColor;

    public void init() 
    {
        strFont = new Font("Arial",Font.BOLD,16);
        redColor = Color.red;
        greenColor = Color.green;
        bgColor = new Color(0.5f,0.5f,0.5f,0.5f);
        setBackground(bgColor);
    }
    public void stop() {}

    public void paint(Graphics g) 
    {
        g.setFont(strFont);
        g.drawString("Shapes and Colors",80,20);
        // Prepare to draw red component 
        g.setColor(redColor);
        // Draw a rectangle (xco,yco,xwidth,height);
        g.drawRect(100,100,100,100);
        // Fill a rectangle
        g.fillRect(110,110,80,80);
        // Now tell g to change the color
        g.setColor(greenColor);
        // Draw circle (int x, int y, int width, int height);
        g.drawOval(115,115,70,70);
        // Fill a circle 
        g.fillOval(120,120,60,60);
        g.setColor(Color.black);
    }
}
