 /**
* @class ScrollSingleYAxis2DVerticalChart
* @author InfoSoft Global (P) Ltd. www.InfoSoftGlobal.com
* @version 3.0
*
* Copyright (C) InfoSoft Global Pvt. Ltd. 2005-2006
* ScrollSingleYAxis2DVerticalChart extends SingleYAxis2DVerticalChart class to encapsulate
* functionalities of a chart with scroll bars (horizontal)
*/
//Import parent class
import com.fusioncharts.core.SingleYAxis2DVerticalChart;
//Extensions
import com.fusioncharts.extensions.ColorExt;
import com.fusioncharts.extensions.StringExt;
import com.fusioncharts.extensions.MathExt;
import com.fusioncharts.extensions.DrawingExt;
//Import Logger Class
import com.fusioncharts.helper.Logger;
//Depth Manager
import com.fusioncharts.helper.DepthManager;
class com.fusioncharts.core.ScrollSingleYAxis2DVerticalChart extends SingleYAxis2DVerticalChart 
{
	//Instance variables
	//DepthManager instance. The DepthManager class helps us
	//allot and retrieve depths of various objects in the chart.
	private var canvasDm : DepthManager;
	//Constant value to indicate the minimum default number of points required
	//in data to enable scrolling by default. if the number of data points in XML
	//is less than the value defined here (and the user has not explicitly set
	//numVisiblePlots), we do not show the scroll bar.									  
	private var MIN_SCROLLPOINTS:Number = 10;
	/**
	* Constructor function. We invoke the super class'
	* constructor.
	*/
	function ScrollSingleYAxis2DVerticalChart (targetMC : MovieClip, depth : Number, width : Number, height : Number, x : Number, y : Number, debugMode : Boolean, lang : String)
	{
		//Invoke the super class constructor
		super (targetMC, depth, width, height, x, y, debugMode, lang);
		//Initialize Canvas depth manager
		this.canvasDm = new DepthManager (0);
	}
	//---------------------------- COMMON VISUAL RENDERING METHODS ------------------------------//
	/**
	* drawVLines method draws the vertical axis lines on the chart
	*/
	private function drawVLines () : Void 
	{
		var depth : Number = this.canvasDm.getDepth ("VLINES");
		//Movie clip container
		var vLineMC : MovieClip;
		//Get the reference of the CanvasMC
		var canvasMC:MovieClip = this.cMC[this.config.canvasMCName];
		canvasMC = canvasMC["DrawPlot_Canvas"];
		//Loop var
		var i : Number;
		//Iterate through all the v div lines
		for (i = 1; i <= this.numVLines; i ++)
		{
			if (this.vLines [i].isValid == true)
			{
				//If it's a valid line, create a movie clip
				vLineMC = canvasMC.createEmptyMovieClip ("vLine_" + i, depth);
				//Just draw line
				vLineMC.lineStyle (this.vLines [i].thickness, parseInt (this.vLines [i].color, 16) , this.vLines [i].alpha);
				//Now, if dashed line is to be drawn
				if ( ! this.vLines [i].isDashed)
				{
					//Draw normal line line keeping 0,0 as registration point
					vLineMC.moveTo (0, 0);
					vLineMC.lineTo (0, - this.elements.canvas.h);
				} else 
				{
					//Dashed Line line
					DrawingExt.dashTo (vLineMC, 0, 0, 0, - this.elements.canvas.h, this.vLines [i].dashLen, this.vLines [i].dashGap);
				}
				//Re-position line
				vLineMC._x = this.vLines [i].x;
				vLineMC._y = this.elements.canvas.h;
				//Apply animation
				if (this.params.animation)
				{
					this.styleM.applyAnimation (vLineMC, this.objects.VLINES, this.macro, null, 0, null, 0, 100, null, 100, null);
				}
				//Apply filters
				this.styleM.applyFilters (vLineMC, this.objects.VLINES);
				//Increase depth
				depth ++;
			}
		}
		delete vLineMC;
		//Clear interval
		clearInterval (this.config.intervals.vLine);
	}
	/**
	* reInit method re-initializes the chart. This method is basically called
	* when the user changes chart data through JavaScript. In that case, we need
	* to re-initialize the chart, set new XML data and again render.
	*/
	public function reInit () : Void 
	{
		//Invoke super class's reInit
		super.reInit ();
		//Change local parameters here
		//Reset depth manager
		this.canvasDm.clear ();
		this.canvasDm.setStartDepth (0);
	}
}
