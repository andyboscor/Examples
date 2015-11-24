#include <stdio.h>
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

coords_grid_t path[16]; // will contain the path from finish to start

/**
 * Generate path to finishing coordinates and update
 * path variable
 */
 void generate_path(int x_end, int y_end) {

 	int k, i = 0;

 	path[i].x = x_end;
 	path[i].y = y_end;

 	int x_current = x_end;
 	int y_current = y_end;

 	int x_temp, y_temp;

 	while(x_current!=0 || y_current!=1) {

 		k = robot.map[x_current][y_current].value;

		//north
		x_temp = x_current; // values for northern square
		y_temp = y_current + 1;

		if(robot.map[x_current][y_current].walls[0] == 0
			&& x_temp <= 3 
			&& y_temp <= 4 
			&& x_temp >= 0
			&& y_temp >= 1
			&& robot.map[x_temp][y_temp].value == k-1) // if northern square exists and has value k-1
		{
			path[++i].x = x_temp;
			path[i].y = y_temp;
		}
		else 
		{
			//east
			x_temp = x_current+1; // values for eastern square
			y_temp = y_current;

			if(robot.map[x_current][y_current].walls[1] == 0 && x_temp <= 3 && y_temp <= 4 && x_temp >= 0 && y_temp >= 1 && robot.map[x_temp][y_temp].value == k-1) // if eastern square exists and has value k-1
			{
				path[++i].x = x_temp;
				path[i].y = y_temp;
			}
			else 
			{ 
				//south
				x_temp = x_current; // values for southern square
				y_temp = y_current-1;

				if(robot.map[x_current][y_current].walls[2]==0 && x_temp<=3 && y_temp<=4 && x_temp>=0 && y_temp >=1 && robot.map[x_temp][y_temp].value ==k-1) // if southern square exists and has value k-1
				{
					path[++i].x = x_temp;
					path[i].y = y_temp;
				}
				else
				{
					//west
					x_temp = x_current-1; // values for western square
					y_temp = y_current;

					if(robot.map[x_current][y_current].walls[3]==0
						&& x_temp<=3
						&& y_temp<=4
						&& x_temp>=0
						&& y_temp >=1
						&& robot.map[x_temp][y_temp].value ==k-1) // if western square exists and has value k-1
					{
						path[++i].x = x_temp;
						path[i].y = y_temp;
					}

				}

			}

		}


			x_current = x_temp;
			y_current = y_temp;
	}

	for(i=0;i<=6;i++) {  
		printf("Shortest path\n");
		printf("%i %i\n", path[i].x, path[i].y);
	}

	robot.path_array_length = i;
}
