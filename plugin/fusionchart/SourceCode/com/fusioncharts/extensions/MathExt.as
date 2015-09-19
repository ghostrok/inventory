/**
 * @class MathExt
 * @author InfoSoft Global (P) Ltd.
 * @version 3.0
 *
 * Copyright (C) InfoSoft Global Pvt. Ltd. 2006
 
 * MathExt class bunches a group of mathematical functions
 * which will be used by other classes. All the functions in
 * this class are declared as static, as the methods do not
 * relate to any specific instance.
 */
class com.fusioncharts.extensions.MathExt {
	/**
	 * Private constructor function so that instances of 
	 * this class cannot be initialized.
	*/
	private function MathExt() {
		//Nothing to do.
	}
	/**
	 * numDecimals method returns the number of decimal places provided
	 * in the given number.
	 *	@param	num	Number for which we've to find the decimal places.
	 *	@returns	Number of decimal places found.
	*/
	public static function numDecimals(num:Number):Number {
		//Absolute value (to avoid floor disparity for negative num)
		num = Math.abs(num);
		//Get decimals
		var decimal:Number = num-Math.floor(num);
		//Number of decimals
		var numDecimals:Number = (String(decimal).length-2);
		//For integral values
		numDecimals = (numDecimals<0) ? 0 : numDecimals;
		//Return the length of string minus "0."
		return numDecimals;
	}
	/**
	 * toRadians method converts angle from degrees to radians
	 * @param	angle	The numeric value of the angle in 
	 * 					degrees
	 * @returns			The numeric value of the angle in radians
	 */
	public static function toRadians(angle:Number):Number {
		return (angle/180)*Math.PI;
	}
	/**
	 * toDegrees method converts angle from radians to degrees
	 * @param	angle	The numeric value of the angle in 
	 * 					radians
	 * @returns			The numeric value of the angle in degrees
	 */
	public static function toDegrees(angle:Number):Number {
		return (angle/Math.PI)*180;
	}
	/**
	 * remainderOf method calculates the remainder in 
	 * a division to the nearest twip.
	 * @param	a	dividend in a division
	 * @param	b	divisor in a division
	 * @returns		Remainder in the division rounded 
	 * 				to the nearest twip.
	 */
	public static function remainderOf(a:Number, b:Number):Number {
		var c:Number = Math.floor(a/b);
		return roundUp(a-b*c);
	}
	/**
	 * boundAngle method converts any angle in degrees
	 * to its equivalent in the range of 0 to 360 degrees.
	 * @param	angle	Angle in degrees to be procesed;
	 *					can take negetive values.
	 * @returns			Equivalent non-negetive angle in degrees
	 *					less than or equal to 360 degrees
	 */
	public static function boundAngle(angle:Number):Number {
		if (angle>=0) {
			return remainderOf(angle, 360);
		} else {
			return 360-remainderOf(Math.abs(angle), 360);
		}
	}
	/**
	 * toNearestTwip method converts a numeric value by
	 * rounding it to the nearest twip value ( one twentieth
	 * of a pixel ) for propermost rendering in flash.
	 * @param	num		Number to rounded
	 * @returns			Number rounded upto 2 decimal places and
	 *					second significant digit right of decimal
	 *					point, if exists at all is 5.
	 */
	public static function toNearestTwip(num:Number):Number {
		var n:Number = num;
		var s:Number = (n<0) ? -1 : 1;
		var k:Number = Math.abs(n);
		var r:Number = Math.round(k*100);
		var b:Number = Math.floor(r/5);
		var t:Number = Number(String(r-b*5));
		var m:Number = (t>2) ? b*5+5 : b*5;
		return s*(m/100);
	}
	/**
	 * roundUp method is defined to round up to 2 decimal 
	 * places (else can be a source of error).
	 * @param	param	number to be rounded
	 * @returns			number rounded
	 */
	public static function roundUp(param:Number):Number {
		param *= 100;
		param = Math.round(Number(String(param)));
		param /= 100;
		return param;
	}
}
