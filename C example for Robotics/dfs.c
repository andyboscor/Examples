#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Recursive depth first search of maze
 */
void dfs(int x, int y, double angle) {
	hr();

	printf("### DFS on: [%d,%d] | %f", x, y, angle);

	robot.map[x][y].visited = 1;

	scan();

	//Front
	int x_target = x + (int) round(cos(angle));
	int y_target = y + (int) round(sin(angle));

	printf("Orientation %d\n", robot.orientation);
	printf("Current coordinates:  %d %d \n", robot.grid_pos.x, robot.grid_pos.y);

	printf("Front Target DFS: [%d, %d]\n", x_target, y_target);

	if(!robot.map[x_target][y_target].visited && !has_wall(0)) { //Check if is not visited and no front wall
		printf("DFS: Moving forward\n");

		move_direction(0);

		dfs(x_target, y_target, angle);

		//Backtrack

		printf("Backtracking forward call...\n");
		move_direction(2);
		rotate(2);
	}

	//Left
	x_target = x + (int) round(cos(angle + (M_PI / 2)));
	y_target = y + (int) round(sin(angle + (M_PI / 2)));

	printf("Left Target DFS: [%d, %d]\n", x_target, y_target);

	if(!robot.map[x_target][y_target].visited && !has_wall(-1)) { //Check if is not visited and no left wall
		printf("DFS: Going left\n");
		move_direction(-1);

		dfs(x_target, y_target, angle + (M_PI / 2));

		//Backtrack
		printf("Backtracking left call...\n");
		move_direction(2);
		rotate(-1);
	}

	//Right
	x_target = x + (int) round(cos(angle - (M_PI / 2)));
	y_target = y + (int) round(sin(angle - (M_PI / 2)));

	printf("-- Angle: %f\n", angle);
	printf("-- round: %d\n", (int) round(sin(angle + (M_PI / 2))));

	printf("Right Target DFS: [%d, %d]\n", x_target, y_target);

	if(!robot.map[x_target][y_target].visited && !has_wall(1)) { //Check if is not visited and no right wall
		printf("DFS: Going right\n");
		move_direction(1);

		dfs(x_target, y_target, angle + ((3 * M_PI) / 2));

		//Backtrack
		printf("Backtracking right call...\n");
		move_direction(2);
		rotate(1);
	}
}