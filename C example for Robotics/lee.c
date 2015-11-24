#include <stdio.h>
#include <unistd.h>
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Lee pathfinding algorithm to find the shortest path
 * from start to finish
 */
void lee(int x_leaving, int y_leaving) {

	coords_grid_t node = {.x = x_leaving, .y = y_leaving};
	enqueue(node);
	coords_grid_t element;

	int k = 1, i, j;

	// Setting all values to 0
	for(j=4;j>=1;j--)
			for(i=0;i<=3;i++)
				robot.map[i][j].value = 0;

	//Setting the leaving point to 1
	robot.map[x_leaving][y_leaving].value = k;

	int x_current, y_current;
	
	while(!is_queue_empty()) {
		
		//getting first element from queue
		element = first();
		x_current=element.x;
		y_current=element.y;


		dequeue();
		k = robot.map[x_current][y_current].value;

		//north
		if(robot.map[x_current][y_current].walls[0]==0 && x_current<=3 && (y_current+1)<=4 && x_current>=0 && (y_current+1) >=1 && robot.map[x_current][y_current+1].value ==0) {
			robot.map[x_current][y_current + 1].value = k + 1;
			node.x = x_current;
			node.y = y_current+1;
			enqueue(node);
		}

		//east
		if(robot.map[x_current][y_current].walls[1]==0  && x_current+1<=3 && y_current<=4 && x_current+1>=0 && y_current >=1 && robot.map[x_current+1][y_current].value ==0) {
			robot.map[x_current+1][y_current].value = k + 1;
			node.x = x_current+1;
			node.y = y_current;
			enqueue(node);
		}

		//south
		if(robot.map[x_current][y_current].walls[2]==0 && x_current<=3 && y_current-1<=4 && x_current>=0 && y_current-1 >=1 && robot.map[x_current][y_current-1].value ==0) {
			robot.map[x_current][y_current - 1].value = k + 1;
			node.x = x_current;
			node.y = y_current-1;
			enqueue(node);
		}

		//west
		if(robot.map[x_current][y_current].walls[3]==0 && x_current-1<=3 && y_current<=4 && x_current-1>=0 && y_current >=1 && robot.map[x_current-1][y_current].value ==0) {
			robot.map[x_current - 1][y_current].value = k + 1;
			node.x = x_current-1;
			node.y = y_current;
			enqueue(node);
			
		}
	}

	
}
