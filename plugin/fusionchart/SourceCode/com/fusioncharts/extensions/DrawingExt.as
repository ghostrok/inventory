 /**
* @class DrawingExt
* @author InfoSoft Global (P) Ltd.
* @version 3.0
*
* Copyright (C) InfoSoft Global Pvt. Ltd. 2006
*
* Drawing class groups a bunch of drawing functions.
*/
class com.fusioncharts.extensions.DrawingExt 
{
	/**
	* Since DrawingExt class is just a grouping of drawming related methods,
	* we do not want any instances of it (as all methods wil be static).
	* So, we declare a private constructor
	*/
	private function DrawingExt ()
	{
		//Private constructor to avoid creation of instances
		
	}
	/**
	* dashTo method helps draw a dashed line between any two points
	* for the given movie, with the required spacing in between.
	*	Assumptions: Movie clip is already created and line style has
	*				 already been set before this method is called to
	*				 draw a dashed line.
	*	@param		mc		Movie clip in which we've to draw the line
	*	@param		x		Starting x Point from where dashed line needs
	*						to be drawn.
	*	@param		y		Starting y Point from where dashed line needs
	*						to be drawn.
	*	@param		toX		Ending x Point from where dashed line needs
	*						to end.
	*	@param		toY		Ending y Point from where dashed line needs
	*						to end.
	*	@param		len		Length of each dash.
	*	@param		gap		Gap between two dashes.
	*	@return			Boolean value indicating whether the line was
	*						successfully drawn.
	*/
	public static function dashTo (mc : MovieClip, x : Number, y : Number, toX : Number, toY : Number, len : Number, gap : Number) : Boolean 
	{
		//If we've less than 7 arguments (function parameters), we exit
		if (arguments.length < 7)
		{
			return false;
		}
		if (len <= 0)
		{
			return false;
		}
		//Variables to store calculation
		//dashLen indicates total dash length (including gap)
		var dashLen : Number = len + gap;
		//dX indicates the x displacement (starting, ending)
		var dX : Number = toX - x;
		//dY indicates y displacement
		var dY : Number = toY - y;
		//Distance indicates co-ordinate distance between 2 points
		//dis = sq. rt((toX-x)^2 + (toY-y)^2));
		var distance : Number = Math.sqrt (Math.pow (dX, 2) + Math.pow (dY, 2));
		//numDash indicates total dash segments that we need to draw
		//We take floor (so that partial dash is left out) of absolute
		//value(so that end X can be less than start X - and same with Y);
		var numDash : Number = Math.floor (Math.abs (distance / dashLen));
		//Angle indicates the angle of the line ATan of (dy/dX)
		var angle : Number = Math.atan2 (dY, dX);
		//sX and sY indicate start of line - counters
		var sX : Number = x;
		var sY : Number = y;
		//Add the segment length (discounted by the proper angle) to get
		//next line point (next dash segment start)
		dX = Math.cos (angle) * dashLen;
		dY = Math.sin (angle) * dashLen;
		//Now draw all the segments
		var i : Number = 0;
		for (i = 0; i < numDash; i ++)
		{
			//Move to starting point of this dash segment
			mc.moveTo (sX, sY);
			//Draw the line to the end of this dash segment (len)
			mc.lineTo (sX + Math.cos (angle) * len, sY + Math.sin (angle) * len);
			//Update sX and sY to include gap - so that they point to
			//start of next dash segment
			sX += dX;
			sY += dY;
		}
		//Now, the last dash segment can be less than 1*dashLen (as it
		//can be partial)
		//Move to the end of last drawn dash
		mc.moveTo (sX, sY);
		//Re-calculate the distance for the last dash - again using square root
		//distance method.
		distance = Math.sqrt (Math.pow ((toX - sX) , 2) + Math.pow ((toY - sY) , 2));
		//If the last dash length gets included in the dash length, we draw
		//it full.
		if (distance > len)
		{
			mc.lineTo (sX + Math.cos (angle) * len, sY + Math.sin (angle) * len);
		} else if (distance > 0)
		{
			//Else, it means that we do not have space to draw full dash
			//So, we draw only the remaining space.
			mc.lineTo (sX + Math.cos (angle) * distance, sY + Math.sin (angle) * distance);
		}
		//Move the drawing pointer to the end position- so that if further drawing is
		//done, it starts from the end position
		mc.moveTo (toX, toY);
		return true;
	}
	/**
	* drawPoly method helps draw a polygon based on the parameters specified.
	*	Assumptions: Movie clip is already created and line/fill style has
	*				 already been set before this method is called to
	*				 draw a polygon.
	*	@param		mc		Movie clip in which we've to draw the polygon
	*	@param		x		Center X position of the polygon
	*	@param		sides	Number of sides required for polygon (min 3).
	*	@param		startAngle	Starting angle of the polygon in degrees. Default is 0.
	*/
	public static function drawPoly (mc : MovieClip, x : Number, y : Number, sides : Number, radius : Number, startAngle : Number) : Void 
	{
		//If we've been given less than 5 arguments, return, as we cannot draw.
		if (arguments.length < 5)
		{
			return;
		}
		//Check if minimum 3 sides
		if (sides > 2)
		{
			//Default for starting angle
			startAngle = (startAngle == null || startAngle == undefined) ?0 : startAngle;
			//Variables to store incremental angle
			var incAngle : Number
			//Loop variable
			var i : Number;
			//Increment angle for each side
			incAngle = (Math.PI * 2) / sides;
			//Starting angle for polygon. Convert to radians.
			startAngle = (startAngle / 180) * Math.PI;
			//Move to initial position based on start angle
			mc.moveTo (x + (Math.cos (startAngle) * radius) , y - (Math.sin (startAngle) * radius));
			//Draw all the sides
			for (i = 1; i <= sides; i ++)
			{
				//Points are calculated by adding incremental angle and then using sin/cos.
				mc.lineTo ((x + Math.cos (startAngle + (incAngle * i)) * radius) , (y - Math.sin (startAngle + (incAngle * i)) * radius));
			}
		}
	}
}
