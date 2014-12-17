// Title: Grid & Axes Include File v1.2
// Author: Michael Horvath
// Homepage: http://www.geocities.com/Area51/Quadrant/3864/email.htm
// Created: 2004/07/14
// Last Updated: 2008/01/09
// This file is licensed under the terms of the CC-LGPL.


//-----------------------------------------------------------------------------Macro

#macro Axes_Macro
	(
		Axes_axesSize,			// The distance from the origin to one of the grid's edges.	(float)
		Axes_majUnit,			// The size of each large-unit square.	(float)
		Axes_minUnit,			// The number of small-unit squares that make up a large-unit square.	(integer)
		Axes_thickRatio,		// The thickness of the grid lines (as a factor of Axes_axesSize).	(float)
		Axes_aBool,			// Turns the axes on/off. (boolian)
		Axes_mBool,			// Turns the minor units on/off. (boolian)
		Axes_xBool,			// Turns the plane perpendicular to the x-axis on/off.	(boolian)
		Axes_yBool,			// Turns the plane perpendicular to the y-axis on/off.	(boolian)
		Axes_zBool			// Turns the plane perpendicular to the z-axis on/off.	(boolian)
	)

	#declare Axes_Object = union
	{

		//-----------------------------------------------------------------------------Grid pigments

		#local Axes_xygrid_x_maj = pigment
		{
			gradient x
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_xygrid_y_maj = pigment
		{
			gradient y
			color_map
			{
				[0 rgbt <0.5, 0.5, 0.5, 0.5>]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_xygrid_x_min = pigment
		{
			gradient x
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_xygrid_y_min = pigment
		{
			gradient y
			color_map
			{
				[0 rgbt <0.5, 0.5, 0.5, 0.5>]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[1 rgbt 0.5]
			}
		}

		#local Axes_yzgrid_y_maj = pigment
		{
			gradient y
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_yzgrid_z_maj = pigment
		{
			gradient z
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_yzgrid_y_min = pigment
		{
			gradient y
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_yzgrid_z_min = pigment
		{
			gradient z
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit/2 rgbt 0.5]
				[1 rgbt 0.5]
			}
		}

		#local Axes_zxgrid_z_maj = pigment
		{
			gradient z
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_zxgrid_x_maj = pigment
		{
			gradient x
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_zxgrid_z_min = pigment
		{
			gradient z
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
		#local Axes_zxgrid_x_min = pigment
		{
			gradient x
			color_map
			{
				[0 rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 0.5]
				[Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 1]
				[1-Axes_thickRatio*Axes_axesSize/Axes_majUnit*Axes_minUnit rgbt 0.5]
				[1 rgbt 0.5]
			}
		}
	
		#local Axes_xaxis_dotted = pigment
		{
			gradient x
			color_map
			{
				[0 rgbt <1, 0, 0, 0.75>]
				[1/2 rgbt <1, 0, 0, 0.75>]
				[1/2 rgbt <0.5, 0.5, 0.5, 0.75>]
				[1 rgbt <0.5, 0.5, 0.5, 0.75>]
			}
		}
		#local Axes_yaxis_dotted = pigment
		{
			gradient y
			color_map
			{
				[0 rgbt <0, 1, 0, 0.75>]
				[1/2 rgbt <0, 1, 0, 0.75>]
				[1/2 rgbt <0.5, 0.5, 0.5, 0.75>]
				[1 rgbt <0.5, 0.5, 0.5, 0.75>]
			}
		}
		#local Axes_zaxis_dotted = pigment
		{
			gradient z
			color_map
			{
				[0 rgbt <0, 0, 1, 0.75>]
				[1/2 rgbt <0, 0, 1, 0.75>]
				[1/2 rgbt <0.5, 0.5, 0.5, 0.75>]
				[1 rgbt <0.5, 0.5, 0.5, 0.75>]
			}
		}
	
		//-----------------------------------------------------------------------------Grid
		
		union
		{
			#if (Axes_xBool = on)
				plane
				{
					x,
					0
					texture
					{
						Axes_yzgrid_y_maj
						scale Axes_majUnit
						translate <0, -1 * Axes_axesSize, -1 * Axes_axesSize>
					}
					texture
					{
						Axes_yzgrid_z_maj
						scale Axes_majUnit
						translate <0, -1 * Axes_axesSize, -1 * Axes_axesSize>
					}
					#if (Axes_mBool = 1)
						texture
						{
							Axes_yzgrid_y_min
							scale Axes_majUnit/Axes_minUnit
							translate <0, -1 * Axes_axesSize, -1 * Axes_axesSize>
						}
						texture
						{
							Axes_yzgrid_z_min
							scale Axes_majUnit/Axes_minUnit
							translate <0, -1 * Axes_axesSize, -1 * Axes_axesSize>
						}
					#end
				}
			#end
			#if (Axes_yBool = on)
				plane
				{
					y,
					0
					texture
					{
						Axes_zxgrid_z_maj
						scale Axes_majUnit
						translate <-1 * Axes_axesSize, 0, -1 * Axes_axesSize>
					}
					texture
					{
						Axes_zxgrid_x_maj
						scale Axes_majUnit
						translate <-1 * Axes_axesSize, 0, -1 * Axes_axesSize>
					}
					#if (Axes_mBool = 1)
						texture
						{
							Axes_zxgrid_z_min
							scale Axes_majUnit/Axes_minUnit
							translate <-1 * Axes_axesSize, 0, -1 * Axes_axesSize>
						}
						texture
						{
							Axes_zxgrid_x_min
							scale Axes_majUnit/Axes_minUnit
							translate <-1 * Axes_axesSize, 0, -1 * Axes_axesSize>
						}
					#end
				}
			#end
			#if (Axes_zBool = on)
				plane
				{
					z,
					0
					texture
					{
						Axes_xygrid_x_maj
						scale Axes_majUnit
						translate <-1 * Axes_axesSize, -1 * Axes_axesSize, 0>
					}
					texture
					{
						Axes_xygrid_y_maj
						scale Axes_majUnit
						translate <-1 * Axes_axesSize, -1 * Axes_axesSize, 0>
					}
					#if (Axes_mBool = 1)
						texture
						{
							Axes_xygrid_x_min
							scale Axes_majUnit/Axes_minUnit
							translate <-1 * Axes_axesSize, -1 * Axes_axesSize, 0>
						}
						texture
						{
							Axes_xygrid_y_min
							scale Axes_majUnit/Axes_minUnit
							translate <-1 * Axes_axesSize, -1 * Axes_axesSize, 0>
						}
					#end
				}
			#end
			clipped_by
			{
				box
				{
					<1 * Axes_axesSize, 1 * Axes_axesSize, 1 * Axes_axesSize>
					<-1 * Axes_axesSize, -1 * Axes_axesSize, -1 * Axes_axesSize>
				}
			}
		}
	
	
		//-----------------------------------------------------------------------------Cylinders, cones & text
		
		#if (Axes_aBool = on)
			union
			{
				cylinder
				{
					<0, 0, 0>,
					<Axes_axesSize, 0, 0>,
					Axes_thickRatio * Axes_axesSize
					pigment
					{
						rgbt <1, 0, 0, 0.75>
					}
				}
				cylinder
				{
					<-Axes_axesSize, 0, 0>,
					<0, 0, 0>,
					Axes_thickRatio * Axes_axesSize
					pigment
					{
						Axes_xaxis_dotted
						scale Axes_thickRatio * Axes_axesSize * 25
					}
				}
				cylinder
				{
					<0, 0, 0>,
					<0, Axes_axesSize, 0>,
					Axes_thickRatio * Axes_axesSize
					pigment
					{
						rgbt <0, 1, 0, 0.75>
					}
				}
				cylinder
				{
					<0, -Axes_axesSize, 0>,
					<0, 0, 0>,
					Axes_thickRatio * Axes_axesSize
					pigment
					{
						Axes_yaxis_dotted
						scale Axes_thickRatio * Axes_axesSize * 25
					}
				}
				cylinder
				{
					<0, 0, 0>,
					<0, 0, Axes_axesSize>,
					Axes_thickRatio * Axes_axesSize
					pigment
					{
						rgbt <0, 0, 1, 0.75>
					}
				}
				cylinder
				{
					<0, 0, -Axes_axesSize>,
					<0, 0, 0>,
					Axes_thickRatio * Axes_axesSize
					pigment
					{
						Axes_zaxis_dotted
						scale Axes_thickRatio * Axes_axesSize * 25
					}
				}
				cone
				{
					<0, 0, 0>,
					Axes_thickRatio * Axes_axesSize * 4
					<Axes_thickRatio * Axes_axesSize * 20, 0, 0>,
					0
					pigment
					{
						rgbt <1, 0, 0, 0.75>
					}
					translate <Axes_axesSize, 0, 0>
				}
				cone
				{
					<0, 0, 0>,
					Axes_thickRatio * Axes_axesSize * 4
					<0, Axes_thickRatio * Axes_axesSize * 20, 0>,
					0
					pigment
					{
						rgbt <0, 1, 0, 0.75>
					}
					translate <0, Axes_axesSize, 0>
				}
				cone
				{
					<0, 0, 0>,
					Axes_thickRatio * Axes_axesSize * 4
					<0, 0, Axes_thickRatio * Axes_axesSize * 20>,
					0
					pigment
					{
						rgbt <0, 0, 1, 0.75>
					}
					translate<0, 0, Axes_axesSize>
				}
				text
				{
					ttf "timrom.ttf"
					"X"
					0.05,
					0
					pigment
					{
						rgbt <1, 0, 0, 0.75>
					}
					scale Axes_thickRatio * Axes_axesSize * 20
					translate <Axes_thickRatio * Axes_axesSize * 20 + Axes_axesSize, 0, 0>
				}
				text
				{
					ttf "timrom.ttf"
					"Y"
					0.05,
					0
					pigment
					{
						rgbt <0, 1, 0, 0.75>
					}
					scale Axes_thickRatio * Axes_axesSize * 20
					translate <0, Axes_thickRatio * Axes_axesSize * 20 + Axes_axesSize, 0>
				}
				text
				{
					ttf "timrom.ttf"
					"Z"
					0.05,
					0
					pigment
					{
						rgbt <0, 0, 1, 0.75>
					}
					rotate <0, -90, 0>
					scale Axes_thickRatio * Axes_axesSize * 20
					translate <0, 0, Axes_thickRatio * Axes_axesSize * 20 + Axes_axesSize>
				}
			}
		#end
	}
#end