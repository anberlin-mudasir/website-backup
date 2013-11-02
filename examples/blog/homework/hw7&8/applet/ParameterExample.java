import java.applet.*;
import java.awt.*;

public class ParameterExample extends Applet
{
    Color shapeColor;
    int size=20;
    float alpha=0f;
    public void init()
    {
        alpha=new Float(getParameter("alpha"));
        shapeColor=new Color(0.5f,0.5f,0.5f,alpha);
    }
    public void stop() {}
    public void paint(Graphics g)
    {
        for (int i=size; alpha>0 ; i-=5)
        {
            shapeColor=new Color(0.5f,0.5f,0.5f,alpha);
            g.setColor(shapeColor);
            g.fillRect(110+i,110+i,80-2*i,80-2*i); 
            alpha=alpha-0.1f;
        }
        g.setColor(Color.black);
    }
}
